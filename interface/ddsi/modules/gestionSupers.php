<?php
echo '<h3>O-1 y O-2 Insertar y Modificar Supers.</h3>';
echo '<div id="super" class="table_sql" style="width: 70%;">';
echo '</div>';
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#super').jtable({
            title: 'Supermercados',
            sorting: true, //Enable sorting
            defaultSorting: 'idsuper ASC', //Set default sorting
            actions: {
                listAction: '/~dabuti/ddsi/modules/supersActions.php?action=list',
                updateAction: '/~dabuti/ddsi/modules/supersActions.php?action=update',
                createAction: '/~dabuti/ddsi/modules/supersActions.php?action=create'
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
                IDSUPER: {
                    key: true,
                    title: 'IDSuper',
                    width: '15%'
                },
                NOMBRE: {
                    title: 'Nombre',
                    width: '20%'
                },
                DIRECCION: {
                    title: 'Dirección',
                    width: '30%'
                },
                TELEFONO: {
                    title: 'Teléfono',
                    width: '15%'
                },
                WEB: {
                    title: 'Website',
                    width: '20%'
                }
            }
        });
        $('#super').jtable('load');
    });
</script>
