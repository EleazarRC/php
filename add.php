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

<h2>ADD</h2>
<?php

include_once "base_de_datos.php";
// Iniciamos sesión con el cliente.
session_start();

$sentencia = $base_de_datos->query("SELECT count(*) AS n_contactos FROM contactes");
$conteo = $sentencia->fetchObject()->n_contactos;
$conteo = $conteo + 1;

echo"<form action=\"./serviceRestFul.php\" method=\"POST\">"
. '<input hidden type="text" id="tipo" name="tipo" value="add">'
  . " <fieldset>"
  . "   <legend>Identificación:</legend>"
  //. "   <label for=\"id\">Id:</label><br>"
  //. "   <input type=\"text\" id=\"id\" name=\"id\" value='".$conteo."'><br>"
  . "   <label for=\"fname\">Nombre:</label><br>"
  . "   <input type=\"text\" id=\"fname\" name=\"fname\" value=''><br>"
  . "   <label for=\"lname\">Cognom:</label><br>"
  . "   <input type=\"text\" id=\"lname\" name=\"lname\" value=''><br><br>"
  . "   <!--<input type=\"submit\" value=\"Submit\">-->"
  . " </fieldset>"
  . " <fieldset>"
  . "   <legend>Datos Personales:</legend>"
  . "   <label for=\"adress\">Dirección:</label><br>"
  . "   <input type=\"text\" id=\"adress\" name=\"adress\" value=''><br>"
  . "   <label for=\"cp\">Código postal:</label><br>"
  . "   <input type=\"text\" id=\"cp\" name=\"cp\" value=''><br>"
  . "   <label for=\"localidad\">Localidad:</label><br>"
  . "   <input type=\"text\" id=\"localidad\" name=\"localidad\" value=''><br>"
  . "   <label for=\"Provincia\">Provincia:</label><br>"
  . "   <input type=\"text\" id=\"Provincia\" name=\"Provincia\" value=''><br>"
  . " </fieldset>"
  . " <fieldset>"
  . "   <legend>Datos de Contacto:</legend>"
  . "   <label for=\"tlf1\"> Teléfono 1: </label><br>"
  . "   <input type=\"text\" id=\"tlf1\" name=\"tlf1\" value=''><br>"
  . "   <label for=\"tlf2\"> Teléfono 2:</label><br>"
  . "   <input type=\"text\" id=\"tlf2\" name=\"tlf2\" value=''><br>"
  . "   <label for=\"fax\"> Fax</label><br>"
  . "   <input type=\"text\" id=\"fax\" name=\"fax\" value=''><br>"
  . "   <label for=\"email\">Email:</label><br>"
  . "   <input type=\"text\" id=\"email\" name=\"email\" value=''><br>"
  . " </fieldset>"
  . " <div class=\"menu\">"
  . " <input type=\"image\" src=\"./assets/img/apply.png\">"
  . "</form>"
  . "<a href=\"./index.php\"><img src=\"./assets/img/cancel.png\"></a>"
  . " </div>"
 ."";





 ?>

    
</body>
</html>