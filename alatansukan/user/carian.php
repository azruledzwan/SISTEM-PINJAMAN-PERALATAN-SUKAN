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

$colname1_Recordset1 = "-1";
if (isset($_GET['kodperalatan'])) {
  $colname1_Recordset1 = $_GET['kodperalatan'];
}
mysql_select_db($database_alatansukan, $alatansukan);
$query_Recordset1 = sprintf("SELECT * FROM pinjaman, peralatan, peminjam WHERE peralatan.kodperalatan = %s AND pinjaman.kodperalatan = peralatan.kodperalatan AND peminjam.nokppeminjam = pinjaman.nokppeminjam AND status LIKE 'BELUM PULANG' ", GetSQLValueString($colname1_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $alatansukan) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_alatansukan, $alatansukan);
$query_Recordset2 = "SELECT * FROM peralatan";
$Recordset2 = mysql_query($query_Recordset2, $alatansukan) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
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
#form2 table tr td {
	text-align: center;
}
.P {
	text-align: center;
}
.c {
	text-align: center;
}
</style>
</head>

<body ><h1 style="font-size: 40px; text-align: center;"><span style="font-size: 24px; text-align: center;"></span>SISTEM PINJAMAN PERALATAN SUKAN</h1>
<p style="font-size: 24px; text-align: center;">SMK TUANKU LAILATUL SHAHREEN</p>
<center>
  <p><a href="index.php">LAMAN UTAMA</a> | <a href="daftarpeminjam.php">DAFTAR PEMINJAM</a> | <a href="daftarperalatan.php">DAFTAR PERALATAN</a> | <a href="pinjamperalatan.php">PINJAM PERALATAN</a> | <a href="pulangperalatan.php">PULANG PERALATAN</a> | <a href="carian.php">CARIAN</a> | <a href="laporan.php">LAPORAN</a> | <span class="logout"><a href="<?php echo $logoutAction ?>">LOG KELUAR</a></span></p>
  <p>&nbsp;</p>
  <p><strong>CARIAN PERALATAN SUKAN</strong></p>
</center>
<form action="<?php echo $editFormAction; ?>" method="get" name="form2" id="form2">
  <table width="460" border="1" align="center">
    <tr>
      <td colspan="2">Semakan Bilangan Peralatan yang ada di bilik sukan</td>
    </tr>
    <tr>
      <td width="118">Nama Peralatan</td>
      <td width="107"><label>
        <select name="kodperalatan" id="kodperalatan">
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset2['kodperalatan']?>"><?php echo $row_Recordset2['kodperalatan']?></option>
          <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="cari" value="CARI" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form2" />
</form>
<p class="P">&nbsp;
<table border="1" align="center">
  <tr>
    
    <td>Kod Peralatan</td>
    <td>Nama Peralatan</td>
    <td>Jenama Peralatan</td>
    <td>Bilangan Stok asal</td>
    <td>Kuantiti Yang Sedang Dipinjam</td>
    <td>Bilangan Peralatan Yang Masih Boleh Di Pinjam</td>
    <td></td>
  </tr>
  <?php do { ?>
    <tr>
    
      <td><?php echo $row_Recordset1['kodperalatan']; ?>&nbsp; </td>
      <td><?php echo $row_Recordset1['namaperalatan']; ?>&nbsp; </td>
      <td><?php echo $row_Recordset1['jenamaperalatan']; ?>&nbsp; </td>
      <td><?php echo $row_Recordset1['bilanganstok']; ?>&nbsp; </td>
      <td><?php echo $row_Recordset1['kuantitipinjam']; ?>&nbsp; </td>
      <td><?php echo ($row_Recordset1['bilanganstok']) - ( $row_Recordset1['kuantitipinjam']); ?>  &nbsp; </td>
       <td><a href="detailcarian.php?recordID=<?php echo $row_Recordset1['idpinjaman']; ?>"> <b>DETAIL</b></a></td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<p><br />
  <?php echo $totalRows_Recordset1 ?> Records Total
  </p>
</p>
<p>&nbsp;</p>
<p class="c">&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
