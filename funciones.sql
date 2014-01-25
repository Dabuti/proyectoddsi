--TOTAL GASTADO
CREATE OR REPLACE FUNCTION ObtenerGastoTotal(iduser number)
RETURN number is output number;
BEGIN
	Select sum(c.Precio) INTO output
	from CompraProductoSuper c, Compra com
	where com.IDUsuario = iduser and
	com.IDCompra = c.IDCompra;
	return (output);
END;

--NUMERO DE COMPRAS
CREATE OR REPLACE FUNCTION NumeroTotalCompras(iduser number)
RETURN NUMBER IS output NUMBER;
BEGIN
	select count(*) INTO output
	from Comida c
	where c.IDUsuario = iduser;
	return (output);
END;

