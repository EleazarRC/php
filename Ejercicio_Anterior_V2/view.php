<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <title>Document</title>
</head>
<body>


<?php

include_once "base_de_datos.php";

$id = $_GET["view"];

$sentencia = $base_de_datos->prepare("SELECT * FROM contactes WHERE id = " . $id);
$sentencia-> execute();
$contactes = $sentencia->fetchAll(PDO::FETCH_OBJ);

//print_r($contactes);
//var_dump($contactes);

$nombre = $contactes[0]->nom;
$apellido = $contactes[0]->cognoms;
$dirección = $contactes[0]->direccio;
$cp = $contactes[0]->cp;
$localidad = $contactes[0]->localitat;
$provincias = $contactes[0]->provincia;
$telefono1 = $contactes[0]->telefon1;
$telefono2 = $contactes[0]->telefon2;
$fax = $contactes[0]->fax;
$email = $contactes[0]->mail;


echo"<form action=\"./index.php\" method=\"post\">"
  . " <fieldset>"
  . "   <legend>Identificación:</legend>"
  . "   <label for=\"id\">Id:</label><br>"
  . "   <input type=\"text\" id=\"id\" name=\"id\" value='$id'><br>"
  . "   <label for=\"fname\">Nombre:</label><br>"
  . "   <input type=\"text\" id=\"fname\" name=\"fname\" value='$nombre'><br>"
  . "   <label for=\"lname\">Cognom:</label><br>"
  . "   <input type=\"text\" id=\"lname\" name=\"lname\" value='$apellido'><br><br>"
  . "   <!--<input type=\"submit\" value=\"Submit\">-->"
  . " </fieldset>"
  . " <fieldset>"
  . "   <legend>Datos Personales:</legend>"
  . "   <label for=\"adress\">Dirección:</label><br>"
  . "   <input type=\"text\" id=\"adress\" name=\"adress\" value='$dirección'><br>"
  . "   <label for=\"cp\">Código postal:</label><br>"
  . "   <input type=\"text\" id=\"cp\" name=\"cp\" value='$cp'><br>"
  . "   <label for=\"localidad\">Localidad:</label><br>"
  . "   <input type=\"text\" id=\"localidad\" name=\"localidad\" value='$localidad'><br>"
  . "   <label for=\"Provincia\">Provincia:</label><br>"
  . "   <input type=\"text\" id=\"Provincia\" name=\"Provincia\" value='$provincias'><br>"
  . " </fieldset>"
  . " <fieldset>"
  . "   <legend>Datos de Contacto:</legend>"
  . "   <label for=\"tlf1\"> Teléfono 1: </label><br>"
  . "   <input type=\"text\" id=\"tlf1\" name=\"tlf1\" value='$telefono1'><br>"
  . "   <label for=\"tlf2\"> Teléfono 2:</label><br>"
  . "   <input type=\"text\" id=\"tlf2\" name=\"tlf2\" value='$telefono2'><br>"
  . "   <label for=\"fax\"> Fax</label><br>"
  . "   <input type=\"text\" id=\"fax\" name=\"fax\" value='$fax'><br>"
  . "   <label for=\"email\">Provincia:</label><br>"
  . "   <input type=\"text\" id=\"email\" name=\"email\" value='$email'><br>"
  . " </fieldset>"
  . " <input type=\"submit\" value=\"Submit\">"
  . "</form>"
 ."";

 ?>

    
</body>
</html>