<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acceso</title>
    <link rel="stylesheet" href="css/app.css">

</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST['registro'])) {
            if ($registrado) {
                ?>
                    <div class="alert alert-success text-center">
                        <p>El usuario se ha registrado con exito.</p>
                    </div>
                    <?php

                } else {
                    ?>
                    <div class="alert alert-danger text-center col-sm-10 mx-auto d-block">
                        <p>El usuario no se ha podido registrar.</p>
                    </div>
                    <?php

                }
            }
            if (isset($_POST['acceso'])) {
                ?>
                    <div class="alert alert-danger text-center">
                        <p>El usuario o contraseña es incorrecto.</p>
                    </div>
                    <?php

                }
                ?>
        
        <div class="container-fluid img-container">
            <!--<img src="img/logo.png" alt="BattleShip" class="mx-auto d-block img-fluid">-->
        </div>
        <div class="container">
            <form method="post" action="" class="form mx-auto d-block jumbotron">
                <div class="from-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control" name="usuario" id="usuario">
                </div>
                <div class="form-group">
                    <label for="contraseña">Contraseña</label>
                    <input type="password" class="form-control" name="contraseña" id="contraseña">
                </div>
                <div class="form-group">
                    <input type="submit" value="Acceder" class="btn btn-primary btn-md col-sm-4 mx-auto d-block" name="acceso">
                    <input type="submit" value="Registrar" class="btn btn-primary btn-md col-sm-4 mx-auto d-block" name="registro">
                </div>
            </form>
        </div>
    </div>
</body>
</html>