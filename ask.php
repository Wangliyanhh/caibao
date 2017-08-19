<?php require_once('Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "ask")) {
  $insertSQL = sprintf("INSERT INTO ask_question (user_id, ask_detail, ask_office) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['question'], "text"),
                       GetSQLValueString($_POST['inlineRadioOptions'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "ask-true.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn, $conn);
$query_Recordset1 = sprintf("SELECT user_id FROM `user` WHERE id = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
        <li><a>欢迎您：<?php echo $_SESSION['MM_Username']; ?></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="container">
	<div class="page-header">
  	<h1 class="text-center">留言提问</h1>
	</div>
	<form action="<?php echo $editFormAction; ?>" name="ask" id="ask" method="POST" >
  	<input type="hidden" name="id" value="<?php echo $row_Recordset1['user_id']; ?>" />
  	<div class="form-group">
  	<label>请选择业务类型：</label>
		<label class="radio-inline">
  		<input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="酬金业务"> 酬金业务
		</label>
		<label class="radio-inline">
 		 <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="日常报销"> 日常报销
		</label>
		<label class="radio-inline">
  		<input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="借款业务"> 借款业务
		</label>
    </div>
    <div class="form-group">
    	<label for="question">请输入问题内容：</label>
    	<textarea name="question" id="question" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group" style="text-align:center">
    	<button type="submit" class="btn btn-primary" style="display:inline">提交</button>
    </div>
    <input type="hidden" name="MM_insert" value="ask" />
  </form>
</div>

<div class="modal-footer">
  <p class="text-muted text-center">All Copyrights Reserved © 电子科技大学计划财务处<br />技术支持 计算机学科交叉与创新实验室</p>
</div>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
