-- Insertar usuario admin
insert into usuario(nombre, apellido1, username, password) values('admin', 'admin', 'admin', 'admin');
-- Insertar usuarios
insert into usuario(nombre, apellido1, username, password) values('iris', 'garcia', 'iris', '12345');
insert into usuario(nombre, apellido1, username, password) values('david', 'santiago', 'david', '12345');
insert into usuario(nombre, apellido1, username, password) values('rita', 'castillo', 'rita', '12345');

-- Insertar productos
insert into producto(nombre, descripcion, calorias) values('tomate','una unidad de tomate','5');
insert into producto(nombre, descripcion, calorias) values('pollo','1kg','250');
insert into producto(nombre, descripcion, calorias) values('cebolla','una unidad de cebolla','20');
insert into producto(nombre, descripcion, calorias) values('macarrones','1kb','300');
insert into producto(nombre, descripcion, calorias) values('queso','100gr','100');
insert into producto(nombre, descripcion, calorias) values('huevo','1unidad','25');
insert into producto(nombre, descripcion, calorias) values('tomate','tomate frito Solis','40');
insert into producto(nombre, descripcion, calorias) values('aceite','0.7L aceite de oliva','30');
insert into producto(nombre, descripcion, calorias) values('patatas','malla de 1kg','120');

-- Insertar Supermercados
insert into super(
                  nombre, direccion, telefono, web
                  )
           values(
                  'mercadona', 'C/Camino de ronda, 178', '958225264', 'www.mercadona.es'
                  );
insert into super(
                  nombre, direccion, telefono, web
                  )
           values(
                  'coviran', 'C/Paloma, 4', '958591961', 'www.coviran.es'
                  );

-- Insertar asociaciones ProductoSuper
insert into productosuper(idproducto, idsuper) values('2','1');
insert into productosuper(idproducto, idsuper) values('2','2');
insert into productosuper(idproducto, idsuper) values('3','1');
insert into productosuper(idproducto, idsuper) values('3','2');
insert into productosuper(idproducto, idsuper) values('4','1');
insert into productosuper(idproducto, idsuper) values('4','2');
insert into productosuper(idproducto, idsuper) values('5','1');
insert into productosuper(idproducto, idsuper) values('5','2');
insert into productosuper(idproducto, idsuper) values('6','1');
insert into productosuper(idproducto, idsuper) values('6','2');
insert into productosuper(idproducto, idsuper) values('7','1');
insert into productosuper(idproducto, idsuper) values('7','2');
insert into productosuper(idproducto, idsuper) values('8','1');
insert into productosuper(idproducto, idsuper) values('8','2');
insert into productosuper(idproducto, idsuper) values('9','1');
insert into productosuper(idproducto, idsuper) values('9','2');

-- Insertar Dietas
insert into dieta(
                  nombre, descripcion, idusuario
                  )
            VALUES(
                   'Mediterranea',
                   'dieta equilibrada y variada',
                   '2'
                   );
insert into dieta(
                  nombre, descripcion, idusuario
                  )
            VALUES(
                   'Atkins',
                   'Reduccion de 6kg en 2 semanas',
                   '3'
                   );

-- Asociación Dieta-Usuario
insert into dietausuario(iddieta, idusuario) values('1', '2');
insert into dietausuario(iddieta, idusuario) values('2', '3');

-- Insertar Recetas
insert into receta(nombre, personas, tiempo, descripcion)
            VALUES('Macarrones tomate','1','30', 'Macarrones con queso y tomate');
insert into receta(nombre, personas, tiempo, descripcion)
            VALUES(
                   'Patatas con huevos',
                   '1',
                   '35',
                   'Patatas fritas con huevos'
                   );
insert into receta(nombre, personas, tiempo, descripcion)
            VALUES(
                   'Pollo al chilindron',
                   '1',
                   '95',
                   'Pollo al chilindron'
                   );
insert into receta(nombre, personas, tiempo, descripcion)
            VALUES(
                   'Arroz a la cubana',
                   '1',
                   '40',
                   'Arroz con tomate huevo platano salchichas'
                   );
insert into receta(nombre, personas, tiempo, descripcion)
            VALUES(
                   'Menestra de verduras',
                   '1',
                   '35',
                   'Muchas verduras'
                   );

-- Asociaciones Receta-Producto
insert into recetaproducto(idreceta, idproducto, cantidad)
            VALUES('1','4','1');
insert into recetaproducto(idreceta, idproducto, cantidad)
            VALUES('1','7','2');
insert into recetaproducto(idreceta, idproducto, cantidad)
            VALUES('2','8','1');
insert into recetaproducto(idreceta, idproducto, cantidad)
            VALUES('2','6','2');
insert into recetaproducto(idreceta, idproducto, cantidad)
            VALUES('2','9','1');
insert into recetaproducto(idreceta, idproducto, cantidad)
            VALUES('3','2','1');

-- Asociaciones de Dieta-Receta
insert into dietareceta(iddieta, idreceta) VALUES('1','1');
insert into dietareceta(iddieta, idreceta) VALUES('1','3');
insert into dietareceta(iddieta, idreceta) VALUES('1','4');
insert into dietareceta(iddieta, idreceta) VALUES('2','2');
insert into dietareceta(iddieta, idreceta) VALUES('2','5');

-- Compras usuarios
insert into compra(idusuario) VALUES(2);
insert into compra(idusuario) VALUES(3);

-- Linea de compra
insert into compraproductosuper(idcompra, idproducto, idsuper, cantidad, precio)
            VALUES('1','2','1','2', '2,49');
insert into compraproductosuper(idcompra, idproducto, idsuper, cantidad, precio)
            VALUES('1','3','1','1','1,22');
insert into compraproductosuper(idcompra, idproducto, idsuper, cantidad, precio)
            VALUES('1','8','1','1','3,45');
insert into compraproductosuper(idcompra, idproducto, idsuper, cantidad, precio)
            VALUES('1','6','2','1','1,65');
insert into compraproductosuper(idcompra, idproducto, idsuper, cantidad, precio)
            VALUES('2','8','1','1','3,45');
insert into compraproductosuper(idcompra, idproducto, idsuper, cantidad, precio)
            VALUES('2','6','2','1','1,65');


-- Registrar comidas
insert into comida(idusuario, idreceta) values('2','1');
insert into comida(idusuario, idreceta) values('3','1');
insert into comida(idusuario, idreceta) values('2','4');
insert into comida(idusuario, idreceta) values('3','3');

COMMIT;
