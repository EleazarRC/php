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
// Conexión a la base de datos...
include_once "base_de_datos.php";

//Inicio de sesiones de el usuario
session_start();

$productosPorPagina = 5;

$limit = $productosPorPagina;

// Necesitamos saber cuantas páginas vamos a mostrar
$sentencia = $base_de_datos->query("SELECT count(*) AS n_contactos FROM contactes");
$conteo = $sentencia->fetchObject()->n_contactos;

$paginas = ceil($conteo / $productosPorPagina);





// Inicializamos las variables de sesión
if (!isset($_SESSION["pagina"])) {
    $_SESSION["pagina"] = 1;
}
// Control movimiento usuario
if (!empty($_GET["pag"])) {
    if ($_GET["pag"] == "atras") {

        if ($_SESSION['pagina'] - 1 == 0) { // prevenimos que no vaya paginas inexistentes.
            $_SESSION['pagina'] = 1;
        } else {
            $_SESSION['pagina'] = $_SESSION['pagina'] - 1;
        }

    } else if ($_GET["pag"] == "adelante") {

        if ($_SESSION['pagina'] + 1 > $paginas) { // prevenimos que no vaya paginas inexistentes.
            $_SESSION['pagina'] = $paginas;
        } else {
            $_SESSION['pagina'] = $_SESSION['pagina'] + 1;
        }
    }
} else if (!empty($_GET["pagina"])) {
    $_SESSION['pagina'] = $_GET["pagina"];
}

$orderBy = 'id';
// Sesion para cognoms
if (!isset($_SESSION["cognoms"])) {
    $_SESSION["cognoms"] = "ASC";
    $cognoms = "DESC";
} else {
    $cognoms = "ASC";
}

if (isset($_GET["cognoms"])) {
    $orderBy = 'cognoms';
    $_SESSION["cognoms"] = $_GET["cognoms"]; // COMO SE TENDRÁ QUE MOSTRAR EN LA QUERY
    $cognoms = $_SESSION["cognoms"];
    $orderType = $cognoms;
    // Preparo enlace de cognoms para que sea al revel cual vuelvan a pulsar
    if ($cognoms == "DESC") {
        $cognoms = "ASC";
        $orderType = $cognoms;
    } else {
        $cognoms = "DESC";
        $orderType = $cognoms;
    }
}

// Sesion para id
if (!isset($_SESSION["id"])) {
    $_SESSION["id"] = "ASC";
    $id = "DESC";
} else {
    $id = "ASC";
}

if (isset($_GET["id"])) {
    $orderBy = 'id';
    $_SESSION["id"] = $_GET["id"]; // COMO SE TENDRÁ QUE MOSTRAR EN LA QUERY
    $id = $_SESSION["id"];
    $orderType = $id;
    // Preparo enlace de id para que sea al revel cual vuelvan a pulsar
    if ($id == "DESC") {
        $id = "ASC";
        $orderType = $id;
    } else {
        $id = "DESC";
        $orderType = $id;
    }
}

if(empty($orderType)) {
    $orderType = "ASC";
}

$orderbyAndType = $orderBy . " " . $orderType;


// El offset para que saltemos X productos que viene dado por:
// multiplicar (la página - 1 )* los productos por página
$offset = ($_SESSION['pagina'] - 1) * $productosPorPagina;


# Ahora obtenemos los productos usando ya el OFFSET y el LIMIT
$sentencia = $base_de_datos->prepare("SELECT * FROM contactes ORDER BY " . $orderbyAndType  ." LIMIT ? OFFSET ?");
$sentencia->execute([$limit, $offset]);
$contactes = $sentencia->fetchAll(PDO::FETCH_OBJ);




// Mostramos la información
echo "<table>";
echo '<thead>';
echo '<tr>';
echo '<th><a href="./index.php?id=', urlencode($id), '&pagina=', urlencode($_SESSION['pagina']), '"> Ordenar por ID ' . $id . "</a></th>";
echo '<th><a href="./index.php?cognoms=', urlencode($cognoms), '&pagina=', urlencode($_SESSION['pagina']), '"> Ordenar por Cognom ' . $cognoms . "</a></th>";
echo '<th>Nom</th>';
echo '<th colspan="3">Manteniment</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
echo '<p class="infoPagina"> Página ' . $_SESSION["pagina"] . ' de ' . $paginas . ' </p>';
// MOSTRAMOS LA INFORMACIÓN
echo "<div class='información'>";


echo "<div class='información'>";    
foreach ($contactes as $contacte) { 
    echo '<tr>';
    echo "<td>" . $contacte->id ."</td>";
    //echo " ";
    echo "<td>" . $contacte->cognoms ."</td>";
    //echo " ";
    echo "<td>" . $contacte->nom ."</td>";
    //echo "<br>";
    echo "<td><a href='./view.php?view=" . $contacte->id . "'><img src='./assets/img/view.png' alt='inicio' /></td></a>";
    //echo "<br>";
    echo "<td><a href='./edit.php?edit=" . $contacte->id . "'><img src='./assets/img/edit.png' alt='inicio' /></td></a>";
    //echo "<br>";
    echo "<td><a href='./remove.php?remove=" . $contacte->id . "'><img src='./assets/img/remove.png' alt='inicio' /></td></a>";
    //echo "<br>";
    echo '</tr>';
}

echo '<tr>';
if (isset($_GET["cognoms"])) { //$cognoms
    echo '<td class="menuMovimiento" colspan="3">'
        . '<a href="./index.php?pagina=1&cognoms=' . $_SESSION["cognoms"] . '"><img src="./assets/img/home.png" alt="inicio"/></a>'
        . '<a href="./index.php?pag=atras&cognoms=' . $_SESSION["cognoms"] . '"><img src="./assets/img/left.png" alt="atrás"/></a>'
        . '<a href="./index.php?pag=adelante&cognoms=' . $_SESSION["cognoms"] . '"><img src="./assets/img/right.png" alt="adelante"/></a>'
        . '<a href="./index.php?pagina=' . $paginas . '&cognoms=' . $_SESSION["cognoms"] . '"><img src="./assets/img/end.png" alt="final"/></a>'
        . '</td>';

} else if (isset($_GET["id"])) {
    echo '<td class="menuMovimiento" colspan="3">'
        . '<a href="./index.php?pagina=1&id=' . $_SESSION["id"] . '"><img src="./assets/img/home.png" alt="inicio"/></a>'
        . '<a href="./index.php?pag=atras&id=' . $_SESSION["id"] . '"><img src="./assets/img/left.png" alt="atrás"/></a>'
        . '<a href="./index.php?pag=adelante&id=' . $_SESSION["id"] . '"><img src="./assets/img/right.png" alt="adelante"/></a>'
        . '<a href="./index.php?pagina=' . $paginas . '&id=' . $_SESSION["id"] . '"><img src="./assets/img/end.png" alt="final"/></a>'
        . '</td>';
} else {
    echo '<td class="menuMovimiento" colspan="3">'
        . '<a href="./index.php?pagina=1"><img src="./assets/img/home.png" alt="inicio"/></a>'
        . '<a href="./index.php?pag=atras"><img src="./assets/img/left.png" alt="atrás"/></a>'
        . '<a href="./index.php?pag=adelante"><img src="./assets/img/right.png" alt="adelante"/></a>'
        . '<a href="./index.php?pagina=' . $paginas . '"><img src="./assets/img/end.png" alt="final"/></a>'
        . '</td>';
}

echo "<td class='menuAdd' colspan='3'><a href='./add.php'> <img src='./assets/img/add.png' alt='inicio' /></a></td>";
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
    . '</div> ';

 /*// Si se desea destruir la sesión completamente, borre también la cookie de sesión.
// Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
if (ini_get("session.use_cookies")) {
$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 42000,
$params["path"], $params["domain"],
$params["secure"], $params["httponly"]
);
}

// Finalmente, destruir la sesión.
session_destroy();*/

?>

</body>
</html>