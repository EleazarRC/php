<?php
include_once "base_de_datos.php";
session_start();

$tipo = $_POST['tipo'];

if ($tipo == "edit") {

    $id = $_POST['id'];
    $nombre = $_POST['fname'];
    $apellido = $_POST['lname'];
    $direccion = $_POST['adress'];
    $cp = $_POST['cp'];
    $localidad = $_POST['localidad'];
    $provincias = $_POST['Provincia'];
    $telefono1 = $_POST['tlf1'];
    $telefono2 = $_POST['tlf2'];
    $fax = $_POST['fax'];
    $email = $_POST['email'];

    try {
        $sentencia = $base_de_datos->prepare("UPDATE `contactes` SET `id` = '$id',
        `nom` = '$nombre', `cognoms` = '$apellido', `direccio` = '$direccion',
        `localitat` = '$localidad', `provincia` = '$provincias', `cp` = '$cp',
        `telefon1` = '$telefono1', `telefon2` = '$telefono2', `fax` = '$fax',
        `mail` = '$email' WHERE `contactes`.`id` = ".$_SESSION["contacto"]."");

        $sentencia->execute();
    
        $_SESSION["contacto"] = $id;

        header("Location: ./edit.php?estado=ok");
    } catch (PDOException $e) {
        
        //echo $e;
        header("Location: ./edit.php?estado=error");
    }

}else if ($tipo == "delete") {

    $id = $_POST['id'];
    echo "BORRAR ->". $id;

    try {
        $sentencia = $base_de_datos->prepare("DELETE FROM `contactes` WHERE `id` = ".$_SESSION["contacto"]."");
        $sentencia->execute();
        header("Location: ./index.php");
    } catch (PDOException $e) {
        //throw $th;
        header("Location: ./index.php");
    }
    
} else if($tipo == "add"){
    
    //$id = $_POST['id'];
    $nombre = $_POST['fname'];
    $apellido = $_POST['lname'];
    $direccion = $_POST['adress'];
    $cp = $_POST['cp'];
    $localidad = $_POST['localidad'];
    $provincias = $_POST['Provincia'];
    $telefono1 = $_POST['tlf1'];
    $telefono2 = $_POST['tlf2'];
    $fax = $_POST['fax'];
    $email = $_POST['email'];

    //echo $email;

    try {
        $sentencia = $base_de_datos->prepare(            
            "INSERT INTO contactes (nom, cognoms, direccio, localitat,
                                    provincia, cp, telefon1, telefon2, fax, mail)       
            VALUES ('$nombre', '$apellido', '$direccion', '$localidad', '$provincias',
                    '$cp', '$telefono1', '$telefono2', '$fax', '$email')");
       
       $sentencia->execute();

       echo "bien";
        header("Location: ./index.php");
    } catch (PDOException $e) {
        
        //echo $e;
        //throw $th;
       header("Location: ./index.php");
    }



    

}