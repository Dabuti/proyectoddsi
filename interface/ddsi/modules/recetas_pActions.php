<?php
require_once '.././include/dblogin.php';
session_start();

$conn = oci_connect($user, $pass, $ugr);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

try{
	//Getting records (listAction)
	if($_GET["action"] == "list"){
		//Get records from database
        $jsort = $_REQUEST['jtSorting'];
        $idr = $_REQUEST['idreceta'];
        if (isset($_REQUEST["jtSorting"])){
            $query = "SELECT
                        distinct(p.nombre), rp.cantidad, p.calorias, p.descripcion
                      FROM
                        recetaproducto rp, producto p, receta r
                      WHERE
                        rp.idproducto = p.idproducto
                      and
                        rp.idreceta = '$idr'
                      ORDER BY
                        $jsort";
        }else{
            $query = "SELECT
                        distinct(p.nombre), rp.cantidad, p.calorias, p.descripcion
                      FROM
                        recetaproducto rp, producto p, receta r
                      WHERE
                        rp.idproducto = p.idproducto
                      and
                        rp.idreceta = '$idr'";
        }

		$statement = oci_parse($conn, $query);
		oci_execute($statement);

		//Add all records to an array
		$json = array();
		while($row = oci_fetch_array($statement, OCI_ASSOC))
		{
		    $json[] = $row;
		}

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Request'] = $query;
		$jTableResult['Response'] = "Respuesta devuelta por Oracle";
		$jTableResult['Records'] = $json;
		print json_encode($jTableResult);
	}

	//Close database connection
    oci_free_statement($statement);
    oci_close($conn);

}catch(Exception $ex){
    //Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
?>