<?php
$hostname = "localhost";
$bancodedados = "fast_food";
$usuario = "root";
$senha = "";

$mysqli = new mysqli($hostname,$usuario, $senha, $bancodedados);
if($mysqli->connect_errno) {
    echo "Falha ao conectar:(" . $mysqli->connect_errn . ")" . $mysqli->connect_error;
}