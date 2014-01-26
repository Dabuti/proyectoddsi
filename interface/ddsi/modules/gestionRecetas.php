<?php
echo '<h3>O-1 Insertar una receta a partir del nombre, personas, tiempo y descripción.</h3>';
echo '<h3>O-2 Modificar una receta.</h3>';
echo '<div id="receta" class="table_sql" style="width: 70%;">';
echo '</div>';

echo '<h3>O3- Insertar asociación Receta-Producto :cantidad.</h3>';
echo '<h3>O4- Eliminar asociación Receta-Producto :cantidad.</h3>';
echo '<div id="aso_r_p" class="table_sql" style="width: 70%;">';
echo '</div>';

echo '<h3>Tabla productos.</h3>';
echo '<div id="producto" class="table_sql" style="width: 70%;">';
echo '</div>';

echo '<h3>O-5 Listar nombre, calorías, cantidad y descripción.</h3>';
echo '<div id="receta_query"><input id="receta_val" type="text"/><a id="btn_receta">Consultar</a></div>';
echo '<div id="receta_p" class="table_sql" style="width: 70%;">';
echo '</div>';


?>
<script type="text/javascript">
    $(document).ready(function(){
        myjTableProducto();
        var accion = "";
        $('#btn_receta').click(function(){
            if ($('#receta_p').length > 0)
                $('#receta_p').jtable('destroy');
            accion = '/~dabuti/ddsi/modules/recetas_pActions.php?action=list&idreceta=';
            accion += $('#receta_val').val();

            $('#receta_p').jtable({
                title: 'Productos de una receta',
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
                    CANTIDAD: {
                        title: 'Cantidad',
                        width: '10%'
                    },
                    CALORIAS: {
                        title: 'Calorias',
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
            $('#receta_p').jtable('load');
        });

        $('#receta_p').jtable({
            title: 'Productos de una receta',
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
                CANTIDAD: {
                    title: 'Cantidad',
                    width: '10%'
                },
                CALORIAS: {
                    title: 'Calorias',
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

        $('#receta').jtable({
            title: 'Recetas',
            sorting: true, //Enable sorting
            defaultSorting: 'idreceta ASC', //Set default sorting
            actions: {
                listAction:  '/~dabuti/ddsi/modules/recetasActions.php?action=list',
                updateAction:  '/~dabuti/ddsi/modules/recetasActions.php?action=update',
                createAction:  '/~dabuti/ddsi/modules/recetasActions.php?action=create'
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
                IDRECETA: {
                    key: true,
                    title: 'IDReceta',
                },
                NOMBRE: {
                    title: 'Nombre',
                },
                PERSONAS: {
                    title: 'Personas',
                },
                TIEMPO: {
                    title: 'Tiempo',
                },
                DESCRIPCION: {
                    title: 'Descripcion',
                }
            },
            display: function(data){
            }
        });

        $('#receta').jtable('load');
        $('#aso_r_p').jtable({
            title: 'Asociación Recetas-Productos (cantidad)',
            sorting: true, //Enable sorting
            defaultSorting: 'idreceta ASC', //Set default sorting
            actions: {
                listAction:  '/~dabuti/ddsi/modules/aso_r_pActions.php?action=list',
                deleteAction:  '/~dabuti/ddsi/modules/aso_r_pActions.php?action=delete',
                createAction:  '/~dabuti/ddsi/modules/aso_r_pActions.php?action=create'
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
	            url: "/~dabuti/ddsi/modules/aso_r_pActions.php?action=delete",
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
                IDRECETA: {
                    title: 'IDReceta',
                    create: true
                },
                IDPRODUCTO: {
                    title: 'IDProducto',
                    create: true
                },
                CANTIDAD: {
                    title: 'Cantidad',
                    create: true
                }
            },
            display: function(data){
            }
        });

        $('#aso_r_p').jtable('load');

    });
</script>
