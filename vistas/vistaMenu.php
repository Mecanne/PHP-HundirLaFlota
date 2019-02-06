<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menu</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<div class="container">
    <div class="container col-md-6">
        <div class="container-fluid img-container">
            <!--<img src="img/logo.png" alt="BattleShip" class="mx-auto d-block img-fluid">-->
            <h4 class="text-center">Bienvenido <span class="text-primary"><?php echo $_SESSION['usuario'] ?></span></h4>
        </div>
        <form action="" method="POST" class="form">
            <div class="list-group">
                <h4 class="list-group-item list-group-item-action text-light active">Menu</h4>
                <input type="submit" class="btn" name="crear" value="Crear partida">
                <input type="submit" class="btn" name="unirse" value="Unirse a una nueva partida">
                <input type="submit" class="btn" name="lista" value="Ver partidas">
                <input type="submit" class="btn" name="salir" value="Salir">
            </div>
        </form>
    </div>
</div>
</body>
</html>