<div id="wrapper">
<nav id="menu" class="navbar" role="navigation">
     <ul class="nav nav-pills">
     <li><a href="javascript:gestionCompras();" class="">Compras</a></li>
     <li><a href="javascript:gestionProductos();" class="">Productos</a></li>
     <li><a href="javascript:gestionSupers();" class="">Super</a></li>
     <li><a href="javascript:gestionRecetas();" class="">Recetas</a></li>
     <li><a href="javascript:gestionDietas();" class="">Dietas</a></li>
     <li><a href="javascript:gestionEstadisticas();" class="">Estadísticas</a></li>
     <li><a href="javascript:gestionComidas();" class="">Comidas</a></li>
     <li><a href="javascript:gestionUsuarios();" class="">Usuarios</a></li>
     </ul>
</nav>
<?php

echo '<div id="module_content">';
echo '<h1> Sistema de información para el registro y control de alimentos y dietas</h1>';
echo '</div>';

?>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var h = $(document).height() - $('#wrapper_debug').height();
        h -= $('#menu').height() + 55;
        $('#module_content').css('min-height', h, '!important');
        $('#module_content').css('height', h, '!important');
    });
</script>
