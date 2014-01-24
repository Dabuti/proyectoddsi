CREATE TABLE Usuario(
       IDUsuario int NOT NULL IDENTITY,
       Nombre char(20) NOT NULL,
       Apellido1 char(20) NOT NULL,
       Apellido2 char(20),
       Username varchar(20) NOT NULL UNIQUE,
       Password varchar(20) NOT NULL,
       PRIMARY KEY(IDUsuario)
);

CREATE TABLE Compra(
       IDCompra int NOT NULL IDENTITY,
       Fecha DATE DEFAULT (sysdate),
       IDUsuario int NOT NULL,
       PRIMARY KEY(IDCompra),
       FOREIGN KEY(IDUsuario) REFERENCES Usuario(IDUsuario)
);

CREATE TABLE Receta(
       IDReceta int NOT NULL IDENTITY,
       Nombre char(20) NOT NULL,
       Personas smallint NOT NULL,
       Tiempo smallint NOT NULL,
       Descripcion char(200),  --NOT NULL??
       PRIMARY KEY(IDReceta)
);

CREATE TABLE Comida(
       IDComida int NOT NULL IDENTITY,
       Fecha DATE DEFAULT(sysdate),
       IDUsuario int NOT NULL,
       IDReceta int NOT NULL,
       PRIMARY KEY(IDComida),
       FOREIGN KEY(IDUsuario) REFERENCES Usuario(IDUsuario),
       FOREIGN KEY(IDReceta) REFERENCES Receta(IDReceta)
);

CREATE TABLE Dieta(
       IDDieta int NOT NULL IDENTITY,
       Nombre char(20) NOT NULL,
       Descripcion char(200),
       IDUsuario int NOT NULL,
       PRIMARY KEY(IDDieta),
       FOREIGN KEY(IDUsuario) REFERENCES Usuario(IDUsuario)
);

CREATE TABLE Producto(
       IDProducto int NOT NULL IDENTITY,
       Nombre char(20) NOT NULL,
       Calorias smallint,
       Descripcion char(200),
       PRIMARY KEY(IDProducto)
);

CREATE TABLE Super(
       IDSuper int NOT NULL IDENTITY,
       Nombre char(20) NOT NULL,
       Direccion varchar(30),
       Telefono number(9),
       Web char(20),
       PRIMARY KEY(IDSuper)
);

CREATE TABLE ProductoSuper(
       IDProducto int NOT NULL,
       IDSuper int NOT NULL,
       PRIMARY KEY(IDProducto, IDSuper),
       FOREIGN KEY(IDProducto) REFERENCES Producto(IDProducto),
       FOREIGN KEY(IDSuper) REFERENCES Super(IDSuper)
);

CREATE TABLE CompraProductoSuper(
       IDCompra int NOT NULL,
       IDProducto int NOT NULL,
       IDSuper int NOT NULL,
       Cantidad smallint NOT NULL,
       Precio number NOT NULL,
       PRIMARY KEY(IDCompra, IDProducto, IDSuper),
       FOREIGN KEY(IDCompra) REFERENCES Compra(IDCompra),
       FOREIGN KEY(IDProducto, IDSuper) REFERENCES ProductoSuper(IDProducto, IDSuper)
);

CREATE TABLE DietaReceta(
       IDDieta int NOT NULL,
       IDReceta int NOT NULL,
       PRIMARY KEY(IDDieta, IDReceta),
       FOREIGN KEY(IDDieta) REFERENCES Dieta(IDDieta),
       FOREIGN KEY(IDReceta) REFERENCES Receta(IDReceta)
);

CREATE TABLE RecetaProducto(
       IDReceta int NOT NULL,
       IDProducto int NOT NULL,
       Cantidad smallint NOT NULL,
       PRIMARY KEY(IDReceta, IDProducto),
       FOREIGN KEY(IDReceta) REFERENCES Receta(IDReceta),
       FOREIGN KEY(IDProducto) REFERENCES Producto(IDProducto)       
);

COMMIT;
