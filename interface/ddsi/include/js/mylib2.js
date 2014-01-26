function getUsuarios(){
    $.ajax({
	type: "POST",
	url: "modules/gestionUsuarios.php",
        success: function(html){
            $('#module_content').html(html);
	}
    });

}

function gestionCompras(){
    $.ajax({
	type: "POST",
	url: "modules/gestionCompras.php",
        success: function(html){
            $('#module_content').html(html);
	}
    });
}

function gestionProductos(){
    $.ajax({
	type: "POST",
	url: "modules/gestionProductos.php",
        success: function(html){
            $('#module_content').html(html);
	}
    });
}

function gestionSupers(){
    $.ajax({
	type: "POST",
	url: "modules/gestionSupers.php",
        success: function(html){
            $('#module_content').html(html);
	}
    });
}

function gestionRecetas(){
    $.ajax({
	type: "POST",
	url: "modules/gestionRecetas.php",
        success: function(html){
            $('#module_content').html(html);
	}
    });
}

function gestionDietas(){
    $.ajax({
	type: "POST",
	url: "modules/gestionDietas.php",
        success: function(html){
            $('#module_content').html(html);
	}
    });
}

function gestionEstadisticas(){
    $.ajax({
	type: "POST",
	url: "modules/gestionEstadisticas.php",
        success: function(html){
            $('#module_content').html(html);
	}
    });
}

function gestionComidas(){
    $.ajax({
	type: "POST",
	url: "modules/gestionComidas.php",
        success: function(html){
            $('#module_content').html(html);
	}
    });
}

function gestionUsuarios(){
    $.ajax({
	type: "POST",
	url: "modules/gestionUsuarios.php",
        success: function(html){
            $('#module_content').html(html);
	}
    });
}

function deleteAso(data){
    alert(data);
}

function myjTableProducto(){
    $('#producto').jtable({
        title: 'Productos',
        sorting: true, //Enable sorting
        defaultSorting: 'idproducto ASC', //Set default sorting
        actions: {
            listAction: '/~dabuti/ddsi/modules/productosActions.php?action=list',
            updateAction: '/~dabuti/ddsi/modules/productosActions.php?action=update',
            createAction: '/~dabuti/ddsi/modules/productosActions.php?action=create'
        },
        recordsLoaded: function(ev, data){
            var sys_request = '<div class="terminal_line">[System] ';
            sys_request += data.serverResponse.Request + '</div>';
            var ora_response = '<div class="terminal_line">[OracleDB] ';
            ora_response += data.serverResponse.Response + '</div>';
            $('#terminal_content').append(sys_request);
            $('#terminal_content').append(ora_response);
        },
        fields: {
            IDPRODUCTO: {
                key: true,
                title: 'IDProducto',
                width: '20%'
            },
            NOMBRE: {
                title: 'Nombre',
                width: '30%'
            },
            DESCRIPCION: {
                title: 'Descripción',
                width: '30%'
            },
            CALORIAS: {
                title: 'Calorías',
                width: '20%'
            }
        }
    });
    $('#producto').jtable('load');
    $('#aso_p_s').jtable({
        title: 'Asociación de productos a Super',
        sorting: true, //Enable sorting
        defaultSorting: 'idproducto ASC', //Set default sorting
        actions: {
            listAction: '/~dabuti/ddsi/modules/aso_p_sActions.php?action=list',
            createAction: '/~dabuti/ddsi/modules/aso_p_sActions.php?action=create'
        },
        recordsLoaded: function(ev, data){
            var sys_request = '<div class="terminal_line">[System] ';
            sys_request += data.serverResponse.Request + '</div>';
            var ora_response = '<div class="terminal_line">[OracleDB] ';
            ora_response += data.serverResponse.Response + '</div>';
            $('#terminal_content').append(sys_request);
            $('#terminal_content').append(ora_response);
        },
        fields: {
            IDPRODUCTO: {
                key: true,
                create: true,
                title: 'IDProducto',
                width: '20%'
            },
            IDSUPER: {
                key: true,
                create: true,
                title: 'IDSuper',
                width: '30%'
            },
            NOMBREP: {
                title: 'Nombre',
                create: false,
                width: '20%'
            },
            NOMBRES: {
                title: 'Supermercado',
                create: false,
                width: '20%'
            }
        }
    });
    $('#aso_p_s').jtable('load');
}
