<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gasto actual</title>
</head>
<body>
    <?php include 'conexion.php';?>
    
    <h1>Gastos de última horneada</h1>
    <h2>Transacciones</h2>
    <table>
        <th>Producto</th><th>Tipo de transaccion</th><th>Horneada</th><th>Cantidad</th><th>Unidad</th><th>Importe</th>
        <?php
            $query = 'SELECT p.nombre as Nombre, tt.nombre as "TipoTransaccion", uh.Horneada, uh.Cantidad, uh.Unidad, uh.importe
                    FROM ultima_horneada uh
                    JOIN productos p ON uh.idproducto = p.id
                    JOIN ttransacciones tt ON uh.idttransaccion = tt.id;';
            $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
        
            while($row = mysqli_fetch_array($result)){
        ?>
            
        <tr>
            <td><?php echo $row['Nombre'] ?>  </td>
            <td><?php echo $row['TipoTransaccion'] ?>     </td>
            <td><?php echo $row['Horneada'] ?> </td>
            <td><?php echo $row['Cantidad'] ?>   </td>
            <td><?php echo $row['Unidad'] ?>  </td>
            <td><?php echo $row['importe'] ?>  </td>
        </tr>
        <?php
            }
        ?>
    </table>

    <h2>Insertar transaccion</h2>
    <?php
        $result0 = mysqli_query($link,"SELECT 1+max(id) FROM ultima_horneada") or die('Consulta fallida: ' . mysql_error());
        if (!$result0) {
            echo 'No se pudo ejecutar la consulta: ' . mysql_error();
            exit;
        }
        $var = mysqli_fetch_row($result0);
        $idTransaccion = $var[0];
        if(!$idTransaccion){
            $idTransaccion = 1;
        }
        $result1 = mysqli_query($link,"SELECT id,Grupo,Nombre FROM productos") or die('Consulta fallida: ' . mysql_error());
        $result2 = mysqli_query($link,"SELECT id,Nombre FROM ttransacciones") or die('Consulta fallida: ' . mysql_error());            
    ?>
    <table>
        <th>Producto</th><th>Transacción</th><th>Horneada</th><th>#Unidades</th><th>Unidad</th><th>Importe</th>
        <form method="POST">
        <tr>
            <td>
                <select name="idProducto"> 
                    <?php
                        while ($fila = $result1->fetch_assoc()):
                            $id = $fila['id'];
                            $grupo = $fila['Grupo'];
                            $nombre = $fila['Nombre'];
                            echo "<option value=$id>$id - $grupo - $nombre</option>";
                        endwhile;
                    ?>
                </select>
            </td>
            <td>
                <select name="idTipoTransaccion"> 
                    <?php
                        while ($fila = $result2->fetch_assoc()):
                            $id = $fila['id'];
                            $nombre = $fila['Nombre'];
                            echo "<option value=$id>$id - $nombre</option>";
                        endwhile;
                    ?>
                </select>
            </td>
            <td><input type="number" name="Horneada"></td>
            <td><input type="decimal" name="cantidad"></td>
            <td><input type="text" name="unidad"></td>
            <td><input type="decimal" name="transaccion"></td>
        </tr>
        <tr>
            <td><input type="submit" name="submit" value="Insertar"></td>
        </tr>
        </form>
    </table>
    <?php 
        if(isset($_POST["submit"])) {
            if(empty($_POST["idProducto"]) || empty($_POST["idTipoTransaccion"]) || empty($_POST["Horneada"]) || empty($_POST["cantidad"]) || empty($_POST["unidad"]) || empty($_POST["transaccion"])){
                echo "<p>FALTAN DATOS</p>";
                echo "<meta http-equiv='refresh' content='1'>";
            }else{
                $idProducto = $_POST["idProducto"];
                $idTipoTransaccion = $_POST["idTipoTransaccion"];
                $Horneada = $_POST["Horneada"];
                $cantidad = $_POST["cantidad"];
                $unidad = $_POST["unidad"];
                $transaccion = $_POST["transaccion"];
                // Insert
                $query = 'INSERT INTO ultima_horneada(id,idproducto,idttransaccion,horneada,cantidad,unidad,importe) 
                VALUES ('.$idTransaccion.','.$idProducto.','.$idTipoTransaccion.','.$Horneada.','.$cantidad.',"'.$unidad.'",'.$transaccion.')';
            
                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
    ?>
    <br>
    <h2> Vaciar precios a historico </h2>
    <form method="POST">
        <input type="submit" name="submit2" value="Vaciar Precios">
    </form> 

    <?php
        if(isset($_POST["submit2"]) && !empty($_POST["submit2"])) {
            $query = 'SELECT uh.id, uh.idproducto,r.fecha, uh.horneada, uh.cantidad, uh.importe precio, uh.importe/cantidad precio_unitario, uh.unidad FROM ultima_horneada uh JOIN reporte r ON uh.horneada = r.horneada';
            $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
            $var = mysqli_fetch_row($result);
            if(!$var){
                echo "<p>Ya no hay más registros de la última horneada<p>";
                echo "<meta http-equiv='refresh' content='2'>";
            }else{

                // Insert
                $query = 'INSERT INTO productos_h(idproducto,fecha,horneada,cantidad,precio,precio_u,unidad) 
                VALUES ('.$var[1].',"'.$var[2].'",'.$var[3].','.$var[4].','.$var[5].','.$var[6].',"'.$var[7].'");';
                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
                $drop_query='DELETE FROM ultima_horneada WHERE id='.$var[0].';';
                $result = mysqli_query($link,$drop_query) or die('Consulta fallida: ' . mysql_error());
                // echo $query;
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
    ?> 
    <br><br><br><br><br>
    <a href="ultima_horneada.php"> referesh </a>
    <br>
    <a href="index.php"> inicio </a>
</body>
</html>