<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>用户注册</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
</style>
<script type="text/javascript">
    window.onload=function(){
        document.getElementById("right").style.height = document.getElementById("left").offsetHeight+"px";
    }
</script>
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
        <li><a href="http://localhost/caibao/index.php">回到首页</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container">
   <div class="row">
      <div id="left" class="col-md-9">
      <img src="image/reg.jpg" class="img-responsive"  alt="财宝" />
      </div>
      <div id="right" class="col-md-3" style="background-color:rgb(236,236,236);"> 
       <h2 class="text-center">恭喜，注册成功！</h2>
  		 <a href="login.php"><p class="text-center">去登录</p></a>
      </div>
   </div>
</div>
  
<div class="modal-footer">
  <p class="text-muted text-center">All Copyrights Reserved © 电子科技大学计划财务处<br />技术支持 计算机学科交叉与创新实验室</p>
</div>
</body>
</html>