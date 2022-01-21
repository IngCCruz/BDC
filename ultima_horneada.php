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
            // Conectando, seleccionando la base de datos
            $link = mysqli_connect($hostname_conexion, $username_conexion, $password_conexion) or die('No se pudo conectar: ' . mysql_error());
            mysqli_select_db($link,$database_conexion) or die('No se pudo seleccionar la base de datos');
         ?>

        <h1>Gastos de última horneada</h1>

        <h2>Transacciones</h2>

        <table>
            <th>Producto</th><th>Tipo de transaccion</th><th>Horneada</th><th>Fecha</th><th>Cantidad</th><th>Unidad</th><th>Transaccion</th>

            <?php
                $query = 'SELECT cp.Nombre as Nombre, ctt.Nombre as "TipoTransaccion", t.Horneada, t.Fecha, t.Cantidad, t.Unidad, t.Transaccion
                FROM transacciones t
                JOIN cat_productos cp ON t.idProducto = cp.idProducto
                JOIN cat_tipotransaccion ctt ON t.idTipoTransaccion = ctt.idTipoTransaccion;';
                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
            
            while($row = mysqli_fetch_array($result)){
            ?>
                
            <tr>
                <td><?php echo $row['Nombre'] ?>  </td>
                <td><?php echo $row['TipoTransaccion'] ?>     </td>
                <td><?php echo $row['Horneada'] ?> </td>
                <td><?php echo $row['Fecha'] ?>     </td>
                <td><?php echo $row['Cantidad'] ?>   </td>
                <td><?php echo $row['Unidad'] ?>  </td>
                <td><?php echo $row['Transaccion'] ?>  </td>
            </tr>
            <?php
                }
            ?>
        </table>


        <h2>Insertar transaccion</h2>
        <?php
            $result0 = mysqli_query($link,"SELECT 1+max(idTransaccion) FROM transacciones") or die('Consulta fallida: ' . mysql_error());
            if (!$result0) {
                echo 'No se pudo ejecutar la consulta: ' . mysql_error();
                exit;
            }
            $var = mysqli_fetch_row($result0);
            $idTransaccion = $var[0];
            if(!$idTransaccion){
                $idTransaccion = 1;
            }

            $result1 = mysqli_query($link,"SELECT idProducto,Grupo,Nombre FROM cat_productos") or die('Consulta fallida: ' . mysql_error());
            $result2 = mysqli_query($link,"SELECT idTipoTransaccion,Nombre FROM cat_tipotransaccion") or die('Consulta fallida: ' . mysql_error());            
        ?>

        <table>
            <th>Producto</th><th>Transacción</th><th>Horneada</th><th>Fecha</th><th>#Unidades</th><th>Unidad</th><th>Cantidad</th>
            <form method="POST">
            <tr>
                <td>
                    <select name="idProducto"> 
                        <?php
                            while ($fila = $result1->fetch_assoc()):
                                $id = $fila['idProducto'];
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
                                $id = $fila['idTipoTransaccion'];
                                $nombre = $fila['Nombre'];
                                echo "<option value=$id>$id - $nombre</option>";
                            endwhile;
                        ?>
                    </select>
                </td>
                <td>
                    <input type="number" name="Horneada">
                </td>
                <td>
                    <input type="date" name="Fecha">
                </td>
                <td>
                    <input type="decimal" name="cantidad">
                </td>
                <td>
                    <input type="text" name="unidad">
                </td>
                <td>
                    <input type="decimal" name="transaccion">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="submit" value="Insertar">                
                </td>
            </tr>
            </form>
        </table>


    <?php 
        if(isset($_POST["submit"]) && !empty($_POST["submit"])) {
            $idProducto = $_POST["idProducto"];
            $idTipoTransaccion = $_POST["idTipoTransaccion"];
            $Horneada = $_POST["Horneada"];
            $Fecha = $_POST["Fecha"];
            $cantidad = $_POST["cantidad"];
            $unidad = $_POST["unidad"];
            $transaccion = $_POST["transaccion"];

            // Insert
            $query = 'INSERT INTO transacciones(idTransaccion,idProducto,idTipoTransaccion,Horneada,Fecha,cantidad,unidad,transaccion) 
            VALUES ('.$idTransaccion.','.$idProducto.','.$idTipoTransaccion.','.$Horneada.',"'.$Fecha.'",'.$cantidad.',"'.$unidad.'",'.$transaccion.')';
        
            $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());

        }
    ?>
 
  
    <br><br><br><br><br>
    <a href="ultima_horneada.php"> Referesh </a>
    <br>
    <a href="index.php"> inicio </a>



    </body>
</html>