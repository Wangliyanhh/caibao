<?php require_once('Connections/conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_Recordset1 = 5;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_conn, $conn);
$query_Recordset1 = "SELECT * FROM qustion_answer ORDER BY visit_time DESC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>财宝财务咨询系统</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
  <style type="text/css">
	#image {
	overflow-y: scroll;
	height: 360px;
}
  </style>
</head>

<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand">成电财宝</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.php">注册/登录</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container">
	<div class="row">
  	<div class="col-md-12" id="image">
			<div id="myCarousel" class="carousel slide">
    		<!-- 轮播（Carousel）指标 -->
    		<ol class="carousel-indicators">
        	<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        	<li data-target="#myCarousel" data-slide-to="1"></li>
        	<li data-target="#myCarousel" data-slide-to="2"></li>
          <li data-target="#myCarousel" data-slide-to="3"></li>
   		 </ol>   
    	 <!-- 轮播（Carousel）项目 -->
    	 <div class="carousel-inner">
         <div class="item active">
         	 <img src="/caibao/image/login.jpg" alt="First slide">
         </div>
         <div class="item">
           <img src="/caibao/image/reg.jpg" alt="Second slide">
         </div>
         <div class="item">
           <img src="/caibao/image/3.jpg" alt="Third slide">
         </div>
         <div class="item">
           <img src="image/4.jpg" alt="Forth slide">
         </div>
      	</div>
    		<!-- 轮播（Carousel）导航 -->
    		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
			</div>
  	</div>
  </div>
</div>
<div class="container" style="margin-top:15px">
	<form action="show-result.php" method="get">
  <div class="input-group">  
    <input  name="key" id="key" type="text" class="form-control input-lg" placeholder="请输入关键字" />  
    	<span class="input-group-btn">  
        <button type="submit" class="btn btn-primary btn-lg ">查找</button>  
      </span>  
  </div>
  </form>
  <div class="panel panel-default">
  	<div class="panel-heading">
    	<h3 class="panel-title">分类导航</h3>
  	</div>
    <!-- List group -->
  	<ul class="list-group">
    	<li class="list-group-item"><a href="show-result.php?key=<?php echo urlencode("酬金业务"); ?>">请问您是要咨询“酬金业务”问题吗？</a></li>
    	<li class="list-group-item"><a href="show-result.php?key=<?php echo urlencode("日常报销"); ?>">请问您是要咨询“日常报销”问题吗？</a></li>
    	<li class="list-group-item"><a href="show-result.php?key=<?php echo urlencode("借款业务"); ?>">请问您是要咨询“借款业务”问题吗？</a></li>
  	</ul>
	</div>        
  <div class="panel panel-default">
  	<div class="panel-heading">
    	<h3 class="panel-title">常见问题</h3>
  	</div>
    <!-- List group -->
  	<ul class="list-group">
    	<?php do { ?>
    	  <li class="list-group-item"><a href="show-answer.php?quesion_id=<?php echo $Recordset1['question_id']; ?>"><?php echo $row_Recordset1['question']; ?></a></li>
    	  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  	</ul>
	</div>      
</div>  

<div class="modal-footer">
  <p class="text-muted text-center">All Copyrights Reserved © 电子科技大学计划财务处<br />技术支持 计算机学科交叉与创新实验室</p>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
