<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">E-COMMERCE TABLES</h1>
        <p class="lead text-muted mb-0">Here you will find a projection of the chosen table.</p>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="table-responsive p-5">
            <table class="table table-striped table-bordered" id="myTable">
                <caption>Table of <?= $_REQUEST['tableName']; ?></caption>
                <thead>
                    <tr>
                        <?php
                        foreach (VariablesGlobales::$theFields as $theField) {
                            if ($theField->Key == "PRI") {
                        ?>
                                <th scope="col"><u><?= $theField->Field; ?></u></th>
                            <?php
                            } elseif ($theField->Key == "MUL") {
                            ?>
                                <th scope="col"><?= $theField->Field . "#"; ?></th>
                            <?php
                            } else {
                            ?>
                                <th scope="col"><?= $theField->Field; ?></th>
                            <?php
                            }
                            ?>
                        <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody id ="table">
                    <?php
                    foreach (VariablesGlobales::$theOccurrences as $theOccurrence) {
                    ?>
                        <tr>
                            <?php
                            foreach ($theOccurrence as $theAttribute) {
                            ?>
                                <td><?= $theAttribute; ?></td>
                            <?php
                            }
                            ?>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>