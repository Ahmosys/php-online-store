<?php

session_start();
ob_start();
require_once 'configs/require.inc.php';
GestionPanier::initialize();


if (isset($_COOKIE['login_username'])) {
    $_SESSION['login_username'] = $_COOKIE['login_username'];
}

if (isset($_COOKIE['is_admin'])) {
    $_SESSION['is_admin'] = $_COOKIE['is_admin'];
}

if (!isset($_REQUEST['controller'])) {
    require_once(Chemins::VUES . "v_home.inc.php");
} else {
    $action = $_REQUEST['action'];
    $controllerClass = 'Controleur' . $_REQUEST['controller'];
    $controllerFile = $controllerClass . ".class.php";
    // Permet de vérifié si la valeur écrit dans le paramètre "controller" est bien un nom de classe existant.
    if (file_exists(Chemins::CONTROLEURS . $controllerFile)) {
        require_once(Chemins::CONTROLEURS . $controllerFile);
        $controllerObject = new $controllerClass();
        // Permet de vérifié que la valeur écrit dans le paramètre "action" est bien un nom de méthode existante.
        try {
            $controllerObject->$action();
        } catch (Error $err) {
            require_once(Chemins::VUES . "v_error_404.inc.php");
        }
    } else {
        require_once(Chemins::VUES . "v_error_404.inc.php");
    }
}

require Chemins::VUES_PERMENENTES.'v_pied.inc.php';

?>