<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CATALOGO DE PRODUCTOS</title>
    </head>
    <body>
        <?php include 'conexion.php'; ?> 

        <?php
            // Conectando, seleccionando la base de datos
            $link = mysqli_connect($hostname_conexion, $username_conexion, $password_conexion) or die('No se pudo conectar: ' . mysql_error());
            mysqli_select_db($link,$database_conexion) or die('No se pudo seleccionar la base de datos');

            // Realizar una consulta MySQL
            echo '<p>CATALOGO DE PRODUCTOS</p>';
            echo '<p>Id | Grupo | Nombre</p>';
            
            $query = 'SELECT idProducto,Grupo,Nombre FROM cat_productos';
            $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());

            // Imprimir los resultados en HTML
            echo "<table>\n";
            while ($row = mysqli_fetch_array($result)) {
                echo $row[0] . "&nbsp&nbsp&nbsp" .  $row[1] . "&nbsp&nbsp&nbsp" . $row[2] . "<br />";
            }

            // Liberar resultados
            mysqli_free_result($result);

            // Cerrar la conexión
            mysqli_close($link);
        ?>

        <br><br><br><br><br>
        <a href="index.php"> inicio </a>



    </body>
</html>