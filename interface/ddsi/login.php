<?php
require_once 'include/dblogin.php';

$conn = oci_connect($user, $pass, $ugr);

session_start();

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$query = "SELECT * FROM usuario WHERE username='$username' AND password='$password'";
$statement = oci_parse($conn, $query);

$r = oci_execute($statement);
$row = oci_fetch_array($statement, OCI_ASSOC);

$respuesta = array();
$respuesta['Request'] = $query;
if (oci_num_rows($statement) > 0) {
    $_SESSION['IDUsuario'] = $row['IDUSUARIO'];
    $respuesta['Result'] = "OK";
}else{
    $e = oci_error($statement);
    $respuesta['Result'] = "ERROR";
    $respuesta['Error'] = $e['message']." y ".$e['sqltext']." y ".$e['code'];
}

print json_encode($respuesta);

?>
