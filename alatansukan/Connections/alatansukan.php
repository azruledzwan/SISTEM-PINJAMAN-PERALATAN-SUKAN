<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_alatansukan = "localhost";
$database_alatansukan = "alatansukan";
$username_alatansukan = "root";
$password_alatansukan = "";
$alatansukan = mysql_pconnect($hostname_alatansukan, $username_alatansukan, $password_alatansukan) or trigger_error(mysql_error(),E_USER_ERROR); 
?>