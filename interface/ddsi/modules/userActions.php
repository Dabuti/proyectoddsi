<?php
require_once '.././include/dblogin.php';

$conn = oci_connect($user, $pass, $ugr);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

try{
	//Getting records (listAction)
	if($_GET["action"] == "list"){
		//Get records from database
        if (isset($_REQUEST["jtSorting"]))
            $query = "select * from usuario order by ".$_REQUEST["jtSorting"];
        else
            $query = "select * from usuario";

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
		$query = "INSERT INTO usuario(nombre, apellido1, apellido2, username, password) VALUES('";
        $query .= $_POST["NOMBRE"]."', '".$_POST["APELLIDO1"]."', '".$_POST["APELLIDO2"]."', '";
        $query .= $_POST["USERNAME"]."', '".$_POST["PASSWORD"]."') ";
        $query .= "returning idusuario into :user_id";
        $statement = oci_parse($conn, $query);
        oci_bind_by_name($statement, 'user_id', $user_id, 8, SQLT_INT);
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
		$statement = oci_parse($conn, "SELECT * FROM usuario WHERE idusuario = :user_id");
        oci_bind_by_name($statement, 'user_id', $user_id, 8, SQLT_INT);
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
		$query ="UPDATE usuario SET nombre = '".$_POST["NOMBRE"]."', apellido1 = '".$_POST["APELLIDO1"]."', ";
		$query .= "apellido2 = '".$_POST["APELLIDO2"]."', username = '".$_POST["USERNAME"]."', ";
        $query .= "password = '".$_POST["PASSWORD"]."' WHERE idusuario = " . $_POST["IDUSUARIO"]."";
        $statement = oci_parse($conn, $query);
        oci_execute($statement);

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		print json_encode($jTableResult);
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete"){
		//Delete from database
		$query = "DELETE FROM usuario WHERE idusuario = ".$_POST["IDUSUARIO"]."";
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