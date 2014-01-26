<?php
echo '<h3>O-1 Listar datos producto y nombre super comprados por un usuario a partir de su IDUsuario.</h3>';
echo '<div id="producto_super" style="width: 100%;">';
echo '</div>';

echo '<h3>O2- Insertar nueva comprar a partir de IDUsuario.</h3>';
echo '<div id="compra" style="width: 70%;">';
echo '</div>';

echo '<h3>O-3 Insertar línea de compra a partir de IDCompra IDProducto IDSuper, cantidad, precio.</h3>';
echo '<h3>O-4 Eliminar línea de compra.</h3>';
echo '<div id="compra_producto_super" style="width: 100%;">';
echo '</div>';

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
    });
</script>
