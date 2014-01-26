$(document).ready(function() {
    $('#example').dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "http://localhost/~dabuti/ddsi/process.php"
    } );
} );
