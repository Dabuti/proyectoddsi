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

-- Insertar asociaciones
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
