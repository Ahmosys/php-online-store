<?php

/**
 * Classe regroupant des fonctions/méthodes utilitaires.
 */
class Utils {

    /**
     * Retourne l'URI de la page précédente.
     * @return string URI
     */
    public static function getPreviousURI() {
        $URI = "Location: " . $_SERVER['HTTP_REFERER'];
        return $URI;
    }

    /*
     * Retourne l'arborescence du dossier parent.
     */
    public static function getListFolderFiles($dirPath) {
        $ffs = scandir($dirPath);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        // prevent empty ordered elements
        if (count($ffs) < 1)
            return;

        echo '<ol class="list-group ">';
        foreach ($ffs as $ff) {
            echo '<li class="list-group-item">' . $ff;
            if (is_dir($dirPath . '/' . $ff))
                self::getListFolderFiles($dirPath . '/' . $ff);
            echo '</li>';
        }
        echo '</ol>';
    }

    /**
     * Retourne la valeur du pourcentage d'un nombre.
     *
     * @param int $number La valeur à convertir
     * @param int $percentage Le pourcentage à appliquer
     * @return int La valeur convertie
     */
    public static function getValuePercentage($number, $percentage)
    { 
      return $number - ($number * $percentage / 100);
    } 
}

?>

