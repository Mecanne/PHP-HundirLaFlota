<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Partidas</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<div class="container">
    <div class="content-box">
        <?php
            if (isset($_POST['crear'])) {
                if ($partidaCreada) {
                    echo '<p>Se ha creado la partida</p>';
                } else {
                    echo '<p>No se ha creado la partida, maximo de 3 partidas nuevas.</p>';
                }
            }
            if (isset($_POST['borrar-partida'])) {
                echo '<p>Partida borrada con exito</p>';
            }
        ?>
        <!-- PARTIDAS A LAS QUE PUEDES UNIRTE -->
        <div class="info-container">
            <h2>Partidas del jugador <strong><?php echo $usuario['Usuario'] ?></strong></h2>
            <form action="" method="post" style="justify-content:flex-end;">
                <input type="submit" class="btn" style="align-self:flex-end;" value="Volver">
            </form>
        </div>
        <?php
            if(sizeOf($partidasDisponibles) > 0){
                ?>
                <div class="table-box">
                    <table class="table table-striped table-responsive">
                        <thead>
                            <tr style="background-color:#333333;color:white;">
                                <th>ID Partida</th>
                                <th>Host</th>
                                <th>Contrincate</th>
                                <th>Estado de la partida</th>
                                <th>Opcion</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                        for ($i = 0; $i < sizeof($partidasDisponibles); $i++) {
                            $partida = $partidasDisponibles[$i];
                            echo '<tr>';
                            for ($j = 0; $j < sizeof($partida); $j++) {
                                echo '<td> ' . $partida[$j] . '</td>';
                            }
                            echo '<td>';
                            echo '<form action="" method="POST" style="display:flex;justify-content:space-around;">';
                            echo '<input type="hidden" name="idpartida" value="' . $partida[0] . '">';
                            if ($partida[sizeof($partida) - 1] == 'Creada' && $partida[sizeof($partida) - 2] != '') {
                                echo '<input type="submit" name="jugar-partida" class="btn" value="Jugar">';
                            }
                            if ($partida[sizeof($partida) - 1] == 'Creada' && $partida[sizeof($partida) - 2] == '') {
                                echo '<input type="submit" name="borrar-partida" class="btn" value="Borrar">';
                            }
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        }

                        ?>
                        </tbody>   
                    </table>
                </div>
                <?php
            }else{
                echo '<p>No hay ninguna partida disponible</p>';
            }
        ?>
        <hr>
        <!-- PARTIDAS QUE ESTAN A LA ESPERA -->
        <div class="info-container">
            <h2>Partidas a la espera del contrincante</h2>
        </div>
        <?php
            if(sizeOf($partidasEnEspera) > 0){
                ?>
                <div class="table-box">
                    <table class="table table-striped table-responsive">
                        <thead>
                            <tr style="background-color:#333333;color:white;">
                                <th>ID Partida</th>
                                <th>Host</th>
                                <th>Contrincate</th>
                                <th>Estado de la partida</th>
                                <th>Opcion</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                        for ($i = 0; $i < sizeof($partidasEnEspera); $i++) {
                            $partida = $partidasEnEspera[$i];
                            echo '<tr>';
                            for ($j = 0; $j < sizeof($partida); $j++) {
                                echo '<td> ' . $partida[$j] . '</td>';
                            }
                            echo '<td>';
                            echo '<form action="" method="POST" style="display:flex;justify-content:space-around;">';
                            echo '<input type="hidden" name="idpartida" value="' . $partida[0] . '">';
                            echo '<input type="submit" name="ver-partida" class="btn" value="Ver">';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        }

                        ?>
                        </tbody>   
                    </table>
                </div>
                <?php
            }else{
                echo '<p>No hay partidas a la espera</p>';
            }
        ?>
        <hr>
        <!-- PARTIDAS ACABADAS -->
        <div class="info-container">
            <h2>Partidas acabadas</h2>
        </div>
        <?php
            if(sizeOf($partidasAcabadas) > 0){
                ?>
                <div class="table-box">
                    <table class="table table-striped table-responsive">
                        <thead>
                            <tr style="background-color:#333333;color:white;">
                                <th>ID Partida</th>
                                <th>Host</th>
                                <th>Contrincate</th>
                                <th>Estado de la partida</th>
                                <th>Opcion</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                        for ($i = 0; $i < sizeof($partidasAcabadas); $i++) {
                            $partida = $partidasAcabadas[$i];
                            echo '<tr>';
                            for ($j = 0; $j < sizeof($partida); $j++) {
                                echo '<td> ' . $partida[$j] . '</td>';
                            }
                            echo '<td>';
                            echo '<form action="" method="POST" style="display:flex;justify-content:space-around;">';
                            echo '<input type="hidden" name="idpartida" value="' . $partida[0] . '">';
                            echo '<input type="submit" name="ver-partida" class="btn" value="Ver">';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        }

                        ?>
                        </tbody>   
                    </table>
                </div>
                <?php
            }else{
                echo '<p>No hay partidas acabadas</p>';
            }
        ?>
    </div>
</div>
    
</body>
</html>