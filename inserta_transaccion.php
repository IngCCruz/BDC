<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gasto actual</title>
</head>
<body>
    <?php 
        include 'conexion.php';
    ?>

    <a href="index.php">Inicio</a>


    <h3>Insertar transaccion</h3>
    <?php
        $result0 = mysqli_query($link,"SELECT max(id)+1 FROM ultima_horneada") or die('Consulta fallida: ' . mysql_error());
        if (!$result0) {
            echo 'No se pudo ejecutar la consulta: ' . mysql_error();
            exit;
        }
        $var = mysqli_fetch_row($result0);
        $idTransaccion = $var[0];
        if(!$idTransaccion){
            $idTransaccion = 1;
        }
        $result1 = mysqli_query($link,"SELECT id,grupo,nombre,unidad FROM productos") or die('Consulta fallida: ' . mysql_error());
        $result2 = mysqli_query($link,"SELECT id,nombre FROM ttransacciones") or die('Consulta fallida: ' . mysql_error());
        $result3 = mysqli_query($link,"SELECT max(horneada)+1 FROM reporte") or die('Consulta fallida: ' . mysql_error());
        if (!$result3) {
            echo 'No se pudo ejecutar la consulta: ' . mysql_error();
            exit;
        }
        $var3 = mysqli_fetch_row($result3);
        $horneada = $var3[0];
        if(!$horneada){
            $horneada = 1;
        }        
    ?>
    <table>
        <th>Horneada</th><th>Producto</th><th>Cantidad</th><th>Importe</th>
        <form method="POST">
        <tr>
            <td><?php   echo $horneada; ?></td>
            <td>
                <select name="idProducto"> 
                    <?php
                        while ($fila = $result1->fetch_assoc()):
                            $id = $fila['id'];
                            $grupo = $fila['grupo'];
                            $nombre = $fila['nombre'];
                            $unidad = $fila['unidad'];
                            echo "<option value=$id>$nombre ($grupo) $unidad</option>";
                        endwhile;
                    ?>
                </select>
            </td>
            <td><input type="decimal" name="cantidad"></td>
            <td><input type="decimal" name="transaccion"></td>
        </tr>
        <tr>
            <td><input type="submit" name="submit" value="Insertar"></td>
        </tr>
        </form>
    </table>
    <?php 
        if(isset($_POST["submit"])) {
            if(empty($_POST["idProducto"]) || empty($_POST["cantidad"])){
                echo "<p>FALTAN DATOS</p>";
                echo "<meta http-equiv='refresh' content='1'>";
            }else{
                $idProducto = $_POST["idProducto"];

                // $query4 = ;
                $result4 = mysqli_query($link,"SELECT id_ttransaccion FROM productos WHERE id = $idProducto; ") or die('Consulta fallida: ' . mysql_error());
                $var4 = mysqli_fetch_row($result4);
                $idTipoTransaccion = $var4[0];

                // Insert
                $query = 'INSERT INTO ultima_horneada(id,idproducto,idttransaccion,horneada,cantidad,importe) 
                VALUES ('.$idTransaccion.','.$idProducto.','.$idTipoTransaccion.','.$horneada.','.$_POST["cantidad"].','.$_POST["transaccion"].')';

                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
    ?>
    <br>

    <h2>Gastos de última horneada</h2>
    <h3>Transacciones</h3>
    <table>
        <th>Producto</th><th>Tipo de transaccion</th><th>Horneada</th><th>Cantidad</th><th>Importe</th>
        <?php
            $query = 'SELECT p.nombre as Nombre, tt.nombre as "TipoTransaccion", uh.Horneada, uh.Cantidad, uh.importe
                    FROM ultima_horneada uh
                    JOIN productos p ON uh.idproducto = p.id
                    JOIN ttransacciones tt ON uh.idttransaccion = tt.id;';
            $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
        
            while($row = mysqli_fetch_array($result)){
        ?>
            
        <tr>
            <td><?php echo $row['Nombre'] ?></td>
            <td><?php echo $row['TipoTransaccion'] ?></td>
            <td><?php echo $row['Horneada'] ?></td>
            <td><?php echo $row['Cantidad'] ?></td>
            <td><?php echo $row['importe'] ?></td>
        </tr>
        <?php
            }
        ?>
    </table>


</body>
</html>