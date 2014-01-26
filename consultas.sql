--Listar productos
Select Nombre, Descripcion, Calorias
from Producto;

--listar supers
Select Nombre, Direccion, Telefono, Web
from Super;

--listar tus datos
Select Nombre, Apellido1, Apellido2, Username, Password
from Usuario
where IDUsuario = entrada;

--listar tus dietas
Select Nombre, Descripcion
from Dieta
Where IDUsuario = entrada;

--listar recetas de una de tus dietas
Select r.Nombre, r.Personas, r.Tiempo, r.Descripcion
from Receta r, Dieta d
where d.IDDieta IN (
Select IDDieta from Dieta where IDUsuario = entrada);

--listar recetas
Select Nombre, Personas, Tiempo, Descripcion
from Receta;

--listar comidas de un usuario
select r.Nombre, r.Tiempo, r.Personas, r.Descripcion, c.Fecha
from Comida c, Receta r
where c.IDUsuario = entrada and
c.IDReceta = r.IDReceta
order by(c.Fecha) ASC;

--listar tus compras
Select  p.Nombre, p.Descripcion, p.Calorias, c.Cantidad, c.Precio, s.Nombre, com.Fecha
from CompraProductoSuper c, Producto p, Compra com, Super s
where c.IDProducto = p.IDProducto and
c.IDCompra = com.IDCompra and
com.IDSuper = s .IDSuper and
com.IDUsuario = entrada;

--listar productos que componen  una receta
Select p.Nombre, p.Descripcion, p.Calorias, rp.Cantidad
from RecetaProducto rp, Producto p
where rp.IDProducto = p.IDProducto and
rp.IDReceta = entradaReceta;

--Calcular total gastado en todas las compras
--*Diviendo la salida entre 365 daría el gasto diario
Select sum(c.Precio)
from CompraProductoSuper c, Compra com
where com.IDUsuario = entrada and
com.IDCompra = c.IDCompra;

--Calcular unidades compradas de un producto por un usuario
select sum(c.Cantidad)
from Compra com, CompraProductoSuper c
where com.IDCompra = c.IDCompra and
com.IDUsuario = entrada and
c.IDProducto = entradaProducto; --DOS ENTRADAS

--Calcular unidades gastadas de un producto por un usuario
select sum(rp.Cantidad)
from Comida c, RecetaProducto rp
where rp.IDReceta = c.IDReceta and
rp.IDProducto = entradaProducto and
c.IDUsuario = entrada;

--Calcular calorias de una receta
Select sum(p.Calorias*rp.Cantidad)
from RecetaProducto rp, Producto p
where rp.IDReceta = entradaReceta and
p.IDProducto = rp.IDProducto;

--Mostrar el precio por super de lo que costaria llevar a cabo una dieta
