use beyonz;

SELECT * FROM Fotos order by FOTOS_NN

--CONSULTAS INDIVIDUALES DE LAS TABLAS
select* from uni_articulos
select* from uni_categoria
select* from uni_genero
select* from uni_estado
select* from uni_pedido
select* from uni_pedido_estado
select* from uni_roles_sesion
select* from uni_bitacora_sesion
select* from uni_vale
select* from uni_venta 
select* from uni_venta_articulo order by id_venta
select* from DIRECTORIO_0
select* from uni_vale
select* from uni_vale_uniforme
select* from uni_tipo_vale
select* from uni_roles_sesion
select* from uni_rol
--Usuarios del sistema de uniformes
select rs.id_usuario, d.Nombre from uni_roles_sesion AS rs inner join DIRECTORIO_0 as d ON rs.id_usuario = d.ID 

--Obtener unicamente los tipos de tallas sin repetir los valores
SELECT 
	   MIN(id_categoria) AS id_categoria,
       MIN(abrev) AS abrev,
       MIN(categoria) AS categoria,
	   tipo_talla
FROM uni_categoria
GROUP BY tipo_talla;

--OBTENER LOS AÑOS SELECCIONABLES PARA LOS FILTROS DE FECHA EN LAS CONSULTAS DE ALMACEN
select DISTINCT YEAR(fecha_creacion) as año from uni_pedido

--CONSULTA PARA OBTENER LOS PEDIDOS CON FILTROS
SELECT p.id_pedido, p.num_pedido, p.fecha_creacion, e.pedido_estado, d.nombre from uni_pedido as p 
                inner join DIRECTORIO_0 AS d on p.id_usuario = d.ID
                inner join uni_pedido_estado as e on p.status = e.id_estado
				WHERE 1=1 and
					MONTH(p.fecha_creacion) = 11 
					AND YEAR(p.fecha_creacion) = 2024
					AND e.id_estado = 2
			order by id_pedido;

--CONSULTA PARA OBTENER LOS DETALLES DE CADA PEDIDO CON SUS ARTICULOS 
	select a.id_articulo as clave, a.nombre as Articulo, dp.Cantidad, dp.costo, (dp.cantidad* dp.costo) as total 
			from uni_pedido_articulo as dp 
				inner join uni_articulos as a on dp.id_articulo= a.id_articulo 
		where id_pedido='1069'

--CONSULTA PARA OBTENER LOS DATOS DE LA VENTA 
 --Esta consulta filtra los valores antes de agrupar los esto hace que al concatenar las categiras se concatene una unica categoria, 
 --ya que para todos los registros existira solo la categoria filtrada, esto es utilo si no se quiere mostrar las categorias a aplicar alguna otra 
 --operacion sobre estas
    select v.id_venta, v.fecha, e.usuario, dr.Nombre, v.pago_total from uni_venta as v 
		inner join (SELECT
							MIN(id_usuario) AS id_usuario,
							MIN(usuario) AS usuario
					FROM empleado
					GROUP BY id_usuario) as e on v.id_empleado = e.id_usuario --NOMBRE DEL EMPLEADO
		left join DIRECTORIO_0 as dr on v.id_usuario= dr.ID --NOMBRE DEL USUARIO
		left join uni_venta_articulo as va on v.id_venta = va.id_venta -- ARTICULOS PERTENECIENTES A LA VENTA
		left join uni_articulos as a  on va.id_articulo = a.id_articulo -- CATEGORIA DEL ARTICULO 
	group by v.id_venta, v.fecha, e.usuario, dr.Nombre, v.pago_total

--Esta segunda consulta filtra los datos despues de haberlos agrupado, para esto se usa HAVING en vez de where 
--lo que permitira tener todas las categorias correspondientes a la venta no solo la que se filtro
	select v.id_venta, v.fecha, e.usuario, dr.Nombre, v.pago_total, STRING_AGG(a.id_categoria, ', ') AS categorias from uni_venta as v 
			inner join (SELECT
								MIN(id_usuario) AS id_usuario,
								MIN(usuario) AS usuario
						FROM empleado
						GROUP BY id_usuario) as e on v.id_empleado = e.id_usuario
			left join DIRECTORIO_0 as dr on v.id_usuario= dr.ID
			left join uni_venta_articulo as va on v.id_venta = va.id_venta
			left join uni_articulos as a  on va.id_articulo = a.id_articulo
		group by v.id_venta, v.fecha, e.usuario, dr.Nombre, v.pago_total 
		--Campo donde se concatenan las categorias STRING_AGG(a.id_categoria, ', '

	--CHARINDEX, devuelve la posicion del caracter buscado en una cadena separada por comas, si existe el indice sera mayor a 0
	-- por eso se le agrega la condicion > 0

		SELECT id_venta, count(*) as cantidad FROM uni_venta_articulo group by id_venta order by cantidad
	--En esta consulta al hacer un join con venta_articulo trae los registros de ese tabla, pero al agregar la clausula de GROUP BY de los campo seleccionados se logra que solo traiga los valores de la tabla principal (uni_venta)

	
	select* from uni_categoria


--CONSULTA PARA OBTENER LOS DATOS DE LOS ARTICULOS DE CADA VENTA
	SELECT va.id_venta as venta, va.id_articulo, v.fecha, va.cantidad, a.nombre from uni_venta_articulo va 
			inner join uni_articulos as a on va.id_articulo = a.id_articulo
			left join uni_venta as v on v.id_venta= va.id_venta
		where 1=1 and v.id_empleado = '1538' and a.id_categoria='4' and v.id_usuario = '7' order by v.id_venta;




--EJEMPLO DE USO DE LA FUNCION STRING_AGG, permite agrupar valores de un campo en especifico indicandole el caracter de agrupacion o de separacion			
SELECT STRING_AGG( id_articulo, ', ') AS art from uni_articulos

--EJEMPLO DEL USO DE LA CONSULTA GROUP BY
select id_articulo, nombre, clave_comercial from uni_articulos GROUP BY id_articulo, nombre, clave_comercial
select id_articulo, MIN(nombre) AS c2, MIN(clave_comercial) as c3 from uni_articulos GROUP BY id_articulo


SELECT CHARINDEX('ab','bc,b,ab,c,def');

select* from uni_salida_articulo order by id_usuario
	SELECT us.id_salida, FORMAT(us.fecha,'yyyy-mm-dd HH:mm') as fecha, e.usuario as empleado, d.Nombre as usuario, ts.tipo_salida from uni_salida as us 
		left join DIRECTORIO_0 AS d on us.id_usuario = d.ID
		left join (select id_usuario, usuario from empleado group by id_usuario, usuario) as e on us.id_empleado = e.id_usuario
		inner join uni_tipo_salida as ts on us.tipo_salida = ts.id_tipo_salida where us.id_usuario = '94'

	select usa.id_salida, FORMAT(us.fecha,'yyyy-MM-dd HH:mm') as fecha, a.nombre as articulo, usa.cantidad from uni_salida_articulo as usa 
		left join uni_articulos as a on usa.id_articulo = a.id_articulo
		inner join uni_salida as us on usa.id_salida = us.id_salida where 1=1 AND us.id_usuario = '94'

		select* from uni_venta_articulo
		select* from uni_venta

		select* from uni_vale_uniforme

		select id_venta, FORMAT(fecha, 'yyyy-MM-dd HH:mm') as fecha, e.usuario, pago_total, 
						num_descuentos, (ISNULL(CASE WHEN uv.check_1 = 1 THEN 1 ELSE 0 END, 0) +
										 ISNULL(CASE WHEN uv.check_2 = 1 THEN 1 ELSE 0 END, 0) +
										 ISNULL(CASE WHEN uv.check_3 = 1 THEN 1 ELSE 0 END, 0) +
										 ISNULL(CASE WHEN uv.check_4 = 1 THEN 1 ELSE 0 END, 0)) AS aplicados, 
					firma,  SUM(pago_total) OVER () as total
					from uni_venta as uv left join (select id_usuario, usuario from empleado group by id_usuario, usuario) 
					as e on uv.id_empleado = e.id_usuario where year(fecha) = 2024 and month(fecha)= 12


				  SELECT id_venta, check_nombre, check_valor, fecha
						FROM uni_venta
						UNPIVOT (
							check_valor FOR check_nombre IN (check_1, check_2, check_3, check_4)
						) AS unpvt where id_venta=2417;


			SELECT id_venta, num_descuentos, check_nombre, check_valor, fechaC, descuento
					FROM uni_venta
					CROSS APPLY (
									VALUES
										('check_1', check_1, fecha_1, descuento_1),
										('check_2', check_2, fecha_2, descuento_2),
										('check_3', check_3, fecha_3, descuento_3),
										('check_4', check_4, fecha_4, descuento_4)
								) AS datos(check_nombre, check_valor, fechaC, descuento)
					where id_venta=4;


		select* from uni_venta_articulo
		select* from uni_venta order by fecha

	-- CONSULTA PARA OBTENER VENTAS Y GANANCIAS POR CATEGORIAS 
		 select uc.categoria, 
				AVG(uva.costo) as costoPromedio, 
				SUM(uva.precio * uva.cantidad) costoVenta, 
				SUM(uva.costo * uva.cantidad) as costoCompra,
				( SUM(uva.precio * uva.cantidad) - SUM(uva.costo * uva.cantidad)) as gananciaPorCategoria,
				SUM(SUM(uva.precio * uva.cantidad) - SUM(uva.costo * uva.cantidad)) over () as gananciaTotal
			from uni_venta_articulo as uva
					inner join uni_articulos as ua on uva.id_articulo = ua.id_articulo
					inner join uni_categoria as uc on ua.id_categoria = uc.id_categoria
					left join uni_venta as uv on uv.id_venta =uva.id_venta
					WHERE 1=1 and
				group by categoria 
			order by categoria
	--- FIN CONSULTAS



	--CONSULTA PARA OBTENER EL LISTADO DE VENTAS REGISTRADAS CON SU VALOR DE VENTA TOTAL POR FECHA 
		select FORMAT(uv.fecha, 'yyyy/MM/dd HH:mm')  as fecha, SUM(pago_total) as ventaTotal, SUM( SUM(pago_total)) over () AS ventasTotales
				from uni_venta as uv 
			group by  FORMAT(uv.fecha, 'yyyy/MM/dd HH:mm'), id_venta
		order by fecha
	--- FIN CONSULTAS


	--NUMERO DE VENTAS
		select id_venta, fecha, SUM( SUM(pago_total)) over () AS ventasTotales from uni_venta where fecha between '2025/02/1' and '2025/03/1' group by id_venta, fecha
			select count(id_venta) as numVentas, sum(pago_total) as ventasTotales, AVG(ISNULL(pago_total,0)) AS ventasPromeio from uni_venta
	--- FIN CONSULTAS


	--CONSULTA PARA OBTENER LOS ARTICULOS CON LOS QUE SE ENCUNTRAN EN TRANSITO POR ALGUN PEDIDO PARA LA TABLA DE ALMACEN
		SELECT a.id_articulo, a.nombre, u.talla, g.genero, a.cantidad as cantFisica, 
                     isNULL(cantTran, 0) as cantTran, (isNULL ((a.cantidad + cantTran), 0)) as total,
                     a.costo, a.precio,  a.stock_max, a.stock_min
                    from uni_articulos as a 
                        inner join uni_talla as u on a.id_talla = u.id_talla 
                        inner join uni_estado as e on a.id_estado = e.id_estado
                        inner join uni_genero as g on a.genero = g.id_genero
                        left join ( select distinct(id_articulo) as id_articulo, SUM(cantidad) as cantTran from uni_pedido as up 
										inner join uni_pedido_articulo as upa on up.id_pedido = upa.id_pedido 
									where status='2' group by id_articulo) as atr on a.id_articulo= atr.id_articulo
                    where 1=1 
	--- FIN CONSULTAS

	--OBTENER LOS NUMEROS DE PEDIDOS POR AÑO Y ,ES Y GENERAR EL ID CORRESPONDIENTE
		DECLARE @AnioMes NVARCHAR(7) = FORMAT(GETDATE(), 'yyyy/MM');
		DECLARE @Numero INT = (
			SELECT COUNT(*) + 1
			FROM uni_pedido
			WHERE FORMAT(fecha_creacion, 'yyyy/MM') = FORMAT(GETDATE(), 'yyyy/MM')
		);
		DECLARE @Consecutivo NVARCHAR(3) = RIGHT('000' + CAST(@Numero AS VARCHAR), 3);

		-- Resultado final
		SELECT @AnioMes + '/' + @Consecutivo AS IdPedido;


		WITH Secuencia AS (
			SELECT COUNT(*) + 1 AS num
			FROM uni_pedido
			WHERE fecha_creacion BETWEEN 
				DATEADD(MONTH, DATEDIFF(MONTH, 0, GETDATE()), 0) 
				AND EOMONTH(GETDATE())
		)
		SELECT 
			CONVERT(VARCHAR(7), GETDATE(), 111) 
			+ '/' 
			+ RIGHT(REPLICATE('0', 3) + CAST(num AS VARCHAR(3)), 3)
		FROM Secuencia;


		SELECT 
			CONVERT(VARCHAR(7), GETDATE(), 111) 
			+ '/' 
			+ RIGHT(REPLICATE('0', 3) 
				+ CAST(
					(SELECT COUNT(*) + 1 
					 FROM uni_pedido 
					 WHERE fecha_creacion >= DATEADD(MONTH, DATEDIFF(MONTH, 0, GETDATE()), 0)
					   AND fecha_creacion < DATEADD(MONTH, 1, DATEADD(MONTH, DATEDIFF(MONTH, 0, GETDATE()), 0))) as VARCHAR(3)), 3);

		select  FORMAT(GETDATE(), 'yyyy/MM') 
				+ '/' 
				+ RIGHT('000' + CAST((SELECT COUNT(*) + 1 FROM uni_pedido 
										WHERE FORMAT(fecha_creacion, 'yyyy/MM')  = FORMAT(GETDATE(), 'yyyy/MM')) AS VARCHAR), 3) 
			as num_pedido;
	--- FIN CONSULTAS


	select ua.id_articulo, ua.cantidad, ua.nombre, uc.categoria, ut.talla,  ug.genero from uni_articulos as ua
		inner join uni_categoria as uc on ua.id_categoria = uc.id_categoria
		inner join uni_genero as ug on ua.genero = ug.id_genero
		inner join uni_talla as ut on ua.id_talla = ut.id_talla
		where cantidad <= stock_min


	--CONSULTA PARA LA ENTRADA POR ARTICULOS REGISTRADOS COMO SALIDA

		select* from uni_salida as us inner join uni_salida_articulo as usa on us.id_salida = usa.id_salida 
			where FORMAT(us.fecha, 'yyyy/MM/dd') between '2025-01-01' and '2025-05-31'


		--Obtener las tallas de la categoria 
			select ua.id_talla, ut.talla from uni_articulos ua
				inner join uni_talla as ut on ua.id_talla = ut.id_talla 
				group by id_categoria, ua.id_talla, ut.tipo_talla, ut.talla   

			--Obtener los generos de la categoria
			select ua.id_categoria, ug.id_genero, ug.genero from uni_articulos as ua 
				left join uni_genero as ug on ua.genero = ug.id_genero 
			 group by id_categoria, ug.genero, ug.id_genero

			 select* from uni_talla
			 select* from uni_tipo_talla

			 select id_articulo, nombre, cantidad, precio from uni_articulos where id_talla = '2' and genero='1' and id_categoria=2 and eliminado='0'




			 select rs.id_usuario, d.Nombre, d.passwrd, rs.id_rol, ur.rol
					from uni_roles_sesion AS rs 
				inner join DIRECTORIO_0 as d ON rs.id_usuario = d.ID 
				left join uni_rol as ur on rs.id_rol = ur.id_rol 
			order by id_rol

select* from uni_salida_articulo where id_salida = '15'

-- CONSULTA PARA ELIMINAR VALORES DUPLICADOS EN TABLAS SIN IDENTIFICADOR UNICO
WITH Duplicados AS (
   SELECT *,
			 ROW_NUMBER() OVER (PARTITION BY id_salida, id_articulo, cantidad ORDER BY id_salida) AS fila
	  FROM uni_salida_articulo 
)
delete FROM Duplicados WHERE fila > 1;


select* from uni_articulos

select* from uni_tipo_salida
	--LA SALIDA POR VALE NO REGISTRA Y NO MUESTRA EL PRECIO EN LA SALIDA (1)
	--LA VENTA DE UNIFORE REGISTRA Y MUESTA LA EL PRECIO DE LA VENTA (2)
	--EN LA ENTREGA DE UNIFORME USADO EL UNICO REGISTRO LE ASIGNO UN VALOR DE 0 AL PRECIO Y EN REPORTE LO MUESTRA EN BLANCO (3)
	--LA SALIDA POR REPOSICIÓN DE UNIFORME SI REGITRA PERO NO LA MUESTRA EN EL REPORTE (4) 
	--LA SALIDA POR CAMBIO SOLO EN UNA NO REGITRO EL PRECIO Y EN EL REPORTE NO SE MUESTRA (5)
	--LA SALIDA POR RENOVACION DE UNIFORME EN ALGUNOS SI ESTA EL REGISTRO Y EN OTROS NO TAL VEZ SEA UNA FALLA  Y EN EL REPORTE NO SE MUESTRA (6)

SELECT us.id_salida, us.vale, FORMAT(us.fecha, 'yyyy-MM-dd HH:mm') AS fecha, ts.id_tipo_salida, ts.tipo_salida,  d.Nombre as realizado_por, e.id_usuario as NN, e.usuario as empleado, tv.nombre
                    FROM uni_salida as us 
                left join DIRECTORIO_0 AS d on us.id_usuario = d.ID
                left join (select id_usuario, usuario from empleado group by id_usuario, usuario) as e on us.id_empleado = e.id_usuario
                left join uni_tipo_salida as ts on us.tipo_salida = ts.id_tipo_salida
				left join (select tipo_vale,barcode from uni_vale group by tipo_vale, barcode) as uv on us.vale = uv.barcode 
				left join uni_tipo_vale as tv on uv.tipo_vale = tv.id_tipo_vale WHERE 1=1