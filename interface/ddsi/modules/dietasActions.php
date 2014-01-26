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
        $iduser = $_SESSION['IDUsuario'];
        $jsort = $_REQUEST['jtSorting'];
        if (isset($_REQUEST["jtSorting"])){
            $query = "SELECT
                    iddieta, nombre, descripcion
                 FROM
                    dieta
                 WHERE
                    idusuario='$iduser'
                 ORDER BY
                    $jsort";
        }else{
            $query = "SELECT
                    iddieta, nombre, descripcion
                 FROM
                    dieta
                 WHERE
                    idusuario='$iduser'";
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
        $iduser = $_SESSION['IDUsuario'];
        $nom = $_REQUEST['NOMBRE'];
        $desc = $_REQUEST['DESCRIPCION'];

 		$query = "INSERT INTO
             dieta (
               nombre, descripcion, idusuario
                   )
             VALUES (
               '$nom',
               '$desc',
               '$iduser'
                    )
             RETURNING
               iddieta
             INTO
               :dieta_id";
        $statement = oci_parse($conn, $query);
        oci_bind_by_name($statement, ':dieta_id', $dieta_id, -1, SQLT_INT);
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
                    iddieta, nombre, descripcion
                 FROM
                    dieta
                 WHERE
                    iddieta = :dieta_id";

		$statement = oci_parse($conn, $query);
        oci_bind_by_name($statement, ':dieta_id', $dieta_id, -1, SQLT_INT);
        $r = oci_execute($statement);
		$row = oci_fetch_array($statement, OCI_ASSOC);

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	else if($_GET["action"] == "delete")
	{
        $iduser = $_SESSION['IDUsuario'];
        $iddieta = $_REQUEST['IDDIETA'];

        $query = "DELETE
                  FROM
                    dieta
                 WHERE
                    iddieta = '$iddieta'
                 and
                    idusuario = '$iduser'";
		$statement = oci_parse($conn, $query);
        oci_bind_by_name($statement, ':dieta_id', $dieta_id, -1, SQLT_INT);
        $r = oci_execute($statement);


		$jTableResult = array();
        if ($r){
            // Commit the changes
            $r = oci_commit($conn);
            $jTableResult['Result'] = "OK";
        }else{
            $jTableResult['Result'] = "ERROR";
        }

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