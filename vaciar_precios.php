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

    <h2>Gastos de última horneada</h2>

    <h2> Vaciar precios a historico </h2>
    <form method="POST">
        <input type="submit" name="submit2" value="Vaciar Precios">
    </form> 

    <?php
        if(isset($_POST["submit2"]) && !empty($_POST["submit2"])) {
            $query = 'SELECT uh.id, uh.idproducto,r.fecha, uh.horneada, uh.cantidad, uh.importe precio, uh.importe/cantidad precio_unitario FROM ultima_horneada uh JOIN reporte r ON uh.horneada = r.horneada;';
            $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
            $result_vacio = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
            $var2 = mysqli_fetch_row($result_vacio);

            if(!$var2){
                echo "<p>Ya no hay más registros de la última horneada<p>";
                echo "<meta http-equiv='refresh' content='2'>";
            }

            while($var = mysqli_fetch_row($result)){
                // Insert
                $query = 'INSERT INTO productos_h(idproducto,fecha,horneada,cantidad,precio,precio_u) 
                VALUES ('.$var[1].',"'.$var[2].'",'.$var[3].','.$var[4].','.$var[5].','.$var[6].');';
                $result2 = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());

                $drop_query='DELETE FROM ultima_horneada WHERE id='.$var[0].';';
                $result2 = mysqli_query($link,$drop_query) or die('Consulta fallida: ' . mysql_error());

            }

        echo "<meta http-equiv='refresh' content='0'>";

        }

    ?> 
</body>
</html>