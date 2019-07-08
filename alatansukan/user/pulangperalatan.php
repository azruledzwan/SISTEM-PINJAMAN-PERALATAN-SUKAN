<?php require_once('../Connections/alatansukan.php'); ?>
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
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO login (idpengguna, username, password, nokp) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['idpengguna'], "int"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['nokp'], "text"));

  mysql_select_db($database_alatansukan, $alatansukan);
  $Result1 = mysql_query($insertSQL, $alatansukan) or die(mysql_error());

  $insertGoTo = "berjayadaftarlogin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pinjaman SET nokppeminjam=%s, kodperalatan=%s, tujuanpinjaman=%s, kuantitipinjam=%s, tarikhpinjam=%s, kuantitipulang=%s, tarikhpulang=%s, statusperalatanrosak=%s WHERE idpinjaman=%s",
                       GetSQLValueString($_POST['nokppeminjam'], "text"),
                       GetSQLValueString($_POST['kodperalatan'], "text"),
                       GetSQLValueString($_POST['tujuanpinjaman'], "text"),
                       GetSQLValueString($_POST['kuantitipinjam'], "int"),
                       GetSQLValueString($_POST['tarikhpinjam'], "date"),
                       GetSQLValueString($_POST['kuantitipulang'], "text"),
                       GetSQLValueString($_POST['tarikhpulang'], "date"),
                       GetSQLValueString($_POST['statusperalatanrosak'], "text"),
                       GetSQLValueString($_POST['idpinjaman'], "int"));

  mysql_select_db($database_alatansukan, $alatansukan);
  $Result1 = mysql_query($updateSQL, $alatansukan) or die(mysql_error());

  $updateGoTo = "berjayapulang.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_alatansukan, $alatansukan);
$query_Recordset1 = "SELECT nokppeminjam, kodperalatan, tujuanpinjaman, kuantitipinjam, tarikhpinjam, status FROM pinjaman WHERE status LIKE 'BELUM PULANG'";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $alatansukan) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>e-ALATAN SUKAN</title>
<style type="text/css">
.logout {
	color: #F00;
}
.logout a {
	background-color: #F00;
}
</style>
</head>

<body ><h1 style="font-size: 40px; text-align: center;"><span style="font-size: 24px; text-align: center;"></span>SISTEM PINJAMAN PERALATAN SUKAN</h1>
<p style="font-size: 24px; text-align: center;">SMK TUANKU LAILATUL SHAHREEN</p>
<center>
  <p><a href="index.php">LAMAN UTAMA</a> | <a href="daftarpeminjam.php">DAFTAR PEMINJAM</a> | <a href="daftarperalatan.php">DAFTAR PERALATAN</a> | <a href="pinjamperalatan.php">PINJAM PERALATAN</a> | <a href="pulangperalatan.php">PULANG PERALATAN</a> | <a href="carian.php">CARIAN</a> | <a href="laporan.php">LAPORAN</a> | <span class="logout"><a href="<?php echo $logoutAction ?>">LOG KELUAR</a></span></p>
  <p>&nbsp;</p>
  <p><strong>BORANG PEMULANGAN PERALATAN SUKAN</strong></p>
</center>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <center>
  <table border="1" align="center">
    <tr>
      <td>nokppeminjam</td>
      <td>kodperalatan</td>
      <td>tujuanpinjaman</td>
      <td>kuantitipinjam</td>
      <td>tarikhpinjam</td>
      <td>status</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><a href="detailpeminjam.php?recordID=<?php echo $row_Recordset1['nokppeminjam']; ?>"> <?php echo $row_Recordset1['nokppeminjam']; ?>&nbsp; </a></td>
        <td><?php echo $row_Recordset1['kodperalatan']; ?>&nbsp; </td>
        <td><?php echo $row_Recordset1['tujuanpinjaman']; ?>&nbsp; </td>
        <td><?php echo $row_Recordset1['kuantitipinjam']; ?>&nbsp; </td>
        <td><?php echo $row_Recordset1['tarikhpinjam']; ?>&nbsp; </td>
        <td><?php echo $row_Recordset1['status']; ?>&nbsp; </td>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  </table>
  </center>
  <br />
  

</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
