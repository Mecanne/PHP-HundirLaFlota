<!--
    Vista para la colocacion de barcos.
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Colocar</title>
    <link rel="stylesheet" href="css/app.css">
    <style>
        table{
            border-collapse: collapse;
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
    <h1 style="text-align:center;padding:0;margin:0;">Coloca tus barcos</h1>
    <?php
    if (ModeloTableros::longitudSiguienteBarco($tablero['IDTablero']) != 0) {
        ?>
        <div>
            <h3>Direccion: <?php echo $direccion ?></h3>
            <form action="" method="POST">
                <input type="hidden" name="jugar-partida">
                <input type="hidden" name="idpartida" value="<?php echo "$partida[IDPartida]" ?>">
                <input type="hidden" name="idtablero" value="<?php echo "$tablero[IDTablero]" ?>">
                <input type="hidden" name="direccion" value="<?php echo $direccion ?>">
                <input type="submit" name="cambiar-direccion" value="Cambiar direccion" class="btn">
            </form>
        </div>
        <h2>Proximo barco: <?php echo $nombreProximoBarco?> - Longitud: <?php echo $longitudProximoBarco ?> casillas</h2>
        <?php
    }
    ?>
    <br>
    <div class="table-container">
        <div>
            <h2 style="text-align:center;">Tablero de <?php echo $usuario['Usuario'] ?></h2>
            <form action="" method="POST" style="display:flex;justify-content: space-around;">
            <input type="hidden" name="jugar-partida">
            <input type="hidden" name="idpartida" value="<?php echo "$partida[IDPartida]" ?>">
            <input type="hidden" name="idtablero" value="<?php echo "$tablero[IDTablero]" ?>">
            <input type="hidden" name="direccion" value="<?php echo $direccion ?>">
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
                        }else{
                            echo '<td>';
                            switch ($arrayTableroJugador[$f-1][$c-1]) {
                                case 0:
                                    echo '<input type="submit" name="posicion" value="' . ($f-1) . 'ABCDEFGHIJ' {
                                        ($c-1)} .
                                        '">';
                                    break;
                                case 1:
                                    echo '<div style="background-color:lightgrey;width:100%;height:100%">';
                                    break;
    
                                case 2:
                                    echo '<div style="background-color:#8F4D10;width:100%;height:100%">';
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
            </form>
        </div>
        <div>
            <h2 style="text-align:center;">Tablero del contrincate</h2>
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
                        }else{
                            echo '<td>';
                            echo '<div style="background-color:blue;width:100%;height:100%">';
                            echo '</td>';
                        }
                        
                        
                    }
                    echo '</tr>';
            }
            ?>
        </table>
        </div>
    </div>
</body>
</html>