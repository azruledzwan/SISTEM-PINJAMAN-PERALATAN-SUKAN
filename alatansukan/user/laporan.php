<?php require_once('../Connections/alatansukan.php');?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



$colname1_Recordset1 = "-1";
if (isset($_GET['nokppeminjam'])) {
  $colname1_Recordset1 = $_GET['nokppeminjam'];
}
mysql_select_db($database_alatansukan, $alatansukan);
$query_Recordset1 = sprintf("SELECT * FROM pinjaman
INNER JOIN peralatan ON peralatan.kodperalatan = pinjaman.kodperalatan 
INNER JOIN peminjam ON pinjaman.nokppeminjam = peminjam.nokppeminjam
WHERE pinjaman.nokppeminjam = %s 
ORDER BY tarikhpinjam ASC", GetSQLValueString($colname1_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $alatansukan) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
  <p><strong>LAPORAN PINJAMAN PERALATAN SUKAN</strong></p>
</center>
<form action="detaillaporan.php" method="get" name="form2" id="form2">
  <table width="421" border="1" align="center">
    <tr>
      <td width="261">Masukkan No Kad Pengenalan Peminjam</td>
      <td width="144"><label>
        <input type="text" name="nokppeminjam" id="nokppeminjam" maxlength="12" />
      </label></td>
    </tr>
    <tr>
      <td colspan="2"><br /><center><input type="submit" name="button" id="button" value="CARI LAPORAN" /></center><br /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
