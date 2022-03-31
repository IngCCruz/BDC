<!DOCTYPE html>
<html lang="en">
<?php
$valid_passwords = array ("bdc" => "Mexico2022");
$valid_users = array_keys($valid_passwords);

$user = $_SERVER['PHP_AUTH_USER'];
$pass = $_SERVER['PHP_AUTH_PW'];

$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

if (!$validated) {
  header('WWW-Authenticate: Basic realm="Auth"');
  header('HTTP/1.0 401 Unauthorized');
  die ("Not authorized");
}
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<h1>Inicio</h1>
    <table>
        <tr>
            <td>1. <a href="inserta_transaccion.php">Insertar transaccion</a></td>
        </tr>
        <tr>
            <td>2. <a href="inserta_reporte.php">Insertar reporte</a></td>
        </tr>
        <tr>
            <td>3. <a href="vaciar_precios.php">Vaciar precios</a></td>
        </tr>
        <tr>
            <td>4. <a href="reporte.php">Reporte</a></td>
        </tr>
        <tr>
            <td>5. <a href="precios_historicos.php">Precios historicos</a></td>
        </tr>
    </table>

</body>
</html>