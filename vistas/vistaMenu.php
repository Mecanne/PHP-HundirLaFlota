<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menu</title>
    <link rel="stylesheet" href="css/app.css">
    <style>
        h3{
            text-align:center;
            margin: 5px 0px;
            padding: 10px 0px;
            font-size: 1.2em;
            background-color: #3B3B3B;
            color: white;
            border: 1px solid lightgrey;
        }
        input[type="submit"]{
            width:100%;
            height:auto;
            padding: 10px 0px;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
<div >
    <div class="container">
        <div class="container-fluid img-container">
            <img src="img/logo.png" alt="BattleShip" class="mx-auto d-block img-fluid">
            <h2 class="text-center">Bienvenido <span class="text-primary"><?php echo $_SESSION['usuario'] ?></span></h2>
        </div>
        <form action="" method="POST" class="form">
            <div>
                <h3>Menú</h3>
                <input type="submit" class="btn" name="crear" value="Crear partida">
                <input type="submit" class="btn" name="unirse" value="Ver partidas disponibles">
                <input type="submit" class="btn" name="lista" value="Ver mis partidas">
                <input type="submit" class="btn" name="salir" value="Salir">
            </div>
        </form>
    </div>
</div>
</body>
</html>