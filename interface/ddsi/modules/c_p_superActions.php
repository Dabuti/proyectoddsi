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
        $iduser = $_SESSION['IDUsuario'];
        if (isset($_REQUEST["jtSorting"])){
            $query = "SELECT
                        idcompra, idproducto, idsuper,
                        cantidad, precio
                      FROM
                        compraproductosuper
                      ORDER BY
                        $jsort";
        }else{
            $query = "SELECT
                        idcompra, idproducto, idsuper,
                        cantidad, precio
                      FROM
                        compraproductosuper";
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
	//Creating a new record (createAction)
	else if($_GET["action"] == "create")
	{
		//Insert record into database
        $idc = $_REQUEST['IDCOMPRA'];
        $idp = $_REQUEST['IDPRODUCTO'];
        $ids = $_REQUEST['IDSUPER'];
        $can = $_REQUEST['CANTIDAD'];
        $pre = $_REQUEST['PRECIO'];
 		$query = "INSERT INTO
             compraproductosuper (
               idcompra, idproducto, idsuper,
               cantidad, precio
                   )
             VALUES ( $idc, $idp, $ids, $can, $pre )";
        $statement = oci_parse($conn, $query);
        $r = oci_execute($statement);

        if (!$r) {
            $e = oci_error($statement);
            oci_rollback($conn);  // rollback changes to both tables
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
        }

        // Commit the changes to both tables
        $r = oci_commit($conn);
        if (!$r) {
            $e = oci_error($conn);
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
        }

		//Get last inserted record (to return to jTable)
		$query = "SELECT
                    *
                  FROM
                    compraproductosuper
                  WHERE
                    idcompra = '$idc'
                  and
                    idproducto = '$idp'
                  and
                    idsuper = '$ids'";
        $statement = oci_parse($conn, $query);
        $r = oci_execute($statement);
		$row = oci_fetch_array($statement, OCI_ASSOC);

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete"){
		//Delete from database
        $idc = $_REQUEST['IDCOMPRA'];
        $idp = $_REQUEST['IDPRODUCTO'];
        $ids = $_REQUEST['IDSUPER'];
		$query = "DELETE FROM
                    compraproductosuper
                  WHERE
                    idcompra = '$idc'
                  and
                    idproducto = '$idp'
                  and
                    idsuper = '$ids'";

        $statement = oci_parse($conn, $query);
        $r = oci_execute($statement);

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
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