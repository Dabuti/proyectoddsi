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
        if (isset($_REQUEST["jtSorting"])){
            $query = "SELECT
                        idproducto, nombre, descripcion, calorias
                      FROM
                        producto
                      ORDER BY
                        $jsort";
        }else{
            $query = "SELECT
                       idproducto, nombre, descripcion, calorias
                      FROM
                       producto";
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
        $nombre = $_REQUEST['NOMBRE'];
        $desc = $_REQUEST['DESCRIPCION'];
        $cal = $_REQUEST['CALORIAS'];
 		$query = "INSERT INTO
             producto (
               nombre, calorias, descripcion
                   )
             VALUES (
               '$nombre', '$cal', '$desc'
                    )
             RETURNING
               idproducto
             INTO
               :producto_id";
        $statement = oci_parse($conn, $query);
        oci_bind_by_name($statement, ':producto_id', $producto_id, -1, SQLT_INT);
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
                    producto
                  WHERE
                    idproducto = :producto_id";
        $statement = oci_parse($conn, $query);
        oci_bind_by_name($statement, ':producto_id', $producto_id, -1, SQLT_INT);
        $r = oci_execute($statement);
		$row = oci_fetch_array($statement, OCI_ASSOC);

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
		//Update record in database
        $id_prod = $_REQUEST['IDPRODUCTO'];
        $nombre = $_REQUEST['NOMBRE'];
        $desc = $_REQUEST['DESCRIPCION'];
        $cal = $_REQUEST['CALORIAS'];
		$query ="UPDATE
                   producto
                 SET
                   nombre = '$nombre', descripcion = '$desc', calorias = '$cal'
                 WHERE
                   idproducto = '$id_prod'";
        $statement = oci_parse($conn, $query);
        oci_execute($statement);

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