<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
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
        <li><a class="text-info">欢迎您:<?php echo $_SESSION['MM_Username']; ?> |</a></li>
        <li><a href="<?php echo $logoutAction ?>" class="text-info">退出登录</a></li>        
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
	    <div class="input-group col-md-offset-2 col-md-8">  
           <input type="text" class="form-control input-lg"placeholder="请输入关键字" / >  
                <span class="input-group-btn">  
                   <button type="submit" class="btn btn-primary btn-lg ">查找</button>  
                </span>  
     </div>
</div>  
<div class="container">
</div>
<div class="modal-footer">
  <p class="text-muted text-center">All Copyrights Reserved © 电子科技大学计划财务处<br />技术支持 计算机学科交叉与创新实验室</p>
</div>
</body>
</html>