CREATE TABLE Usuario(
       IDUsuario int NOT NULL,
       Nombre char(20) NOT NULL,
       Apellido1 char(20) NOT NULL,
       Apellido2 char(20),
       Username varchar(20) NOT NULL UNIQUE,
       Password varchar(20) NOT NULL,
       PRIMARY KEY(IDUsuario)
);

CREATE TABLE Compra(
       IDCompra NUMBER(10) NOT NULL,
       Fecha DATE DEFAULT (sysdate),
       IDUsuario NUMBER(10) NOT NULL,
       PRIMARY KEY(IDCompra),
       FOREIGN KEY(IDUsuario) REFERENCES Usuario(IDUsuario)
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
       IDReceta int NOT NULL IDENTITY,
       Nombre char(20) NOT NULL,
       Personas smallint NOT NULL,
       Tiempo smallint NOT NULL,
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
       FOREIGN KEY(IDUsuario) REFERENCES Usuario(IDUsuario),
       FOREIGN KEY(IDReceta) REFERENCES Receta(IDReceta)
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
       IDDieta NUMBER(10) NOT NULL IDENTITY,
       Nombre char(20) NOT NULL,
       Descripcion char(200),
       IDUsuario NUMBER(10) NOT NULL,
       PRIMARY KEY(IDDieta),
       FOREIGN KEY(IDUsuario) REFERENCES Usuario(IDUsuario)
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
       FOREIGN KEY(IDProducto) REFERENCES Producto(IDProducto),
       FOREIGN KEY(IDSuper) REFERENCES Super(IDSuper)
);

CREATE TABLE CompraProductoSuper(
       IDCompra NUMBER(10) NOT NULL,
       IDProducto NUMBER(10) NOT NULL,
       IDSuper NUMBER(10) NOT NULL,
       Cantidad NUMBER(10) NOT NULL,
       Precio NUMBER(10) NOT NULL,
       PRIMARY KEY(IDCompra, IDProducto, IDSuper),
       FOREIGN KEY(IDCompra) REFERENCES Compra(IDCompra),
       FOREIGN KEY(IDProducto, IDSuper) REFERENCES ProductoSuper(IDProducto, IDSuper)
);

CREATE TABLE DietaReceta(
       IDDieta NUMBER(10) NOT NULL,
       IDReceta NUMBER(10) NOT NULL,
       PRIMARY KEY(IDDieta, IDReceta),
       FOREIGN KEY(IDDieta) REFERENCES Dieta(IDDieta),
       FOREIGN KEY(IDReceta) REFERENCES Receta(IDReceta)
);

CREATE TABLE RecetaProducto(
       IDReceta NUMBER(10) NOT NULL,
       IDProducto NUMBER(10) NOT NULL,
       Cantidad NUMBER(10) NOT NULL,
       PRIMARY KEY(IDReceta, IDProducto),
       FOREIGN KEY(IDReceta) REFERENCES Receta(IDReceta),
       FOREIGN KEY(IDProducto) REFERENCES Producto(IDProducto)
);

COMMIT;
