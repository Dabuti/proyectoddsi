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
                        d.iddieta, d.nombre nombred, r.idreceta, r.nombre nombrer
                      FROM
                        dietareceta dr, dieta d, receta r
                      WHERE
                        dr.iddieta = d.iddieta
                      and
                        dr.idreceta = r.idreceta
                      ORDER BY
                        $jsort";
        }else{
            $query = "SELECT
                        d.iddieta, d.nombre nombred, r.idreceta, r.nombre nombrer
                      FROM
                        dietareceta dr, dieta d, receta r
                      WHERE
                        dr.iddieta = d.iddieta
                      and
                        dr.idreceta = r.idreceta";

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
        $idr = $_REQUEST['IDRECETA'];
        $idd = $_REQUEST['IDDIETA'];

 		$query = "INSERT INTO
             dietareceta (
               iddieta, idreceta
                   )
             VALUES ( $idd, $idr )";

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
                    dietareceta
                  WHERE
                    idreceta = '$idr'
                  and
                    iddieta = '$idd'";

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
        $idr = $_REQUEST['IDRECETA'];
        $idd = $_REQUEST['IDDIETA'];

		$query = "DELETE FROM
                    dietareceta
                  WHERE
                    idreceta = '$idr'
                  and
                    iddieta = '$idd'";

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