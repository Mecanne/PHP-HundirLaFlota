<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
    <div class="container">
        <div class="info-container">
            <h2>Partidas a las que puedes unirte</h2>
            <form action="" method="post" style="justify-content:flex-end;">
                <input type="submit" class="btn" style="align-self:flex-end;" value="Volver">
            </form>
        </div>
            <table>
            <?php
            if (sizeOf($partidasDisponibles) > 0) {
                ?>
                <div class="table-box">
                    <table class="table table-striped table-responsive">
                        <thead>
                            <tr style="background-color:#333333;color:white;">
                                <th>Host</th>
                                <th>Opcion</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                        for ($i = 0; $i < sizeof($partidasDisponibles); $i++) {
                            $partida = $partidasDisponibles[$i];
                            echo '<tr>';
                            for ($j = 1; $j < sizeof($partida); $j++) {
                                echo '<td> ' . $partida[$j] . '</td>';
                            }
                            echo '<td>';
                            echo '<form action="" method="POST" style="display:flex;justify-content:space-around;">';
                            echo '<input type="hidden" name="IDPartida" value="' . $partida[0] . '">';
                            echo '<input type="submit" name="unirse" value="unirse" class="btn">';
                            echo '</form>';
                            echo '</td>';
                            echo '</tr>';
                        }

                        ?>
                        </tbody>   
                    </table>
                </div>
                <?php

            } else {
                echo '<p>No hay ninguna partida disponible</p>';
            }
            ?>
            </table>
    </div>
</body>
</html>