<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">Welcome to your account settings <?= $_SESSION['login_username']; ?></h1>
        <p class="lead text-muted mb-0">Here you will find the possibility to manage your preferences.</p>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6">
            <p class="text-uppercase" style="margin-bottom: 2px !important;">My account</p>
            <h5 class="font-weight-bold mb-4"><?= VariablesGlobales::$theUser[0]->prenomUtilisateur . " " . VariablesGlobales::$theUser[0]->nomUtilisateur; ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 mb-3">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active text-white text-uppercase">
                    User account details
                </a>
                <a href="index.php?controller=Utilisateur&action=ShowIndexUser" class="list-group-item list-group-item-action"><i class="fa fa-user"></i>&nbsp;My account</a>
                <a href="index.php?controller=Utilisateur&action=showOrderHistoryUser" class="list-group-item list-group-item-action"><i class="fa fa-history"></i>&nbsp;My order history</a>
                <a href="index.php?controller=Utilisateur&action=showFavoriteProductUser" class="list-group-item list-group-item-action"><i class="fa fa-heart"></i>&nbsp;My list of favorites</a>
                <a href="index.php?controller=Identification&action=logOff" class="list-group-item list-group-item-action text-danger"><i class="fa fa-sign-out"></i>&nbsp;Disconnect</a>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-6 mb-3">
            <div class="card mb-5">
                <h5 class="card-header">My order content</h5>
                <div class="card-body">
                    <div class="row">
                        <?php
                        if (VariablesGlobales::$theOrderContent == null) {
                            ?> 
                            <h6 class="ml-3">🙁&nbsp;You have not ordered anything yet.</h6>
                            <?php
                        } else {
                            ?>
                            <div class="table-responsive m-5">
                                <table class="table table-striped table-bordered">
                                    <caption>Content of your orders number #<?= VariablesGlobales::$theOrderContent[0]->idCommande ?></caption>
                                    <thead>
                                        <tr>         
                                            <th scope="col">Order Number</th>
                                            <th scope="col">Order Product</th>
                                            <th scope="col">Order Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach (VariablesGlobales::$theOrderContent as $theOccurrence) {
                                            ?>
                                            <tr>
                                                <?php
                                                $i = 0;
                                                foreach ($theOccurrence as $theAttribute) {
                                                    ?>
                                                    <td><?= $theAttribute; ?></td>
                                                    <?php
                                                    $i++;
                                                    if ($i == 4) {
                                                        ?>
                                                        <td class="text-right"><a href="index.php?controller=Utilisateur&action=showOrderContent&idOrder=<?= $theOccurrence->Order_Number ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a></td>
                                                                <?php
                                                            }
                                                            ?>    
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
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>