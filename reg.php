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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="reg-false.php";
  $loginUsername = $_POST['idnumber'];
  $LoginRS__query = sprintf("SELECT id FROM `user` WHERE id=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_conn, $conn);
  $LoginRS=mysql_query($LoginRS__query, $conn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO user (user_name, id, user_password, user_role) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['idnumber'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['role'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "reg-true.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
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
      <div class="text-center">
          <h2>用户注册</h2>
        </div>
        <form action="<?php echo $editFormAction; ?>" name="form1" method="POST" id="form1" class="form-horizontal" role="form">
          <div class="form-group">
          <select name="role" class="form-control" id="role">
            <option selected="selected">教师</option>
            <option>学生</option>
            <option>职工</option>
          </select>
          </div>
          <div class="form-group">      
      	    <input name="name" type="text" class="form-control" id="name" placeholder="请输入姓名" maxlength="20">
    	    </div>
          <div class="form-group">      	    
            <input name="idnumber" type="text" class="form-control" id="idnumber" placeholder="请输入工号" maxlength="20">
    	    </div>
          <div class="form-group">
            <input name="password" type="password" class="form-control" id="password" placeholder="请输入密码" maxlength="20">
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-block btn-primary" value="注册">
          </div>
          <input type="hidden" name="MM_insert" value="form1" />
        </form>
     </div>            
   </div>
</div>

<div class="modal-footer">
  <p class="text-muted text-center">All Copyrights Reserved © 电子科技大学计划财务处<br />技术支持 计算机学科交叉与创新实验室</p>
</div>
</body>
</html>