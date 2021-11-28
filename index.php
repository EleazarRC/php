<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <title>Agenda</title>
</head>
<body>
    

<h1>CONTACTOS</h1>
<?php
// INICIAMOS LA SESIÓN
session_start();
// Inicializamos las variables de sesión
if (!isset($_SESSION["pagina"])) {  
    $_SESSION["pagina"] = 1;
} 
// Control movimiento usuario
if(!empty($_GET["pag"])){
    if($_GET["pag"] == "atras"){
        $_SESSION['pagina'] =  $_SESSION['pagina'] - 1 ;
    } else if($_GET["pag"] == "adelante"){
        $_SESSION['pagina'] =  $_SESSION['pagina'] + 1;
    }   
} else if(!empty($_GET["pagina"])){   
    $_SESSION['pagina'] = $_GET["pagina"];
}

$productosPorPagina = 5;

//MODIFICAR
$paginas = 3;


// Mostramos la información
echo "<table>";
echo '<thead>';
echo '<tr>';
echo '<th>Id</th>'; // <a href="./index.php?Id=', urlencode($Id), '&pagina=',urlencode($pagina),'"> Ordenar por ID ' . $Id . "</a>
echo '<th>Cornom</th>'; // '<a href="./index.php?Cognom=', urlencode($Cognom), '&pagina=',urlencode($pagina),'"> Ordenar por Cognom ' . $Cognom. "</a>";
echo '<th>Nom</th>';
echo '<th colspan="3">Manteniment</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
echo '<p class="infoPagina"> Página '.$_SESSION["pagina"].' de x </p>';
// MOSTRAMOS LA INFORMACIÓN
echo "<div class='información'>";    
for ($i=0; $i < 5; $i++) { 

    echo '<tr>';
    echo "<td>" . "id". $i ."</td>";
    //echo " ";
    echo "<td class='left'>" .  "cognom". $i ."</td>";
    //echo " ";
    echo "<td class='left'>" .  "nom". $i ."</td>";
    //echo "<br>";
    echo "<td><a href='./view.php?view=". $i ."1'><img src='./assets/img/view.png' alt='inicio' /></td></a>";
    //echo "<br>";
    echo "<td><a href='./edit.php?edit=". $i ."'><img src='./assets/img/edit.png' alt='inicio' /></td></a>";
    //echo "<br>";
    echo "<td><a href='./remove.php?remove=". $i ."'><img src='./assets/img/remove.png' alt='inicio' /></td></a>";
    //echo "<br>";
    echo '</tr>';
    
}
echo '<tr>'
    . '<td class="menuMovimiento" colspan="3">'
    . '<a href="./index.php?pagina=1"><img src="./assets/img/home.png" alt="inicio"/></a>'
    . '<a href="./index.php?pag=atras"><img src="./assets/img/left.png" alt="atrás"/></a>'
    . '<a href="./index.php?pag=adelante"><img src="./assets/img/right.png" alt="adelante"/></a>'
    . '<a href="./index.php?pagina='.$paginas.'"><img src="./assets/img/end.png" alt="final"/></a>'
    . '</td>';


echo "<td class='menuAdd' colspan='3'><a href='./index.php?pagina=1'> <img src='./assets/img/add.png' alt='inicio' /></a></td>";
echo '</tr>';

echo '</tbody>';
echo "</table>";
echo "</div>";
// Fin mostrar información


echo '<div class="infoSesion">'
    . 'Página: ' 
    . $_SESSION["pagina"]
    . '</br>'
    . 'Página: ' 
   // . $_SESSION["id"]
    . '</br>'
    . 'Página: ' 
   // . $_SESSION["cognom"]
    . '</br>'
    .'</div> ';

?>

</body>
</html>