<?php require_once('../Connections/alatansukan.php');?><?php require_once('../Connections/alatansukan.php'); ?>
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
 $updateSQL = sprintf("UPDATE pinjaman SET kuantitipulang=%s, tarikhpulang=%s, statusperalatanrosak=%s, status=%s WHERE idpinjaman=%s",
                       GetSQLValueString($_POST['kuantitipulang'], "text"),
                       GetSQLValueString($_POST['tarikhpulang'], "date"),
                       GetSQLValueString($_POST['statusperalatanrosak'], "text"),
					   GetSQLValueString($_POST['status'], "text"),
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

mysql_select_db($database_alatansukan, $alatansukan);
$query_Recordset1 = "SELECT * FROM pinjaman INNER JOIN peralatan WHERE peralatan.kodperalatan = pinjaman.kodperalatan";
$Recordset1 = mysql_query($query_Recordset1, $alatansukan) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_alatansukan, $alatansukan);
 $query_DetailRS1 = sprintf("SELECT * FROM pinjaman INNER JOIN peralatan WHERE peralatan.kodperalatan = pinjaman.kodperalatan AND nokppeminjam = %s", GetSQLValueString($colname_DetailRS1, "text"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $alatansukan) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
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
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
</head>

<body ><h1 style="font-size: 40px; text-align: center;"><span style="font-size: 24px; text-align: center;"></span>SISTEM PINJAMAN PERALATAN SUKAN</h1>
<p style="font-size: 24px; text-align: center;">SMK TUANKU LAILATUL SHAHREEN</p>
<center>
  <p><a href="index.php">LAMAN UTAMA</a> | <a href="daftarpeminjam.php">DAFTAR PEMINJAM</a> | <a href="daftarperalatan.php">DAFTAR PERALATAN</a> | <a href="pinjamperalatan.php">PINJAM PERALATAN</a> | <a href="pulangperalatan.php">PULANG PERALATAN</a> | <a href="carian.php">CARIAN</a> | <a href="laporan.php">LAPORAN</a> | <span class="logout"><a href="<?php echo $logoutAction ?>">LOG KELUAR</a></span></p>
  <p>&nbsp;</p>
  <p><strong>BORANG PEMULANGAN PERALATAN SUKAN</strong></p>
</center>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
 
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nokp Peminjam:</td>
      <td><input name="nokppeminjam" type="text" value="<?php echo $row_DetailRS1['nokppeminjam']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kodperalatan:</td>
      <td><input name="kodperalatan" type="text" value="<?php echo $row_DetailRS1['kodperalatan']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nama Peralatan</td>
      <td><?php echo $row_DetailRS1['namaperalatan']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tujuan Pinjaman:</td>
      <td><input name="tujuanpinjaman" type="text" value="<?php echo $row_DetailRS1['tujuanpinjaman']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kuantiti Pinjam:</td>
      <td><input name="kuantitipinjam" type="text" value="<?php echo $row_DetailRS1['kuantitipinjam']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tarikh Pinjam:</td>
      <td><input name="tarikhpinjam" type="text" value="<?php echo $row_Recordset1['tarikhpinjam']; ?>" size="32" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kuantiti Pulang:</td>
      <td><span id="sprytextfield1">
        <input type="text" name="kuantitipulang" value="<?php echo htmlentities($row_Recordset1['kuantitipulang'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tarikh Pulang:</td>
      <td><input type="date" name="tarikhpulang" value="<?php echo htmlentities($row_Recordset1['tarikhpulang'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Status Peralatan Rosak:</td>
      <td> <select name="statusperalatanrosak" id="statusperalatanrosak">
  <option value="TIDAK ROSAK">TIDAK ROSAK</option>
  <option value="ROSAK">ROSAK</option>
  </select></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" nowrap="nowrap"><br /><center><input type="submit" name="button" id="button" value="PULANG PERALATAN" /></center><br /></td>
    </tr>
  </table>
  <input type="hidden" name="idpinjaman" value="<?php echo $row_DetailRS1['idpinjaman']; ?>" />
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="status" value="SUDAH PULANG" />

</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($DetailRS1);
?>
