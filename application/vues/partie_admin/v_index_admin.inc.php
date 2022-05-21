<?php
$dbName = VariablesGlobales::$theDatabaseName;
?>

<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">Welcome to the administration interface <?= $_SESSION['login_username']; ?></h1>
        <p class="lead text-muted mb-0">Here you will find the possibility to manage the database of the merchant site.</p>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card bg-light mb-5">
                <div class="card-header bg-secondary text-white text-uppercase"><i class="fa fa-list"></i>&nbsp;Tables</div>
                <ul class="list-group category_block">
                    <?php
                    foreach (VariablesGlobales::$theTables as $theTable) { //Permet d'afficher toutes les catégories dans le menu
                        ?>
                        <li class="list-group-item">
                            <?= $theTable->$dbName; ?>
                            <a href="index.php?controller=Admin&action=deleteFromTable&tableName=<?= $theTable->$dbName;?>" class="btn btn-sm btn-danger float-right mr-2"><i class="fa fa-trash"></i></a>
                            <a href="index.php?controller=Admin&action=showFromTable&tableName=<?= $theTable->$dbName;?>" class="btn btn-sm btn-warning float-right mr-2"><i class="fa fa-pencil"></i></a>                   
                            <a href="index.php?controller=Admin&action=addFromTable&tableName=<?= $theTable->$dbName;?>" class="btn btn-sm btn-success float-right mr-2"><i class="fa fa-plus"></i></a>
                            <a href="index.php?controller=Admin&action=showFromTable&tableName=<?= $theTable->$dbName;?>" class="btn btn-sm btn-primary float-right mr-2"><i class="fa fa-eye"></i></a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card bg-light mb-5">
                <div class="card-header bg-secondary text-white text-uppercase"><i class="fa fa-list"></i>&nbsp;Others</div>
                <ul class="list-group category_block">                
                    <li class="list-group-item"><a href="index.php?controller=Admin&action=showNewsletter">Send an e-mail to all users</a></li>
                    <li class="list-group-item"><a href="index.php?controller=Admin&action=showFromTable&tableName=<?= $theTable->$dbName;?>">View ip address of all user</a></li>   
                    <li class="list-group-item"><a href="index.php?controller=Admin&action=showFromTable&tableName=<?= $theTable->$dbName;?>">View statistics</a></li>            
                </ul>
            </div>
        </div>
    </div>
</div>