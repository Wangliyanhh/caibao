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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['idnumber'])) {
  $loginUsername=$_POST['idnumber'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "user_role";
  $MM_redirectLoginSuccess = "login-true.php";
  $MM_redirectLoginFailed = "login-false.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conn, $conn);
  	
  $LoginRS__query=sprintf("SELECT id, user_password, user_role FROM `user` WHERE id=%s AND user_password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'user_role');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>用户登录</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#form {
	position: relative;
	top: 20%;
}
</style>
<script type="text/javascript">
window.onload=function(){
        document.getElementById("right").style.height = document.getElementById("left").offsetHeight+"px";
    }
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
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
      <img src="image/login.jpg" class="img-responsive"  alt="财宝" />
      </div>
      <div id="right" class="col-md-3" style="background-color:rgb(236,236,236)">
      <div id="form">
      <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" name="from1" class="form-horizontal" onsubmit="MM_validateForm('idnumber','','RisNum','password','','R');return document.MM_returnValue" role="form">
      <div class="text-center">
                    <h2>用户登录</h2>
                </div>
        <div class="form-group">
    	  <div class="col-sm-12">
      	    <input name="idnumber" type="text" class="form-control" id="idnumber" placeholder="请输入工号" maxlength="18">
    	  </div>
        </div>
        <div class="form-group">
        <div class="col-sm-12">
            <input name="password" type="password" class="form-control" id="password" placeholder="请输入密码" maxlength="20">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
              <label>
              <input type="checkbox">请记住我
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <a class="btn btn-primary" href="http://localhost/caibao/reg.php">注册</a>
            <input type="submit" class="btn btn-primary" value="登录"></input>
          </div>
        </div>
      </form>
      </div>
      <br />
      <br />
      <br />
      <br />
      <br />
      <a href="search-pass.php">【忘记密码？】</a>
     </div>            
   </div>
</div>
<div class="modal-footer">
  <p class="text-muted text-center">All Copyrights Reserved © 电子科技大学计划财务处<br />技术支持 计算机学科交叉与创新实验室</p>
</div>
</body>
</html>