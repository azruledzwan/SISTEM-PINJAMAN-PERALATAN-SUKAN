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

$colname1_Recordset1 = "-1";
if (isset($_GET['nokppeminjam'])) {
  $colname1_Recordset1 = $_GET['nokppeminjam'];
}
mysql_select_db($database_alatansukan, $alatansukan);
$query_Recordset1 = sprintf("SELECT * FROM pinjaman,peralatan,peminjam WHERE pinjaman.nokppeminjam = %s AND pinjaman.kodperalatan = peralatan.kodperalatan ORDER BY tarikhpinjam ASC", GetSQLValueString($colname1_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $alatansukan) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_alatansukan, $alatansukan);
$query_Recordset1 = "SELECT * FROM pinjaman INNER JOIN peralatan WHERE peralatan.kodperalatan = pinjaman.kodperalatan";
$Recordset1 = mysql_query($query_Recordset1, $alatansukan) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);$colname1_Recordset1 = "-1";
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
	color: #F00;<?php echo $row_Recordset1['']; ?>
}
.logout a {
	background-color: #F00;
}
.L {
	text-align: left;
}
</style>
</head>

<body ><h1 style="font-size: 40px; text-align: center;"><span style="font-size: 24px; text-align: center;"></span>SISTEM PINJAMAN PERALATAN SUKAN</h1>
<p style="font-size: 24px; text-align: center;">SMK TUANKU LAILATUL SHAHREEN</p>
<center>
  <p><strong>LAPORAN PINJAMAN PERALATAN SUKAN</strong></p>
  <p>&nbsp;</p>
	<div style="width:1050px" >
    <p><center><img src="../image/<?php echo $row_Recordset1['gambar']; ?>" width="114" height="116" /></center></p>
	<p class="L">NAMA PEMINJAM 		:  <b><?php echo $row_Recordset1['namapeminjam']; ?></b></p>
    <p class="L">NO. KP PEMINJAM		:  <b><?php echo $row_Recordset1['nokppeminjam']; ?> </b>       </p>
    <p class="L">NO. TEL PEMINJAM		:  <b><?php echo $row_Recordset1['notelpeminjam']; ?></b></p>
  <p>&nbsp;</p>
  <table border="1" cellpadding="0" cellspacing="0" width="1050px" align="center">
    <tr align="center">
      <td align="center">Nama Peralatan</td>
      <td>Jenama Peralatan</td>
      <td>Tujuan Pinjaman</td>
      <td>Kuantiti Pinjam</td>
      <td>Tarikh Pinjam</td>
      <td>Kuantiti Pulang</td>
      <td>Tarikh Pulang</td>
      <td>Status</td>
    </tr>
    <?php do { ?>
      <tr align="center">
        <td><?php echo $row_Recordset1['namaperalatan']; ?></td>
        <td><?php echo $row_Recordset1['jenamaperalatan']; ?></td>
        <td><?php echo $row_Recordset1['tujuanpinjaman']; ?></td>
        <td><?php echo $row_Recordset1['kuantitipinjam']; ?></td>
        <td><?php echo $row_Recordset1['tarikhpinjam']; ?></td>
        <td><?php echo $row_Recordset1['kuantitipulang']; ?></td>
        <td><?php echo $row_Recordset1['tarikhpulang']; ?></td>
        <td><?php echo $row_Recordset1['status']; ?></td>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
  </table>
    </div><br />
    <form id="form1" name="form1" method="post" action="">
  <div align="center">
  <button onclick="window.location='laporan.php';" type="button">KEMBALI</button>
 <input type="submit" name="button" id="button" value="CETAK LAPORAN" onclick="window.print()" />
 </div>
</form>
</center>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
