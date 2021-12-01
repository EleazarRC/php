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

<h2>EDIT</h2>
<?php

include_once "base_de_datos.php";
// Iniciamos sesión con el cliente.
session_start();


if(isset($_POST['contacto'])){
  $_SESSION["contacto"] = $_POST['contacto'];
}
if(isset($_GET["estado"]) && $_GET["estado"] == "ok"){

  echo "Contacto editado correctamente";
}
if(isset($_GET["estado"]) && $_GET["estado"] == "error"){

  echo "No se ha podido editar el contacto";
}


//echo $_SESSION["contacto"];

$sentencia = $base_de_datos->prepare("SELECT * FROM contactes WHERE id = " . $_SESSION["contacto"]);
$sentencia-> execute();
$contactes = $sentencia->fetchAll(PDO::FETCH_OBJ);

//print_r($contactes);
//var_dump($contactes);

$nombre = $contactes[0]->nom;
$apellido = $contactes[0]->cognoms;
$direccion = $contactes[0]->direccio;
$cp = $contactes[0]->cp;
$localidad = $contactes[0]->localitat;
$provincias = $contactes[0]->provincia;
$telefono1 = $contactes[0]->telefon1;
$telefono2 = $contactes[0]->telefon2;
$fax = $contactes[0]->fax;
$email = $contactes[0]->mail;


echo"<form action=\"./serviceRestFul.php\" method=\"POST\">"
. '<input hidden type="text" id="tipo" name="tipo" value="edit">'
  . " <fieldset>"
  . "   <legend>Identificación:</legend>"
  . "   <label for=\"id\">Id:</label><br>"
  . "   <input type=\"text\" id=\"id\" name=\"id\" value='".$_SESSION["contacto"]."'><br>"
  . "   <label for=\"fname\">Nombre:</label><br>"
  . "   <input type=\"text\" id=\"fname\" name=\"fname\" value='$nombre'><br>"
  . "   <label for=\"lname\">Cognom:</label><br>"
  . "   <input type=\"text\" id=\"lname\" name=\"lname\" value='$apellido'><br><br>"
  . "   <!--<input type=\"submit\" value=\"Submit\">-->"
  . " </fieldset>"
  . " <fieldset>"
  . "   <legend>Datos Personales:</legend>"
  . "   <label for=\"adress\">Dirección:</label><br>"
  . "   <input type=\"text\" id=\"adress\" name=\"adress\" value='$direccion'><br>"
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
  . "   <label for=\"email\">email:</label><br>"
  . "   <input type=\"text\" id=\"email\" name=\"email\" value='$email'><br>"
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