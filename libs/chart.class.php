<?php
require_once '../configs/mysql_config.class.php';
require_once '../application/modeles/modelePDO.class.php';

class Chart {

    public static function chartOrderByUser() {

        // Declare and inialize variable
        $columnUser = '';

        // Request database
        $result = ModelePDO::requeteSelect("nomUtilisateur, COUNT(idCommande) AS nbOrder", "commande, utilisateur", "(commande.idUtilisateur = utilisateur.idUtilisateur) GROUP BY commande.idUtilisateur");

        // Formation table
        foreach ($result as $unResult) {
            $columnUser = $columnUser . '"' . $unResult->nomUtilisateur . '",';
        }

        // Remove end comma
        $columnUser = trim($columnUser, ",");

        return $columnUser;
    }

    public static function chartOrderByNb() {

        // Declare and inialize variable
        $columnNbOrder = '';

        // Request database
        $result = ModelePDO::requeteSelect("nomUtilisateur, COUNT(idCommande) AS nbOrder", "commande, utilisateur", "(commande.idUtilisateur = utilisateur.idUtilisateur) GROUP BY commande.idUtilisateur");

        // Formation table
        foreach ($result as $unResult) {
            $columnNbOrder = $columnNbOrder . '"' . $unResult->nbOrder . '",';
        }

        // Remove end comma
        $columnNbOrder = trim($columnNbOrder, ",");

        return $columnNbOrder;
    }

}
?>

<!doctype HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Chart.js</title>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
    </head>
    <body>
        <h1>Numbers of orders by users</h1>
        <div class="chart-container" style="position: relative; height:40vh; width:80vw">
            <canvas id="orderChart"></canvas>
        </div>
        <script>
            const ctx = document.getElementById('orderChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?= Chart::chartOrderByUser();?>],
                    datasets: [{
                            label: '# of Votes',
                            data: [<?= Chart::chartOrderByNb();?>],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                }
            });
        </script>
    </body>
</html>