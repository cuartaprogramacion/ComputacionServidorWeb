
<?php

//Estos datos deben ser configurados dependien al servidor que requiera conectarse
$server   = "*****";
$username = "cuartapr_Victor";
$password = "*****";
$database = "*****";



$mysqli = new mysqli($server, $username, $password, $database);


if ($mysqli->connect_error) {
    die('error'.$mysqli->connect_error);
}
?>