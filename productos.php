<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
</head>
<body>
    <?php include 'conexion.php';?>

    <h2>Insertar producto</h2>
        <?php
            $result = mysqli_query($link,"SELECT max(id)+1 FROM productos") or die('Consulta fallida: ' . mysql_error());
            $var = mysqli_fetch_row($result);
            $id = $var[0];
            if(!$id){
                $id = 1;
            }

            $result1 = mysqli_query($link,"SELECT DISTINCT grupo FROM productos") or die('Consulta fallida: ' . mysql_error());
        ?>

        <table>
            <th>Grupo</th><th>Nombre</th>
            <form method="POST">
            <tr>
                <td>
                    <select name="grupo"> 
                        <?php
                            while ($fila = $result1->fetch_assoc()):
                                $grupo = $fila['grupo'];
                                echo "<option value=$grupo>$grupo</option>";
                            endwhile;
                        ?>
                    </select>
                </td>
                <td><input type="text" name="nombre"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Insertar"></td>
            </tr>
            </form>
        </table>


    <?php 
        if(isset($_POST["submit"]) && !empty($_POST["submit"])) {
            if(empty($_POST["nombre"])){
                echo "<p>FALTAN DATOS</p>";
                echo "<meta http-equiv='refresh' content='1'>";
            }else{
                $grupo = $_POST["grupo"];            
                $nombre = $_POST["nombre"];

                // Insert
                $query = 'INSERT INTO productos(id,grupo,nombre) 
                VALUES ('.$id.',"'.$grupo.'","'.$nombre.'")';

                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
            }
        }
    ?>

    <br><br><br><br><br>
    <a href="productos.php"> referesh </a>
    <br>
    <a href="index.php"> inicio </a>

</body>
</html>