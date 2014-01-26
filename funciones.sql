--NUMERO DE COMIDAS
CREATE OR REPLACE FUNCTION NumeroTotalCompras(iduser IN number)
RETURN NUMBER IS output NUMBER;
BEGIN
	select count(*) INTO output
	from Comida c
	where c.IDUsuario = iduser;
	return (output);
END;

--TOTAL GASTADO
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


