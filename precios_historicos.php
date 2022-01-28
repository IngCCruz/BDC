<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Precios Historicos</title>
</head>
<body>
    <?php include 'conexion.php';?> 

    <h2>Precios Historicos</h2>    
    <br>
    <h3>Selecciona producto: </h3>

    <?php
        $result = mysqli_query($link,"SELECT id, grupo, nombre FROM productos") or die('Consulta fallida: ' . mysql_error());
    ?>

    <table>
        <th>Producto</th>
        <form method="POST">
        <tr>
            <td>
                <select name="idProducto"> 
                    <?php
                        while ($fila = $result->fetch_assoc()):
                            $id = $fila['id'];
                            $grupo = $fila['grupo'];
                            $nombre = $fila['nombre'];
                            echo "<option value=$id>$id - $grupo - $nombre</option>";
                        endwhile;
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><input type="submit" name="submit" value="Busca"></td>
        </tr>
        </form>
    </table>

    <table>
        <th>Fecha</th><th>Horneada</th><th>Cantidad</th><th>Unidad</th><th>Precio</th><th>Precio unitario</th>

        <?php 
            if(isset($_POST["submit"]) && !empty($_POST["submit"])) {
                $idProducto = $_POST["idProducto"];

                $query = 'SELECT fecha,horneada,cantidad,unidad,precio,precio_u FROM productos_h WHERE idproducto = '.$idProducto.' ORDER BY fecha;';
                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
                while($row = mysqli_fetch_array($result)){
        ?>
                
        <tr>
            <td><?php echo $row['fecha'] ?></td>
            <td><?php echo $row['horneada'] ?></td>
            <td><?php echo $row['cantidad'] ?></td>
            <td><?php echo $row['unidad'] ?></td>
            <td><?php echo $row['precio'] ?></td>
            <td><?php echo $row['precio_u'] ?></td>
        </tr>
        <?php
                }   
            }
        ?>
    </table>
    
    

    <h3>Insertar nuevo historico </h3>

    <?php
        $result = mysqli_query($link,"SELECT id,Grupo,Nombre FROM productos") or die('Consulta fallida: ' . mysql_error());
    ?>

    <table>
        <th>Producto</th><th>Fecha</th><th>Horneada</th><th>Cantidad</th><th>Unidad</th><th>Precio</th><th>Precio unitario</th>
        <form method="POST">
        <tr>
            <td>
                <select name="idProducto"> 
                    <?php
                        while ($fila = $result->fetch_assoc()):
                            $id = $fila['id'];
                            $grupo = $fila['Grupo'];
                            $nombre = $fila['Nombre'];
                            echo "<option value=$id>$id - $grupo - $nombre</option>";
                        endwhile;
                    ?>
                </select>
            </td>
            <td><input type="date" name="Fecha"></td>
            <td><input type="number" name="Horneada"></td>
            <td><input type="decimal" name="cantidad"></td>
            <td><input type="text" name="unidad"></td>
            <td><input type="decimal" name="precio"></td>
            <td><input type="decimal" name="precio_u"></td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="submit2" value="Insertar">                
            </td>
        </tr>
        </form>
    </table>

    <?php 
        if(isset($_POST["submit2"])) {
            if(empty($_POST["Fecha"]) || empty($_POST["Horneada"]) || empty($_POST["cantidad"]) || empty($_POST["unidad"]) || empty($_POST["precio"]) || empty($_POST["precio_u"])){
                echo "<p>FALTAN DATOS</p>";
                echo "<meta http-equiv='refresh' content='1'>";
            }else{
                $idProducto = $_POST["idProducto"];
                $Horneada = $_POST["Horneada"];
                $Fecha = $_POST["Fecha"];
                $cantidad = $_POST["cantidad"];
                $unidad = $_POST["unidad"];
                $Precio = $_POST["precio"];
                $Precio_u = $_POST["precio_u"];
    
                // Insert
                $query = 'INSERT INTO productos_h(idproducto,fecha,horneada,cantidad,unidad,precio,precio_u) 
                VALUES ('.$idProducto.',"'.$Fecha.'",'.$Horneada.','.$cantidad.',"'.$unidad.'",'.$Precio.','.$Precio_u.')';
            
                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
            }
        }
    ?>

    <br><br><br><br><br>
    <a href="precios_historicos.php"> referesh </a>
    <br>
    <a href="index.php"> inicio </a>

</body>
</html>