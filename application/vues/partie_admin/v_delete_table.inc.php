<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">E-COMMERCE DELETE TABLES</h1>
        <p class="lead text-muted mb-0">Here you will find a projection of the chosen table.</p>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-4">
            <?php
            if (count(VariablesGlobales::$theErrors) > 0) {
                ?>
                <div class="alert alert-danger text-center mt-3">
                    <?php
                    foreach (VariablesGlobales::$theErrors as $theError) {
                        echo $theError;
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <form method="POST" action="index.php?controller=Admin&action=deleteOccurence">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Delete</label>
                    </div>
                    <select class="custom-select" id="choicePrimaryKey" name="choicePrimaryKey" required>
                        <option value="" selected hidden disabled>Choose...</option>
                        <?php
                        foreach (VariablesGlobales::$theOccurrences as $theOccurrence) {
                            foreach (VariablesGlobales::$theFieldsPrimaryKey as $theFieldPrimaryKey) {
                                ?>
                                <option value="<?= $theOccurrence->$theFieldPrimaryKey; ?>"><?= $theOccurrence->$theFieldPrimaryKey; ?></option>
                                <?php
                            }
                        }
                        $_SESSION['tableName'] = $_REQUEST['tableName'];
                        $_SESSION['theFieldPrimaryKey'] = $theFieldPrimaryKey;
                        ?>
                    </select>
                    <button class="btn btn-outline-secondary" type="submit">Go!</button>
                </div>
            </form>
        </div>
        <div class="col-8">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <caption>Table of <?= $_SESSION['tableName']; ?></caption>
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
                    <tbody>
                        <?php
                        foreach (VariablesGlobales::$theOccurrences as $theOccurrence) {
                            ?>
                            <tr>
                                <?php
                                foreach ($theOccurrence as $unAttribut) {
                                    ?>
                                    <td><?= $unAttribut; ?></td>
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
</div>

