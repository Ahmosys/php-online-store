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
    require_once(Chemins::CONTROLEURS . $controllerFile);

    $controllerObject = new $controllerClass();
    $controllerObject->$action();
}

require Chemins::VUES_PERMENENTES.'v_pied.inc.php';

?>