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
/*******************************
 *     Eleazar Ramos Cortés
 *
 * Tabla De Contactos PHP -> SQL
 *
 *   Voy a utilizar variables de sesión y el metodo POST
 *   durante todo el proceso. Tras varias pruebas, e
 *   información que he buscado en internet creo que es la mejor
 *   solución. Al usar el método GET y volver de otra página
 *   (CON LA FLECHA DEL NAVEGADOR <-) tenía problemas con las
 *   variables de la URL, ya que me volvían a cargar la página
 *   con dichas variables que no necesitaba. Además, ensucian la URL
 *   y mostramos información innecesaria al usuario.
 *   Por otra parte, voy a usar solo variables de sesión y la cookie
 *   necesaria para tal proposito. Ya que al tener la información en
 *   la parte del servidor tendremos menos problemas de seguridad.
 *
 *********************************/
// Incluimos la conexión a la base de datos.
include_once "base_de_datos.php";

// Iniciamos sesión con el cliente.
session_start();

// Obtenemos constantes.
const PRODUCTOS_POR_PAGINA = 5;
const LIMIT = PRODUCTOS_POR_PAGINA; // -> Para facilitar la lectura de la query

// Calculamos el máximo de páginas
$sentencia = $base_de_datos->query("SELECT count(*) AS n_contactos FROM contactes");
$conteo = $sentencia->fetchObject()->n_contactos;
$paginas = ceil($conteo / PRODUCTOS_POR_PAGINA);

//echo $paginas;

// Iniciamos variables por defecto o primera visita.

// Variable para saber que página mostrar.
if (!isset($_SESSION["pagina"])) {
    $_SESSION["pagina"] = 1;
}
// Si enviamos directamente que página mostrar
if (isset($_POST['pagina'])) {
    $_SESSION["pagina"] = $_POST['pagina'];
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}
// Para sumar o restar páginas.
if (isset($_POST['movimiento'])) {

    if ($_POST['movimiento'] == "restar") {
        if ($_SESSION["pagina"] - 1 == 0) {
            $_SESSION["pagina"] = 1;
        } else {
            $_SESSION["pagina"] = $_SESSION["pagina"] - 1;
        }
    } else if ($_POST['movimiento'] == "sumar") {
        if ($_SESSION["pagina"] + 1 > $paginas) {
            $_SESSION["pagina"] = $paginas;
        } else {
            $_SESSION["pagina"] = $_SESSION["pagina"] + 1;
        }
    }

    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}
// Por que valor vamos a ordenar
if (!isset($_SESSION["ordenBy"])) {
    $_SESSION["ordenBy"] = "id";
}
// Que tipo de orden vamos a usar
if (!isset($_SESSION["ordenType"])) {
    $_SESSION["ordenType"] = "ASC";
}

// INICIO ORDENAR ID
// Valor por defecto del tipo de orden por id
if (!isset($_SESSION["id"])) {
    $_SESSION["id"] = "DESC";

}

if (isset($_POST['id'])) {
    echo "EEEE";
    $_SESSION["ordenBy"] = 'id';
    $_SESSION["ordenType"] = $_POST['id'];

    if ($_POST['id'] == "ASC") {
        $_SESSION["id"] = "DESC";
    } else {
        $_SESSION["id"] = "ASC";
    }

    //setcookie("id", $_POST['Eleazar'], time()+3600, "/","", 0);
    // refresh current page
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}
// FIN ORDENAR ID

// INICIO ORDENAR Cognom
// Valor por defecto del tipo de orden por id
if (!isset($_SESSION["cognoms"])) {
    $_SESSION["cognoms"] = "DESC";

}

if (isset($_POST['cognoms'])) {

    $_SESSION["ordenBy"] = 'cognoms';
    $_SESSION["ordenType"] = $_POST['cognoms'];

    if ($_POST['cognoms'] == "ASC") {
        $_SESSION["cognoms"] = "DESC";
    } else {
        $_SESSION["cognoms"] = "ASC";
    }

    //setcookie("id", $_POST['Eleazar'], time()+3600, "/","", 0);
    // refresh current page
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}
// FIN ORDENAR Cognom

// Preparamos el ordenBy y el ordenType para la query
$orderByAndOrderType = $_SESSION["ordenBy"] . " " . $_SESSION["ordenType"];
if (isset($_POST['orderByAndOrderType'])) {
    $orderByAndOrderType = $_POST['orderByAndOrderType'];
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

// El offset para que saltemos X productos que viene dado por:
// multiplicar (la página - 1 )* los productos por página
$offset = ($_SESSION['pagina'] - 1) * PRODUCTOS_POR_PAGINA;

// Con todos los datos ya hacemos la petición a la base de datos,
// cada vez que se actualiza la página con el envío de POST
$sentencia = $base_de_datos->prepare("SELECT * FROM contactes ORDER BY " . $orderByAndOrderType . " LIMIT ? OFFSET ?");
$sentencia->execute([LIMIT, $offset]);
$contactes = $sentencia->fetchAll(PDO::FETCH_OBJ);
//$_SESSION["pagina"] = 1;
//echo $orderByAndOrderType;

// MOSTRAMOS LA INFORMACIÓN SOLICITADA POR EL USUARIO
echo '<p class="infoPagina"> Página ' . $_SESSION["pagina"] . ' de ' . $paginas . ' </p>'
    . '<table>'
    . '<thead>'
    . '<tr>'
    . '<th>'
    . '<form action="" method="post">'
    . '<input hidden type="text" id="id" name="id" value="' . $_SESSION["id"] . '">'
    . '<input type="submit" value="Ordenar de forma ' . $_SESSION["id"] . '">'
    . '</form>'
    . '</th>'
    . '<th>'
    . '<form action="" method="post">'
    . '<input hidden type="text" id="cognoms" name="cognoms" value="' . $_SESSION["cognoms"] . '">'
    . '<input type="submit" value="Ordenar de forma ' . $_SESSION["cognoms"] . '">'
    . '</form>'
    . '</th>'
    . '<th>Nom</th>'
    . '<th colspan="3">Manteniment</th>'
    . '</tr>';
foreach ($contactes as $contacte) {
    echo '<tr>';
    echo "<td>" . $contacte->id . "</td>";
    //echo " ";
    echo "<td>" . $contacte->cognoms . "</td>";
    //echo " ";
    echo "<td>" . $contacte->nom . "</td>";
    //echo "<br>";
    echo '<td>'
    . '<form action="./view.php" method="post">'
        . '<input hidden type="text" id="contacto" name="contacto" value="' . $contacte->id . '">'
        . '<input type="image" src="./assets/img/view.png" >'
    . '</form>'
    . '</td>';
    echo '<td>'
    . '<form action="./edit.php" method="post">'
        . '<input hidden type="text" id="contacto" name="contacto" value="' . $contacte->id . '">'
        . '<input type="image" src="./assets/img/edit.png" >'
    . '</form>'
    . '</td>';
    echo '<td>'
    . '<form action="./remove.php" method="post">'
        . '<input hidden type="text" id="contacto" name="contacto" value="' . $contacte->id . '">'
        . '<input type="image" src="./assets/img/remove.png" >'
    . '</form>'
    . '</td>';
    //echo "<td><a href='./view.php?view=" . $contacte->id . "'><img src='./assets/img/view.png' alt='inicio' /></td></a>";
    //echo "<br>";
    //echo "<td><a href='./edit.php?edit=" . $contacte->id . "'><img src='./assets/img/edit.png' alt='inicio' /></td></a>";
    //echo "<br>";
    //echo "<td><a href='./remove.php?remove=" . $contacte->id . "'><img src='./assets/img/remove.png' alt='inicio' /></td></a>";
    //echo "<br>";
    echo '</tr>';
}
echo '<td class="menuMovimiento" colspan="3">'
    . '<form action="" method="post">'
    . '<input hidden type="text" id="pagina" name="pagina" value="1">'
    . '<input hidden type="text" id="orderByAndOrderType" name="orderByAndOrderType" value="' . $orderByAndOrderType . '">'
    . '<input type="image" src="./assets/img/home.png" >'
    . '</form>'
    . '<form action="" method="post">'
    . '<input hidden type="text" id="movimiento" name="movimiento" value="restar">'
    . '<input hidden type="text" id="orderByAndOrderType" name="orderByAndOrderType" value="' . $orderByAndOrderType . '">'
    . '<input type="image" src="./assets/img/left.png" >'
    . '</form>'
    . '<form action="" method="post">'
    . '<input hidden type="text" id="movimiento" name="movimiento" value="sumar">'
    . '<input hidden type="text" id="orderByAndOrderType" name="orderByAndOrderType" value="' . $orderByAndOrderType . '">'
    . '<input type="image" src="./assets/img/right.png" >'
    . '</form>'
    . '<form action="" method="post">'
    . '<input hidden type="text" id="pagina" name="pagina" value="' . $paginas . '">'
    . '<input hidden type="text" id="orderByAndOrderType" name="orderByAndOrderType" value="' . $orderByAndOrderType . '">'
    . '<input type="image" src="./assets/img/end.png" >'
    . '</form>'
    . '</td>';
    echo "<td class='menuAdd' colspan='3'><a href='./add.php'> <img src='./assets/img/add.png' alt='inicio' /></a></td>";
    echo '</tr>';
    
    echo '</tbody>';
    echo "</table>";
// FIN MOSTRAR INFORMACIÓN   





?>

