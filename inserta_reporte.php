<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <?php 
        include 'conexion.php'; 
    ?>

    <a href="index.php">Inicio</a>

    <h2>Insertar nuevo balance</h2>
    <?php

        $result1 = mysqli_query($link,"SELECT 1+max(Horneada) FROM reporte") or die('Consulta fallida: ' . mysql_error());
        $var = mysqli_fetch_row($result1);
        $Horneada = $var[0];
        $result2 = mysqli_query($link,"SELECT sum(importe) FROM ultima_horneada WHERE idttransaccion=1") or die('Consulta fallida: ' . mysql_error());
        $var2 = mysqli_fetch_row($result2);
        $Inversion = $var2[0];
        if (!$Inversion) {
            $Inversion=0;            
        }
        $result3 = mysqli_query($link,"SELECT sum(importe) FROM ultima_horneada WHERE idttransaccion=2") or die('Consulta fallida: ' . mysql_error());            
        $var3 = mysqli_fetch_row($result3);
        $Gasto = $var3[0];
        $result4 = mysqli_query($link,"SELECT sum(importe) FROM ultima_horneada WHERE idttransaccion=3") or die('Consulta fallida: ' . mysql_error());            
        $var4 = mysqli_fetch_row($result4);
        $Ingreso = $var4[0];
        $Ganancia = $Ingreso - $Gasto - $Inversion;
        
    ?>
    <table>
        <tr>
            <td>Inserta Fecha de última horneada: </td>
        <form method="POST">
            <td><input type="date" name="Fecha"></td>
        </tr>
        <tr>
            <td>Inserta comentario: </td>
            <td><input type="text" name="Comentario"></td>
        </tr>
        <tr>
            <td><input type="submit" name="submit2" value="Generar"></td>
        </form> 
        </tr>
    </table>
    <?php 
        if(isset($_POST["submit2"])) {
            if(empty($_POST["Fecha"])){
                echo "<p>FALTA FECHA</p>";
                echo "<meta http-equiv='refresh' content='1'>";
            }else{
                $Fecha = $_POST["Fecha"];
                $Comentario = $_POST["Comentario"];
                if (empty($_POST["Comentario"])) {
                    $Comentario = " --> SIN COMENTARIOS <-- ";            
                }
                // Insert
                $query = 'INSERT INTO reporte(horneada,fecha,inversion,gasto,ingreso,ganancia,comentario) 
                VALUES ('.$Horneada.',"'.$Fecha.'",'.$Inversion.','.$Gasto.','.$Ingreso.','.$Ganancia.',"'.$Comentario.'");';
                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
                echo "<meta http-equiv='refresh' content='0'>";
                // echo $query;
            }
        }
    ?>

</body>
</html>