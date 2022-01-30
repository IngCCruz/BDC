<?php
    $hostname_conexion = "127.0.0.1";
    $database_conexion = "bdc";
    $username_conexion = "cesar";
    $password_conexion = "202201-cesar";

    // Conectando, seleccionando la base de datos
    $link = mysqli_connect($hostname_conexion, $username_conexion, $password_conexion) or die('No se pudo conectar: ' . mysql_error());
    mysqli_select_db($link,$database_conexion) or die('No se pudo seleccionar la base de datos');   
 ?>











