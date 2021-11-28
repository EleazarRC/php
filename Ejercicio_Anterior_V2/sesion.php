<?php
    // Iniciamos la sesión en el inicio del script
    // creamos una nueva o recuperamos valores de una existente
    session_start();
?>
<html><head><tittle>saludos</tittle></head>
    <body>
    <h2> Bienvenidos a nuestra página de pruebas de sesiones.</h2>
<?php
    // Si no existe la variable "VISITAS", la creamos
    if (!isset($_SESSION["visitas"])) {
        
        echo "Hola, parece que acabas de llegar. ¡Bienvenido! <br>";

        // Iniciamos la variable sesión a 1
        $_SESSION["visitas"] = 1;
    }
    // Si ya existe la variable "visitas", actualizamos su valor
    else {
        // Recogemos el valor previo y lo incrementamos
        $visitas = $_SESSION["visitas"] + 1;
        echo "¿Ya estás de vuelta?";
        echo "Con esta van " . $visitas . " veces<BR>";
        // Actualizamos el valor de la variable de sesión
        $_SESSION["visitas"] = $visitas;
    }

    // Comprobamos si las cookies están activas o no exist
    $session_id = SID;
    if (isset($session_id) && $session_id) {
        
        $href = $_SERVER["PHP_SELF"] . "?" . $session_id;
    } else {
        $href = $_SERVER["PHP_SELF"];
    }
    ?>
    <br><a href="<?php echo $href; ?>"> vuelve cuando quieras </a>
</body>
</html>