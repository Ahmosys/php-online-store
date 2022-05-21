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
                <h5 class="card-header">My favorite products</h5>
                <div class="card-body">
                    <div class="row">
                        <?php
                        if (VariablesGlobales::$theFavoriteProductsUser == null) {
                            ?> 
                            <h6 class="ml-3">🙁&nbsp;You have no products in your favorites for the moment.</h6>
                            <?php
                        }
                        ?>
                        <?php
                        foreach (VariablesGlobales::$theFavoriteProductsUser as $theFavoriteProduct) { //Permet de crée tout les produits de la catégories
                            ?>
                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <div class="card mb-4 box-shadow-product">
                                    <span class="badge badge-pill badge-warning m-2">Stock: <?= $theFavoriteProduct->QteStockProduit; ?></span>
                                    <?php
                                    if (isset($_SESSION['login_username'])) {
                                        ?>
                                        <a class="btn btn-secondary btn-circle btn-circle-sm float-right m-2" href="index.php?controller=Produit&action=addProductToListFavorite&idProduct=<?= $theFavoriteProduct->idProduit; ?>"><i class="fa fa-heart" style="<?= GestionBoutique::checkProductFavoriteColorHeart($_SESSION['id_user'], $theFavoriteProduct->idProduit); ?>" ></i></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="btn btn-secondary btn-circle btn-circle-sm float-right m-2" href="index.php?controller=Produit&action=addProductToListFavorite&idProduct=<?= $theFavoriteProduct->idProduit; ?>"><i class="fa fa-heart"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <img class="card-img-top" src="<?= Chemins::IMAGES_PRODUITS . strtolower($theFavoriteProduct->LibelleCategorie); ?>/<?= $theFavoriteProduct->ImageProduit; ?>" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title"><a href="product.html" title="View Product"></i><?= $theFavoriteProduct->LibelleProduit; ?></a></h4>
                                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        <div class="row">
                                            <div class="col">
                                                <p class="btn btn-danger btn-block"><i class="fa fa-tags">&nbsp;</i><?= $theFavoriteProduct->PrixHTProduit; ?> $</p>
                                            </div>
                                            <div class="col">
                                                <a href="index.php?controller=Panier&action=addToCart&idProduct=<?= $theFavoriteProduct->idProduit; ?>" class="btn btn-success btn-block"><i class="fa fa-shopping-basket">&nbsp;</i>Add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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