<?php
echo '<h3>Insertar Comida y Asociar con una Receta y un Usuario.</h3>';
echo '<div id="comida" class="table_sql" style="width: 70%;">';
echo '</div>';
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#comida').jtable({
            title: 'Comidas',
            sorting: true, //Enable sorting
            defaultSorting: 'idcompra ASC', //Set default sorting
            actions: {
                listAction: '/~dabuti/ddsi/modules/comidasActions.php?action=list',
                createAction: '/~dabuti/ddsi/modules/comidasActions.php?action=create'
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
                    title: 'IDReceta',
                    width: '10%',
                    list: false,
                    create: true
                },
                IDUSUARIO: {
                    title: 'IDUsuario',
                    width: '10%',
                    list: false,
                    create: false
                },
                NOMBRER: {
                    title: 'Receta',
                    width: '10%',
                    list: true,
                    create: false
                },
                NOMBREU: {
                    title: 'Usuario',
                    width: '10%',
                    list: true,
                    create: false
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
        $('#comida').jtable('load');
    });
</script>
