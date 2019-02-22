<!--
    Vista para mostrar la opcion de atacar al contrincante.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Disparar</title>
    <link rel="stylesheet" href="css/app.css">
    <style>
        table{
            border-collapse: collapse;
        }
        table tr:first-child,
        table tr td:first-child{
            background-color: white;
        }
        table td{
            width: 40px;
            height: 40px;
            text-align: center;
            padding: 0;
        }
        td input{
            width: 100%;
            height: 100%;
            border: none;
            background-color:dodgerblue;
            color: dodgerblue;
        }
        td input:hover{
            background-color:lightblue;
            color: lightblue;
        }
    </style>
</head>
<body>
    <div class="fixed-container">
        <form action="" method="post" style="justify-content:flex-end;">
            <input type="hidden" name="lista">
            <input type="submit" class="btn" style="align-self:flex-end;" value="Volver">
        </form>
    </div>
    <br>
    <h1 style="text-align:center;">Tu turno, ¡DISPARA!</h1>
    <?php 
    if (isset($_POST['posicionDisparo'])) {
        echo '<h2 style="text-align:center">Has disparado al a posicion ' . $fila . $columna . '</h2>';
        if($tocado){
            echo '<h3 class="shoot-message-red">' . $mensajeDisparo . '</h3>';
        }
    }
    ?>
    <div class="table-container">
        <div>
            <h2 style="text-align:center;">Tablero de <?php echo $usuario['Usuario'] ?></h2>
            <table>
            <?php
                    for ($f = 0; $f <= 10; $f++) {
                        echo '<tr>';
                        for ($c = 0; $c <= 10; $c++) {
                            if ($f == 0 && $c == 0) {
                                echo "<td></td>";
                            } else if ($f == 0) {
                                echo "<td>" . 'ABCDEFGHIJ' {
                                    ($c - 1)} . "</td>";
                            } else if ($c == 0) {
                                echo "<td>" . ($f - 1) . "</td>";
                            } else {
                                echo '<td>';
                                switch ($arrayTableroJugador[$f - 1][$c - 1]) {
                                    case 0:
                                        echo '<div style="background-color:dodgerblue;width:100%;height:100%">';
                                        break;
                                    case 1:
                                        echo '<div style="background-color:dodgerblue;width:100%;height:100%">';
                                        break;
                                    case 2:
                                        echo '<div style="background-color:#8F4D10;width:100%;height:100%">';
                                        break;
                                    case 3:
                                        echo '<div style="background-color:blue;width:100%;height:100%">';
                                        break;
                                    case 4:
                                        echo '<div style="background-color:red;width:100%;height:100%">';
                                        break;

                                    default:
                                            # code...
                                        break;
                                }
                                echo '</td>';
                            }

                        }
                        echo '</tr>';
                    }
                    ?>
            </table>
        </div>
        <div>
            <h2 style="text-align:center;">Tablero del contrincate</h2>
            <form action="" method="POST">
                <input type="hidden" name="jugar-partida">
                <input type="hidden" name="idpartida" value="<?php echo "$partida[IDPartida]" ?>">
                <input type="hidden" name="idtablero" value="<?php echo "$tablero[IDTablero]" ?>">
                <table>
                    <?php
                    for ($f = 0; $f <= 10; $f++) {
                        echo '<tr>';
                        for ($c = 0; $c <= 10; $c++) {
                            if ($f == 0 && $c == 0) {
                                echo "<td></td>";
                            } else if ($f == 0) {
                                echo "<td>" . 'ABCDEFGHIJ' {
                                    ($c - 1)} . "</td>";
                            } else if ($c == 0) {
                                echo "<td>" . ($f - 1) . "</td>";
                            } else {
                                echo '<td>';
                                switch ($arrayTableroContrincante[$f - 1][$c - 1]) {
                                    case 3:
                                        echo '<div style="background-color:blue;width:100%;height:100%">';
                                        break;
                                    case 4:
                                        echo '<div style="background-color:red;width:100%;height:100%">';
                                        break;
                                    default:
                                        echo '<input type="submit" name="posicionDisparo" value="' . ($f - 1) . 'ABCDEFGHIJ' {
                                            ($c - 1)} . '">';
                                        break;
                                }
                                echo '</td>';
                            }

                        }
                        echo '</tr>';
                    }
                    ?>
                </table>
            </form>
        </div>
    </div>
</body>
</html>