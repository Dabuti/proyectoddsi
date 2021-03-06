drop table compraproductosuper;
drop table dietausuario;
drop table compra;
drop table productosuper;
drop table super;
drop table recetaproducto;
drop table dietareceta;
drop table comida;
drop table dieta;
drop table receta;
drop table producto;
drop table usuario;
drop trigger usuario_id;
drop trigger compra_id;
drop trigger super_id;
drop trigger producto_id;
drop trigger dieta_id;
drop trigger comida_id;
drop trigger receta_id;
drop trigger compra_id;
drop sequence usuario_seq;
drop sequence compra_seq;
drop sequence super_seq;
drop sequence producto_seq;
drop sequence dieta_seq;
drop sequence comida_seq;
drop sequence receta_seq;
drop sequence compra_seq;

CREATE TABLE Usuario(
       IDUsuario int NOT NULL,
       Nombre char(20) NOT NULL,
       Apellido1 char(20) NOT NULL,
       Apellido2 char(20),
       Username varchar(20) NOT NULL UNIQUE,
       Password varchar(20) NOT NULL,
       PRIMARY KEY(IDUsuario)
);

CREATE SEQUENCE usuario_seq;

CREATE OR REPLACE TRIGGER usuario_id
BEFORE INSERT ON usuario
FOR EACH ROW
BEGIN
  SELECT usuario_seq.NEXTVAL
  INTO   :new.idusuario
  FROM   dual;
END;
/

CREATE TABLE Compra(
       IDCompra NUMBER(10) NOT NULL,
       Fecha DATE DEFAULT (sysdate),
       IDUsuario NUMBER(10) NOT NULL,
       PRIMARY KEY(IDCompra),
       FOREIGN KEY(IDUsuario) REFERENCES Usuario(IDUsuario) on delete cascade
);

CREATE SEQUENCE compra_seq;

CREATE OR REPLACE TRIGGER compra_id
BEFORE INSERT ON compra
FOR EACH ROW
BEGIN
  SELECT compra_seq.NEXTVAL
  INTO   :new.idcompra
  FROM   dual;
END;
/

CREATE TABLE Receta(
       IDReceta NUMBER(10) NOT NULL,
       Nombre char(100) NOT NULL,
       Personas NUMBER(10) NOT NULL,
       Tiempo NUMBER(10) NOT NULL,
       Descripcion char(200),  --NOT NULL??
       PRIMARY KEY(IDReceta)
);

CREATE SEQUENCE receta_seq;

CREATE OR REPLACE TRIGGER receta_id
BEFORE INSERT ON receta
FOR EACH ROW
BEGIN
  SELECT receta_seq.NEXTVAL
  INTO   :new.idreceta
  FROM   dual;
END;
/

CREATE TABLE Comida(
       IDComida NUMBER(10) NOT NULL,
       Fecha DATE DEFAULT(sysdate),
       IDUsuario NUMBER(10) NOT NULL,
       IDReceta NUMBER(10) NOT NULL,
       PRIMARY KEY(IDComida),
       FOREIGN KEY(IDUsuario) REFERENCES Usuario(IDUsuario) on delete cascade,
       FOREIGN KEY(IDReceta) REFERENCES Receta(IDReceta) on delete cascade
);

CREATE SEQUENCE comida_seq;

CREATE OR REPLACE TRIGGER comida_id
BEFORE INSERT ON comida
FOR EACH ROW
BEGIN
  SELECT comida_seq.NEXTVAL
  INTO   :new.idcomida
  FROM   dual;
END;
/

CREATE TABLE Dieta(
       IDDieta NUMBER(10) NOT NULL,
       Nombre char(20) NOT NULL,
       Descripcion char(200),
       IDUsuario NUMBER(10) NOT NULL,
       PRIMARY KEY(IDDieta),
       FOREIGN KEY(IDUsuario) REFERENCES Usuario(IDUsuario) on delete cascade
);

CREATE SEQUENCE dieta_seq;

CREATE OR REPLACE TRIGGER dieta_id
BEFORE INSERT ON dieta
FOR EACH ROW
BEGIN
  SELECT dieta_seq.NEXTVAL
  INTO   :new.iddieta
  FROM   dual;
END;
/

CREATE TABLE Producto(
       IDProducto NUMBER(10) NOT NULL,
       Nombre char(20) NOT NULL,
       Calorias NUMBER(10),
       Descripcion char(200),
       PRIMARY KEY(IDProducto)
);

CREATE SEQUENCE producto_seq;

CREATE OR REPLACE TRIGGER producto_id
BEFORE INSERT ON producto
FOR EACH ROW
BEGIN
  SELECT producto_seq.NEXTVAL
  INTO   :new.idproducto
  FROM   dual;
END;
/

CREATE TABLE Super(
       IDSuper NUMBER(10) NOT NULL,
       Nombre char(20) NOT NULL,
       Direccion varchar(30),
       Telefono number(9),
       Web char(20),
       PRIMARY KEY(IDSuper)
);

CREATE SEQUENCE super_seq;

CREATE OR REPLACE TRIGGER super_id
BEFORE INSERT ON super
FOR EACH ROW
BEGIN
  SELECT super_seq.NEXTVAL
  INTO   :new.idsuper
  FROM   dual;
END;
/

CREATE TABLE ProductoSuper(
       IDProducto NUMBER(10) NOT NULL,
       IDSuper NUMBER(10) NOT NULL,
       PRIMARY KEY(IDProducto, IDSuper),
       FOREIGN KEY(IDProducto) REFERENCES Producto(IDProducto) on delete cascade,
       FOREIGN KEY(IDSuper) REFERENCES Super(IDSuper) on delete cascade
);

CREATE TABLE CompraProductoSuper(
       IDCompra NUMBER(10) NOT NULL,
       IDProducto NUMBER(10) NOT NULL,
       IDSuper NUMBER(10) NOT NULL,
       Cantidad NUMBER(10) NOT NULL,
       Precio NUMBER(10,2) NOT NULL,
       PRIMARY KEY(IDCompra, IDProducto, IDSuper),
       FOREIGN KEY(IDCompra) REFERENCES Compra(IDCompra) on delete cascade,
       FOREIGN KEY(IDProducto, IDSuper) REFERENCES ProductoSuper(IDProducto, IDSuper) on delete cascade
);

CREATE TABLE DietaReceta(
       IDDieta NUMBER(10) NOT NULL,
       IDReceta NUMBER(10) NOT NULL,
       PRIMARY KEY(IDDieta, IDReceta),
       FOREIGN KEY(IDDieta) REFERENCES Dieta(IDDieta) on delete cascade,
       FOREIGN KEY(IDReceta) REFERENCES Receta(IDReceta) on delete cascade
);

CREATE TABLE DietaUsuario(
       IDDieta NUMBER(10) NOT NULL,
       IDUsuario NUMBER(10) NOT NULL,
       PRIMARY KEY(IDDieta, IDUsuario),
       FOREIGN KEY(IDDieta) REFERENCES Dieta(IDDieta) on delete cascade,
       FOREIGN KEY(IDUsuario) REFERENCES Usuario(IDUsuario) on delete cascade
);

CREATE TABLE RecetaProducto(
       IDReceta NUMBER(10) NOT NULL,
       IDProducto NUMBER(10) NOT NULL,
       Cantidad NUMBER(10,2) NOT NULL,
       PRIMARY KEY(IDReceta, IDProducto),
       FOREIGN KEY(IDReceta) REFERENCES Receta(IDReceta) on delete cascade,
       FOREIGN KEY(IDProducto) REFERENCES Producto(IDProducto) on delete cascade
);



-- Vistas
CREATE OR REPLACE VIEW view1 AS
select
   c1.idusuario,
   c1.idproducto,
   c1.nombre,
   c1.cantidad comprado,
   NVL(c2.cantidad,0) gastado,
   NVL(c1.cantidad - c2.cantidad, c1.cantidad) disponible
from
    (select
      c.idusuario,
      p.idproducto,
      p.nombre,
      sum(cantidad) cantidad
    from
      compraproductosuper cps,
      compra c,
      producto p
    where
      c.idcompra = cps.idcompra
    and
      p.idproducto = cps.idproducto
    group by
      c.idusuario, p.idproducto, p.nombre) c1
LEFT OUTER JOIN
    (select
       cm.idusuario,
       rp.idproducto,
       sum(rp.cantidad) cantidad
    from
       recetaproducto rp, comida cm
    where
       cm.idreceta=rp.idreceta
    group by
       cm.idusuario, rp.idproducto) c2
ON
    c1.idproducto = c2.idproducto
and c1.idusuario = c2.idusuario;

-- Procedimientos y funciones
CREATE OR REPLACE FUNCTION ObtenerGastoTotal(iduser IN number)
   RETURN number
IS
   output number;
   cursor c1 is
   SELECT sum(c.Precio)
     FROM CompraProductoSuper c, Compra com
     WHERE com.IDUsuario = iduser and
      com.IDCompra = c.IDCompra;
BEGIN
   open c1;
   fetch c1 into output;
   close c1;
RETURN output;
END;
/

CREATE OR REPLACE FUNCTION NumeroTotalComidas(iduser IN number)
RETURN NUMBER IS output NUMBER;
BEGIN
 select count(*) INTO output
 from Comida c
 where c.IDUsuario = iduser;
 return (output);
END;
/

CREATE OR REPLACE FUNCTION (iduser IN number)
RETURN NUMBER IS output NUMBER;
BEGIN
 select count(*) INTO output
 from Comida c
 where c.IDUsuario = iduser;
 return (output);
END;
/

-- Consulta para obtener toda la cantidad comprada de cada articulo:
select p.nombre, sum(cps.cantidad)
    from compraproductosuper cps,
       compra c, producto p
    where
       c.idcompra = cps.idcompra
    and
       c.idusuario = '2'
    and
       p.idproducto = cps.idproducto
    group by
       p.idproducto, p.nombre;

-- Paquete Stock : Declaración
CREATE OR REPLACE PACKAGE Stock AS
   FUNCTION MostrarStock(iduser number) return SYS_REFCURSOR;
END Stock;
/
-- Paquete Stock : Cuerpo
CREATE OR REPLACE PACKAGE BODY Stock AS
   FUNCTION MostrarStock(iduser IN number)
   RETURN SYS_REFCURSOR IS
     my_cursor SYS_REFCURSOR;
   BEGIN
     open my_cursor for
       select
         c1.idproducto,
         c1.nombre,
         c1.cantidad comprado,
         NVL(c2.cantidad,0) gastado,
         NVL(c1.cantidad - c2.cantidad, c1.cantidad) disponible
       from
         (select
           p.idproducto,
           p.nombre,
           sum(cantidad) cantidad
          from
           compraproductosuper cps,
           compra c,
           producto p
       where
           c.idcompra = cps.idcompra
       and
           c.idusuario=iduser
       and
           p.idproducto = cps.idproducto
       group by
           p.idproducto, p.nombre) c1
   LEFT OUTER JOIN
    (select
       rp.idproducto,
       sum(rp.cantidad) cantidad
    from
       recetaproducto rp, comida cm
    where
       cm.idusuario=iduser
    and
       cm.idreceta=rp.idreceta
    group by
       rp.idproducto) c2
    ON
       c1.idproducto = c2.idproducto;
  RETURN my_cursor;
  END MostrarStock;
END Stock;
/


-- Consulta que obtiene el stock
select
   c1.idproducto,
   c1.nombre,
   c1.cantidad comprado,
   NVL(c2.cantidad,0) gastado,
   NVL(c1.cantidad - c2.cantidad, c1.cantidad) disponible
from
    (select
      p.idproducto,
      p.nombre,
      sum(cantidad) cantidad
    from
      compraproductosuper cps,
      compra c,
      producto p
    where
      c.idcompra = cps.idcompra
    and
      c.idusuario='2'
    and
      p.idproducto = cps.idproducto
    group by
      p.idproducto, p.nombre) c1
LEFT OUTER JOIN
    (select
       rp.idproducto,
       sum(rp.cantidad) cantidad
    from
       recetaproducto rp, comida cm
    where
       cm.idusuario='2'
    and
       cm.idreceta=rp.idreceta
    group by
       rp.idproducto) c2
ON
    c1.idproducto = c2.idproducto;







select r.idreceta, r.nombre
from receta r, recetaproducto rp,
(select
p.idproducto,
sum(cantidad) cantidad
from
compraproductosuper cps,
compra c,
producto p
where
c.idcompra = cps.idcompra
and
c.idusuario='2'
and
p.idproducto = cps.idproducto
group by
p.idproducto) c1
where
r.idreceta = rp.idreceta and
c1.idproducto = rp.idproducto and
c1.cantidad >= rp.cantidad;


COMMIT;





select
   r.idreceta,
   r.nombre,
   c1.nombre Producto,
   c1.cantidad STOCK,
   rp.cantidad INGREDIENTE
from
   receta r,
   recetaproducto rp,
   (select
      p.idproducto,
      sum(cantidad) cantidad,
      p.nombre
    from
      compraproductosuper cps,
      compra c,
      producto p
    where
      c.idcompra = cps.idcompra
    and
      c.idusuario = '2'
    and
      p.idproducto = cps.idproducto
    group by
      p.idproducto) c1
where
   r.idreceta = rp.idreceta
and
   c1.idproducto = rp.idproducto
and
   c1.cantidad >= rp.cantidad;






select
   s.nombre,
   sum(c1.preciomedio*rp.cantidad)
from
   super s,
   dietareceta dr,
   recetaproducto rp
   (select
       c.idproducto,
       cps.idsuper,
       avg(cps.precio)/avg(cps.cantidad) preciomedio
    from
       compra c,
       compraproductosuper cps
    where
        c.idusuario = '2' and
        c.idcompra = cps.idcompra
    group by
        c.idCompra) c1
where
   dr.idDieta = '1'
and
   dr.idreceta = rp.idreceta
and
   rp.idproducto = c1.idproducto
and
   c1.idsuper = s.idsuper;












select
   c1.idproducto
from
    (select
      p.idproducto,
      p.nombre,
      sum(cantidad) cantidad
    from
      compraproductosuper cps,
      compra c,
      producto p
    where
      c.idcompra = cps.idcompra
    and
      c.idusuario='2'
    and
      p.idproducto = cps.idproducto
    group by
      p.idproducto, p.nombre) c1
LEFT OUTER JOIN
    (select
       rp.idproducto,
       sum(rp.cantidad) cantidad
    from
       recetaproducto rp, comida cm
    where
       cm.idusuario='2'
    and
       cm.idreceta=rp.idreceta
    group by
       rp.idproducto) c2
ON
    c1.idproducto = c2.idproducto;
