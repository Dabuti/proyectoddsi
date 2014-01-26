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
        $idu = $_REQUEST['idusuario'];

        if (isset($_REQUEST["jtSorting"])){
            $query = "SELECT
                        d.iddieta, nombre, descripcion
                      FROM
                        dieta d, dietausuario du
                      WHERE
                        du.idusuario = '$idu'
                      and
                        d.iddieta = du.iddieta
                      ORDER BY
                        $jsort";
        }else{
            $query = "SELECT
                        d.iddieta, nombre, descripcion
                      FROM
                        dieta d, dietausuario du
                      WHERE
                        du.idusuario = '$idu'
                      and
                        d.iddieta = du.iddieta";

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
	else if($_GET["action"] == "create"){
		//Get records from database
        $idu = $_SESSION['IDUsuario'];
        $idd = $_REQUEST['IDDIETA'];

        $query = "INSERT into dietausuario
                    (iddieta, idusuario)
                  VALUES
                    ('$idd', '$idu')";

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

        // Get last record
        $query = "SELECT
                    *
                  FROM
                    dietausuario
                  WHERE
                    iddieta = '$idd'
                  and
                    idusuario = '$idu'";

		$statement = oci_parse($conn, $query);
		$r = oci_execute($statement);
		$row = oci_fetch_array($statement, OCI_ASSOC);

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Request'] = $query;
		$jTableResult['Response'] = "Respuesta devuelta por Oracle";
		$jTableResult['Record'] = $row;
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