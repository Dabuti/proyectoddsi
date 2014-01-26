<?php
echo '<h3>O1- Insertar un usuario a partir de su nombre, apellido1, appelido2...</h3>';
echo '<h3>O2- Eliminar un usuario partir de su IDUsuario (CASCADE).</h3>';
echo '<h3>O3- Editar nombre, apellido1,... de un usuario a partir de us IDUsuario.</h3>';
echo '<div id="usuarios" class="table_sql" style="width: 90%;">';
echo '</div>';

?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#usuarios').jtable({
            title: 'Tabla de usuarios',
            sorting: true, //Enable sorting
            defaultSorting: 'IDUSUARIO ASC', //Set default sorting
            actions: {
                listAction: '/~dabuti/ddsi/modules/userActions.php?action=list',
                updateAction: '/~dabuti/ddsi/modules/userActions.php?action=update',
                createAction: '/~dabuti/ddsi/modules/userActions.php?action=create',
                deleteAction: '/~dabuti/ddsi/modules/userActions.php?action=delete'
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
                IDUSUARIO: {
                    key: true,
                    title: 'idusuario',
                    width: '20%'
                },
                NOMBRE: {
                    title: 'nombre',
                    width: '20%'
                },
                APELLIDO1: {
                    title: 'apellido1',
                    width: '20%'
                },
                APELLIDO2: {
                    title: 'apellido2',
                    width: '20%',
                    edit: true
                },
                USERNAME: {
                    title: 'username',
                    width: '20%',
                    edit: true
                },
                PASSWORD: {
                    title: 'password',
                    width: '20%',
                    edit: true
                }
            }
        });

        $('#usuarios').jtable('load');
    });
</script>
