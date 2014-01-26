--1.2 NÚMERO DE COMIDAS PREPARADAS POR UN USUARIO
CREATE OR REPLACE FUNCTION NumeroTotalCompras(iduser IN number)
RETURN NUMBER IS output NUMBER;
BEGIN
	select count(*) INTO output
	from Comida c
	where c.IDUsuario = iduser;
	return (output);
END;

--1.1 TOTAL GASTADO POR UN USUARIO
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

--2.1 TOTAL GASTADO DESDE EL DIA 1 DEL MES
SELECT trunc(sysdate, 'mm') primer_dia_del_mes,
trunc(last_day(sysdate)) ultimo_dia_del_mes 
FROM dual;

--2.2 NUMERO DE COMIDAS DESDE EL DIA 1 DEL MES
