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

<h2>Reporte completo</h2><br>
    
    <table>
        <th>#Horneada</th><th>Fecha</th><th>Inversión</th><th>Gasto</th><th>Ingreso</th><th>Ganancia</th>
        <?php
            $query = 'SELECT horneada,fecha,inversion,gasto,ingreso,ganancia FROM reporte ORDER BY Fecha';
            $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
            while($row = mysqli_fetch_array($result)){
        ?>
            
        <tr>
            <td><?php echo $row['horneada'] ?>  </td>
            <td><?php echo $row['fecha'] ?>     </td>
            <td><?php echo $row['inversion'] ?> </td>
            <td><?php echo $row['gasto'] ?>     </td>
            <td><?php echo $row['ingreso'] ?>   </td>
            <td><?php echo $row['ganancia'] ?>  </td>
        </tr>
        <?php
            }
        ?>
    </table>

</body>
</html>