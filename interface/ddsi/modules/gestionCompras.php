<?php
echo '<h3>O1- Listar datos producto y nombre super comprados por un usuario a partir de su IDUsuario.</h3>';
echo '<div id="producto_super" class="table_sql" style="width: 90%;">';
echo '</div>';

echo '<h3>O2- Insertar nueva comprar a partir de IDUsuario.</h3>';
echo '<div id="compra" class="table_sql" style="width: 70%;">';
echo '</div>';

echo '<h3>O-3 Insertar línea de compra a partir de IDCompra IDProducto IDSuper, cantidad, precio.</h3>';
echo '<h3>O-4 Eliminar línea de compra.</h3>';
echo '<div id="compra_producto_super" class="table_sql" style="width: 70%;">';
echo '</div>';
echo '<h3>Tabla productos.</h3>';
echo '<div id="producto" class="table_sql" style="width: 70%;">';
echo '</div>';
echo '<h3>Producto - Supermercado.</h3>';
echo '<div id="aso_p_s" class="table_sql" style="width: 70%;">';


?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#compra').jtable({
            title: 'Compras',
            sorting: true, //Enable sorting
            defaultSorting: 'idcompra ASC', //Set default sorting
            actions: {
                listAction: '/~dabuti/ddsi/modules/comprasActions.php?action=list',
                createAction: '/~dabuti/ddsi/modules/comprasActions.php?action=create'
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
                IDCOMPRA: {
                    key: true,
                    title: 'IDCompra',
                    width: '10%'
                },
                FECHA: {
                    title: 'Fecha',
                    type: 'date',
                    create: false,
                    width: '40%',
                    display: function(data){
                        var fecha = $.datepicker.formatDate('dd-mm-yy',
                                        new Date(data.record.FECHA));
                        return fecha;
                    },
                    displayFormat: 'dd-mm-yy'
                }
            },
            display: function(data){
            }
        });
        $('#compra').jtable('load');

        $('#producto_super').jtable({
            title: 'Histórico comprados',
            sorting: true, //Enable sorting
            defaultSorting: 'com.fecha ASC', //Set default sorting
            actions: {
                listAction: '/~dabuti/ddsi/modules/p_superActions.php?action=list',
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
                NOMBREP: {
                    title: 'NombreP',
                },
                DESCRIPCION: {
                    title: 'Descripción',
                },
                CALORIAS: {
                    title: 'Calorías',
                },
                CANTIDAD: {
                    title: 'Cantidad',
                },
                PRECIO: {
                    title: 'Precio',
                },
                NOMBRES: {
                    title: 'NombreS',
                },
                FECHA: {
                    title: 'Fecha',
                    type: 'date',
                    create: false,
                    display: function(data){
                        var fecha = $.datepicker.formatDate('dd-mm-yy',
                                        new Date(data.record.FECHA));
                        return fecha;
                    },
                    displayFormat: 'dd-mm-yy'
                }
            },
            display: function(data){
            }
        });
        $('#producto_super').jtable('load');

        $('#compra_producto_super').jtable({
            title: 'Líneas de compra',
            actions: {
                listAction: '/~dabuti/ddsi/modules/c_p_superActions.php?action=list',
                createAction: '/~dabuti/ddsi/modules/c_p_superActions.php?action=create',
                deleteAction: '/~dabuti/ddsi/modules/c_p_superActions.php?action=delete'
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
	            url: "/~dabuti/ddsi/modules/c_p_superActions.php?action=delete",
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
                IDCOMPRA: {
                    title: 'IDCompra',
                    create: true,
                    list: true
                },
                IDPRODUCTO: {
                    title: 'IDProducto',
                    create: true
                },
                IDSUPER: {
                    title: 'IDSuper',
                    create: true
                },
                CANTIDAD: {
                    title: 'Cantidad',
                },
                PRECIO: {
                    title: 'Precio',
                }
            },
            options: function (data) {
                alert("options");
            },
            display: function(data){
                alert("display");
            }
        });
        $('#compra_producto_super').jtable('load');
        myjTableProducto();
    });

</script>
