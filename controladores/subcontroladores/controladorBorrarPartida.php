<?php
$idPartida = $_POST['idpartida'];
ModeloPartidas::borrarPartida($idPartida);
include('controladores/subcontroladores/controladorPartidas.php');