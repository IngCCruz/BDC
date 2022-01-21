<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reporte</title>
    </head>
    <body>
        <?php include 'conexion.php'; 
            // Conectando, seleccionando la base de datos
            $link = mysqli_connect($hostname_conexion, $username_conexion, $password_conexion) or die('No se pudo conectar: ' . mysql_error());
            mysqli_select_db($link,$database_conexion) or die('No se pudo seleccionar la base de datos');            
        ?> 

        <h2>Reporte general</h2>
        <br>

        <table>
            <th>#Horneada</th><th>Fecha</th><th>Inversión</th><th>Gasto</th><th>Ingreso</th><th>Ganancia</th>

            <?php
                $query = 'SELECT Horneada,Fecha,Inversion,Gasto,Ingreso,Ganancia FROM balance ORDER BY Fecha';
                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
                while($row = mysqli_fetch_array($result)){
            ?>
                
            <tr>
                <td><?php echo $row['Horneada'] ?>  </td>
                <td><?php echo $row['Fecha'] ?>     </td>
                <td><?php echo $row['Inversion'] ?> </td>
                <td><?php echo $row['Gasto'] ?>     </td>
                <td><?php echo $row['Ingreso'] ?>   </td>
                <td><?php echo $row['Ganancia'] ?>  </td>
            </tr>
            <?php
                }
            ?>
        </table>

        <h2>Reporte por mes</h2>
        <br>

        <table>
            <th>MES</th><th>Inversión</th><th>Gasto</th><th>Ingreso</th><th>Ganancia</th>
            <?php                
                $query= 'SELECT DATE_FORMAT(FECHA,"%Y-%m") AS MES,
                                SUM(Inversion) AS Inversion,
                                SUM(Gasto) AS Gasto,
                                SUM(Ingreso) AS Ingreso,
                                SUM(Ganancia) AS Ganancia 
                        FROM balance 
                        GROUP BY MES ORDER BY MES;';
                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());


                while($row = mysqli_fetch_array($result)){
            ?>
                
            <tr>
                <td><?php echo $row['MES'] ?>     </td>
                <td><?php echo $row['Inversion'] ?> </td>
                <td><?php echo $row['Gasto'] ?>     </td>
                <td><?php echo $row['Ingreso'] ?>   </td>
                <td><?php echo $row['Ganancia'] ?>  </td>
            </tr>
            <?php
                }
            ?>
        </table>

        <h2>Reporte por año</h2>
        <br>

        <table>
            <th>Año</th>
            <th>Inversión</th>
            <th>Gasto</th>
            <th>Ingreso</th>
            <th>Ganancia</th>

            <?php                
                $query= 'SELECT DATE_FORMAT(FECHA,"%Y") AS ANIO,
                                SUM(Inversion) AS Inversion,
                                SUM(Gasto) AS Gasto,
                                SUM(Ingreso) AS Ingreso,
                                SUM(Ganancia) AS Ganancia 
                        FROM balance 
                        GROUP BY ANIO ORDER BY ANIO;';
                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());


                while($row = mysqli_fetch_array($result)){
            ?>
                
            <tr>
                <td><?php echo $row['ANIO'] ?>     </td>
                <td><?php echo $row['Inversion'] ?> </td>
                <td><?php echo $row['Gasto'] ?>     </td>
                <td><?php echo $row['Ingreso'] ?>   </td>
                <td><?php echo $row['Ganancia'] ?>  </td>
            </tr>
            <?php
                }
            ?>
        </table>

        <h2>Reporte Totales</h2>
        <br>

        <table>
            <th>Inversión</th>
            <th>Gasto</th>
            <th>Ingreso</th>
            <th>Ganancia</th>

            <?php                
                $query= 'SELECT SUM(Inversion) AS Inversion,
                                SUM(Gasto) AS Gasto,
                                SUM(Ingreso) AS Ingreso,
                                SUM(Ganancia) AS Ganancia 
                        FROM balance;';
                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());


                while($row = mysqli_fetch_array($result)){
            ?>
                
            <tr>
                <td><?php echo $row['Inversion'] ?> </td>
                <td><?php echo $row['Gasto'] ?>     </td>
                <td><?php echo $row['Ingreso'] ?>   </td>
                <td><?php echo $row['Ganancia'] ?>  </td>
            </tr>
            <?php
                }
            ?>
        </table>


        <h2>Insertar automaticamente</h2>
        <?php
            $result1 = mysqli_query($link,"SELECT 1+max(Horneada) FROM balance") or die('Consulta fallida: ' . mysql_error());
            $var = mysqli_fetch_row($result1);
            $Horneada = $var[0];

            $result2 = mysqli_query($link,"SELECT sum(transaccion) FROM transacciones WHERE idTipoTransaccion=1") or die('Consulta fallida: ' . mysql_error());
            $var2 = mysqli_fetch_row($result2);
            $Inversion = $var2[0];

            $result3 = mysqli_query($link,"SELECT sum(transaccion) FROM transacciones WHERE idTipoTransaccion=2") or die('Consulta fallida: ' . mysql_error());            
            $var3 = mysqli_fetch_row($result3);
            $Gasto = $var3[0];

            $result4 = mysqli_query($link,"SELECT sum(transaccion) FROM transacciones WHERE idTipoTransaccion=3") or die('Consulta fallida: ' . mysql_error());            
            $var4 = mysqli_fetch_row($result4);
            $Ingreso = $var4[0];

            $result5 = mysqli_query($link,"SELECT (SELECT sum(transaccion) FROM transacciones WHERE idTipoTransaccion=3)
                                            - (SELECT sum(transaccion) FROM transacciones WHERE idTipoTransaccion=2)
                                            - (SELECT sum(transaccion) FROM transacciones WHERE idTipoTransaccion=1)
                                            as total") or die('Consulta fallida: ' . mysql_error());            
            $var5 = mysqli_fetch_row($result5);
            $Ganancia = $var5[0];
            
        ?>

        <table>
            <tr>
                <td>Inserta Fecha de última horneada: </td>
            <form method="POST">
                <td>
                    <input type="date" name="Fecha">
                </td>
            </tr>
            <tr>
                <td>Inserta comentario: </td>
                <td>
                    <input type="text" name="Comentario">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="submit2" value="Generar">
                </td>
            </form> 
            </tr>
        </table>

        <?php 
            if(isset($_POST["submit2"])) {
                $Fecha = $_POST["Fecha"];
                $Comentario = $_POST["Comentario"];

                // Insert
                $query = 'INSERT INTO balance(Horneada,Fecha,Inversion,Gasto,Ingreso,Ganancia,Comentario) 
                VALUES ('.$Horneada.',"'.$Fecha.'",'.$Inversion.','.$Gasto.','.$Ingreso.','.$Ganancia.',"'.$Comentario.'");';

                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
            }
        ?> 


        <h2>Insertar manualmente</h2>

        <table>
            <th>Horneada</th><th>Fecha</th><th>Inversión</th><th>Gasto</th><th>Ingreso</th><th>Ganancia</th><th>Comentario</th>
            <form method="POST">
            <tr>
                <td><input type="number" name="Horneada"></td>
                <td><input type="date" name="Fecha"></td>
                <td><input type="decimal" name="Inversion"></td>
                <td><input type="decimal" name="Gasto"></td>
                <td><input type="decimal" name="Ingreso"></td>
                <td><input type="decimal" name="Ganancia"></td>
                <td><input type="text" name="Comentario"></td>
            </tr>
            <tr>
                <td><input type="submit" name="submit" value="Insertar"></td>
            </tr>
            </form> 
        </table>

        <?php 
            if(isset($_POST["submit"])) {
                $Horneada = $_POST["Horneada"];
                $Fecha = $_POST["Fecha"];
                $Inversion = $_POST["Inversion"];
                $Gasto = $_POST["Gasto"];
                $Ingreso = $_POST["Ingreso"];
                $Ganancia = $_POST["Ganancia"];
                $Comentario = $_POST["Comentario"];

                // Insert
                $query = 'INSERT INTO balance(Horneada,Fecha,Inversion,Gasto,Ingreso,Ganancia,Comentario) 
                VALUES ('.$Horneada.',"'.$Fecha.'",'.$Inversion.','.$Gasto.','.$Ingreso.','.$Ganancia.',"'.$Comentario.'");';

                $result = mysqli_query($link,$query) or die('Consulta fallida: ' . mysql_error());
            }
        ?>   








        <br><br><br><br><br>
        <a href="reporte.php"> refresh </a>        
        <br>
        <a href="index.php"> inicio </a>
        <br><br><br><br><br>


    </body>
</html>