<!DOCTYPE html>


<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Barbacoa Don Cruz</title>
    </head>
    <body>

        <h1>Página Inicio</h1>

        <a href="balance.php"> Ver Balance </a>        
        <a href="transacciones.php"> Ver gasto actual </a>
        <a href="cat_productos.php"> Insertar nuevo producto </a>

        <?php include 'conexion.php'; ?>

        <h2>Transacciones</h2>



        <h2>Inserta transaccion</h2>

        <?php
            // Conectando, seleccionando la base de datos
            $link = mysqli_connect($hostname_conexion, $username_conexion, $password_conexion) or die('No se pudo conectar: ' . mysql_error());
            mysqli_select_db($link,$database_conexion) or die('No se pudo seleccionar la base de datos');  
            $result0 = mysqli_query($link,"SELECT max(idTransaccion)+1 FROM transacciones") or die('Consulta fallida: ' . mysql_error());
            if (!$result0) {
                echo 'No se pudo ejecutar la consulta: ' . mysql_error();
                exit;
            }
            $var = mysqli_fetch_row($result0);
            $idTransaccion = $var[0];

            $result1 = mysqli_query($link,"SELECT idProducto,Grupo,Nombre FROM cat_productos") or die('Consulta fallida: ' . mysql_error());
            $result2 = mysqli_query($link,"SELECT idTipoTransaccion,Nombre FROM cat_tipotransaccion") or die('Consulta fallida: ' . mysql_error());            
        ?>


        <p>Producto | Transaccion | Horneada | Fecha | #Unidades | Unidad | Cantidad</p>
		<form method="POST">
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
            <select name="idTipoTransaccion"> 
                        <?php
                            while ($fila = $result2->fetch_assoc()):
                                $id = $fila['idTipoTransaccion'];
                                $nombre = $fila['Nombre'];
                                echo "<option value=$id>$id - $nombre</option>";
                            endwhile;
                        ?>
            </select>
            <input type="number" name="Horneada">
            <input type="date" name="Fecha">
            <input type="number" name="cantidad">
            <input type="text" name="unidad">
            <input type="number" name="transaccion">
			<br>         
            <input type="submit" name="submit" value="Insertar">
		</form>
        
        <?php 
            if(isset($_POST["submit"]) && !empty($_POST["submit"])) {
                $idProducto = $_POST["idProducto"];
                $idTipoTransaccion = $_POST["idTipoTransaccion"];
                $Horneada = $_POST["Horneada"];
                $Fecha = $_POST["Fecha"];
                $cantidad = $_POST["cantidad"];
                $unidad = $_POST["unidad"];
                $transaccion = $_POST["transaccion"];
            }
            mysqli_close($link);
        ?>
 
        <?php
        // Conectando, seleccionando la base de datos
        $link = mysqli_connect($hostname_conexion, $username_conexion, $password_conexion) or die('No se pudo conectar: ' . mysql_error());
        mysqli_select_db($link,$database_conexion) or die('No se pudo seleccionar la base de datos');

        // Insert
        $query = 'INSERT INTO transacciones(idTransaccion,idProducto,idTipoTransaccion,Horneada,Fecha,cantidad,unidad,transaccion) 
            VALUES ('.$idTransaccion.','.$idProducto.','.$idTipoTransaccion.','.$Horneada.',"'.$Fecha.'",'.$cantidad.',"'.$unidad.'",'.$transaccion.')';
        
        $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());

        // Cerrar la conexión
        mysqli_close($link);
        ?>   

    </body>
</html>