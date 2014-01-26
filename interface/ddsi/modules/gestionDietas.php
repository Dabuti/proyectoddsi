<?php
echo '<h3>O1- Insertar una nueva dieta a partir de su nombre y descripción.</h3>';
echo '<div id="dieta" class="table_sql" style="width: 70%;">';
echo '</div>';

echo '<h3>O2- Insertar asociación Dieta-Receta.</h3>';
echo '<h3>O3- Eliminar asociación Dieta-Receta.</h3>';
echo '<div id="aso_d_r" class="table_sql" style="width: 70%;">';
echo '</div>';

echo '<h3>O4- Listar Dietas de un usuario.</h3>';
echo '<h3>O-6 Insertar asociación Dieta-Usuario.</h3>';
echo '<div><input id="user_val" type="text"/><a id="btn_user">Consultar</a></div>';
echo '<div id="list_d_u" class="table_sql" style="width: 70%;">';
echo '</div>';

echo '<h3>O5- Listar nombre, personas, timpo y descripción de cada una de las recetas asociadas a una dieta.</h3>';
echo '<div><input id="dieta_val" type="text"/><a id="btn_dieta">Consultar</a></div>';
echo '<div id="list_r_d" class="table_sql" style="width: 70%;">';
echo '</div>';



?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#dieta').jtable({
            title: 'Dietas',
            sorting: true, //Enable sorting
            defaultSorting: 'iddieta ASC', //Set default sorting
            actions: {
                listAction: '/~dabuti/ddsi/modules/dietasActions.php?action=list',
                createAction: '/~dabuti/ddsi/modules/dietasActions.php?action=create',
                deleteAction: '/~dabuti/ddsi/modules/dietasActions.php?action=delete'
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
                IDDIETA: {
                    key: true,
                    title: 'IDDieta',
                    width: '15%'
                },
                NOMBRE: {
                    title: 'Nombre',
                    width: '35%'
                },
                DESCRIPCION: {
                    title: 'Descripcion',
                    width: '50%'
                }
            },
            display: function(data){
            }
        });
        $('#dieta').jtable('load');
        $('#aso_d_r').jtable({
            title: 'Asociacion Dieta-Receta',
            sorting: true, //Enable sorting
            defaultSorting: 'iddieta ASC', //Set default sorting
            actions: {
                listAction: '/~dabuti/ddsi/modules/aso_d_rActions.php?action=list',
                createAction: '/~dabuti/ddsi/modules/aso_d_rActions.php?action=create',
                deleteAction: '/~dabuti/ddsi/modules/aso_d_rActions.php?action=delete'
            },
            recordsLoaded: function(ev, data){
                var sys_request = '<div class="terminal_line">[System] ';
                sys_request += data.serverResponse.Request + '</div>';
                var ora_response = '<div class="terminal_line">[OracleDB] ';
                ora_response += data.serverResponse.Response + '</div>';
                $('#terminal_content').append(sys_request);
                $('#terminal_content').append(ora_response);
            },
            deleteConfirmation: function(data) {
                data.cancel = true;
                $.ajax({
	            type: "POST",
	            url: "/~dabuti/ddsi/modules/aso_d_rActions.php?action=delete",
                    data: data.record,
                    dataType: 'json',
                    success: function(html){
                        if (html.Result == "OK"){
                            data.row.remove();
                        }
	            }
                });
            },
            fields: {
                IDDIETA: {
                    title: 'IDDieta',
                    width: '15%',
                    create: true
                    },
                IDRECETA: {
                    title: 'IDReceta',
                    width: '15%',
                    create: true
                    },
                NOMBRED: {
                    title: 'Dieta',
                    width: '35%',
                    create: false
                    },
                NOMBRER: {
                    title: 'Receta',
                    width: '35%',
                    create: false
                    }
            },
            display: function(data){
            }
        });
        $('#aso_d_r').jtable('load');

        var accion = "";
        $('#btn_user').click(function(){
            if ($('#list_d_u').length > 0)
                $('#list_d_u').jtable('destroy');
            accion = '/~dabuti/ddsi/modules/list_d_uActions.php?action=list&idusuario=';
            accion += $('#user_val').val();

            $('#list_d_u').jtable({
                title: 'Dietas del usuario',
                sorting: true, //Enable sorting
                defaultSorting: 'nombre ASC', //Set default sorting
                actions: {
                    listAction:  accion,
                    createAction: '/~dabuti/ddsi/modules/list_d_uActions.php?action=create'
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
                    IDDIETA: {
                        title: 'IDDieta',
                        create: true,
                        list: false
                        },
                    NOMBRE: {
                        title: 'Nombre',
                        create: false,
                        width: '10%'
                        },
                    DESCRIPCION: {
                        title: 'Descripcion',
                        create: false,
                        width: '10%'
                    }
                },
                display: function(data){
                }
            });
            $('#list_d_u').jtable('load');
        });

        $('#list_d_u').jtable({
            title: 'Dietas de un usuario',
            sorting: true, //Enable sorting
            defaultSorting: 'nombre ASC', //Set default sorting
            actions: {
                listAction:  accion
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
                NOMBRE: {
                    title: 'Nombre',
                    width: '10%'
                },
                DESCRIPCION: {
                    title: 'Descripcion',
                    width: '10%'
                }
            },
            display: function(data){
            }
        });

        // Listado Recetas de una Dieta
        var accion = "";
        $('#btn_dieta').click(function(){
            if ($('#list_r_d').length > 0)
                $('#list_r_d').jtable('destroy');
            accion = '/~dabuti/ddsi/modules/list_r_dActions.php?action=list&iddieta=';
            accion += $('#dieta_val').val();

            $('#list_r_d').jtable({
                title: 'Recetas de una Dieta',
                sorting: true, //Enable sorting
                defaultSorting: 'nombre ASC', //Set default sorting
                actions: {
                    listAction:  accion
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
                    NOMBRE: {
                        title: 'Nombre',
                        width: '10%'
                        },
                    PERSONAS: {
                        title: 'Personas',
                        width: '10%'
                        },
                    TIEMPO: {
                        title: 'Tiempo',
                        width: '10%'
                        },
                    DESCRIPCION: {
                        title: 'Descripcion',
                        width: '10%'
                        }

                },
                display: function(data){
                }
            });
            $('#list_r_d').jtable('load');
        });

        $('#list_r_d').jtable({
            title: 'Recetas de una dieta',
            sorting: true, //Enable sorting
            defaultSorting: 'nombre ASC', //Set default sorting
            actions: {
                listAction:  accion
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
                NOMBRE: {
                    title: 'Nombre',
                    width: '10%'
                },
                DESCRIPCION: {
                    title: 'Descripcion',
                    width: '10%'
                }
            },
            display: function(data){
            }
        });

    });
// Scroll down terminal DEBUG
$('#terminal_content').scrollTop($('#terminal_content')[0].scrollHeight);
</script>
