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

$colname_Recordset1 = "-1";
if (isset($_GET['question_id'])) {
  $colname_Recordset1 = $_GET['question_id'];
}
mysql_select_db($database_conn, $conn);
$query_Recordset1 = sprintf("SELECT * FROM qustion_answer WHERE question_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
$update= sprintf("UPDATE qustion_answer SET visit_time=visit_time+1 WHERE question_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$result1=mysql_query($update,$conn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>财宝财务咨询系统</title>
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
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
        <li><a href="index.php">回到首页</a></li>
        <li><a href="login.php">注册/登录</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container">
	<div class="input-group">  
    <input type="text" class="form-control input-lg"placeholder="请输入关键字" / >  
    	<span class="input-group-btn">  
        <button type="submit" class="btn btn-primary btn-lg ">查找</button>  
      </span>  
  </div>
  <div class="panel panel-default">
  	<div class="panel-heading">
    	<h3 class="panel-title"><?php echo $row_Recordset1['question']; ?><br />
      <small><?php echo $row_Recordset1['question_key']; ?></small></h3>
    </div>
    <div class="panel-body">
    	<p class="text-justify"><?php echo $row_Recordset1['answer']; ?></p>
    </div>
    <div class="panel-footer">
    	<a href="ask.php"><h3 class="text-primary">如果财宝没有让您满意，请找我妈妈吧，财宝会好好学习，天天向上滴!</h3></a>
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
