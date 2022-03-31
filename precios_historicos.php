<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Precios Historicos</title>
</head>
<body>
    <?php 
        include 'conexion.php';
    ?>


<a href="index.php">Inicio</a>



    <h2>Precios Historicos</h2>    
    
    <p>Buscar datos: </p>

    <table>
        <tr>
            <td>Por producto: </td>
            <td>    
                <?php
                    $result = mysqli_query($link,"SELECT id, grupo, nombre, unidad FROM productos ORDER BY id") or die('Consulta fallida: ' . mysql_error());
                ?>

                <table>
                    <form method="POST">
                    <tr>
                        <td>
                            <select name="idProducto"> 
                                <?php
                                    while ($fila = $result->fetch_assoc()):
                                        $id = $fila['id'];
                                        $grupo = $fila['grupo'];
                                        $nombre = $fila['nombre'];
                                        $unidad = $fila['unidad'];
                                        echo "<option value=$id>$nombre ($grupo) </option>";
                                    endwhile;
                                ?>
                            </select>
                        </td>
                        <td>
                            <td><input type="submit" name="submit" value="Buscar"></td>
                        </td>
                    </tr>
                    </form>
                </table>
            </td>
        </tr>
        <tr>
            <td>Por horneada:</td>
            <td>
                <?php
                    $result = mysqli_query($link,"SELECT DISTINCT horneada,fecha FROM `productos_h` ORDER BY 1 DESC") or die('Consulta fallida: ' . mysql_error());
                ?>

                <table>
                    <form method="POST">
                    <tr>
                        <td>
                            <select name="horneada"> 
                                <?php
                                    while ($fila = $result->fetch_assoc()):
                                        $horneada = $fila['horneada'];
                                        $fecha = $fila['fecha'];
                                        echo "<option value=$horneada>$horneada ($fecha) </option>";
                                    endwhile;
                                ?>
                            </select>
                        </td>
                        <td>
                            <td><input type="submit" name="submit2" value="Buscar"></td>
                        </td>
                    </tr>
                    </form>
                </table>
            </td>
        </tr>
    </table>


    <?php 
        if(isset($_POST["submit"]) && !empty($_POST["submit"])) {
            $idProducto = $_POST["idProducto"];
        
        $query = "SELECT nombre FROM productos WHERE id = $idProducto;";
        $result2 = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
        $var = mysqli_fetch_row($result2);
        $nombre = $var[0];
        
        echo "<br>" . $nombre;
    ?>
            <br>
            <table>
            <th>Fecha</th><th>Horneada</th><th>Cantidad</th><th>Precio</th><th>Precio unitario</th>
    
    <?php


            $query = 'SELECT fecha,horneada,cantidad,precio,precio_u FROM productos_h WHERE idproducto = '.$idProducto.' ORDER BY fecha;';
            $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
            while($row = mysqli_fetch_array($result)){
    ?>

        <tr>
            <td><?php echo $row['fecha'] ?></td>
            <td><?php echo $row['horneada'] ?></td>
            <td><?php echo $row['cantidad'] ?></td>
            <td><?php echo $row['precio'] ?></td>
            <td><?php echo $row['precio_u'] ?></td>
        </tr>
        <?php
                }   
            }
        ?>
    </table>

    <?php 
        if(isset($_POST["submit2"]) && !empty($_POST["submit2"])) {
            $horneada = $_POST["horneada"];
    
        echo "<br>" . $horneada;
    ?>
            <br>
            <table>
            <th>Producto</th><th>Grupo</th><th>Cantidad</th><th>Precio</th><th>Precio unitario</th>
    
    <?php
        $query = "SELECT p.nombre,p.grupo,ph.cantidad,ph.precio,ph.precio_u FROM productos_h ph JOIN productos p ON	p.id = ph.idproducto WHERE horneada = $horneada; ";
        $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
        while($row = mysqli_fetch_array($result)){
    ?>

        <tr>
            <td><?php echo $row['nombre'] ?></td>
            <td><?php echo $row['grupo'] ?></td>
            <td><?php echo $row['cantidad'] ?></td>
            <td><?php echo $row['precio'] ?></td>
            <td><?php echo $row['precio_u'] ?></td>
        </tr>
        <?php
                }   
            }
        ?>
    </table>    

</body>
</html>