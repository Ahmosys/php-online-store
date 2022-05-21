<?php

VariablesGlobales::$lastProduct = GestionBoutique::getDernierProduit(1);
VariablesGlobales::$lastProducts = GestionBoutique::getDernierProduit(4);
VariablesGlobales::$topProduct = GestionBoutique::getMeilleurProduit(1) ;
VariablesGlobales::$topProducts = GestionBoutique::getMeilleurProduit(4) ;            
VariablesGlobales::$theProducts = GestionBoutique::getLesProduitsAndCategories();

?>

<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">E-COMMERCE WEBSITE</h1>
        <p class="lead text-muted mb-0">Welcome to our online store, we hope you enjoy shopping.</p>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col">
            <div id="img-hidden" style="display: none;">
                <img class="mx-auto d-block" src="<?= Chemins::IMAGES . 'easter_egg/img_issou.gif'; ?>"/>
            </div>
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title">Welcome 👋</h5>
                        </div>
                        <div class="modal-body">
                            <p class="text-center">Welcome to our store, I hope you will like it, we wish you a good navigation !</p>
                            <p class="text-center">If you have any questions or need help you can contact the support.</p>
                        </div>
                        <div class="modal-footer">
                            <a href="index.php?controller=Contact&action=ShowContact"><button type="button" class="btn btn-primary">Contact support</button></a>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" name="contact" id="contact">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="carouselExampleIndicators" class="carousel slide border border-primary" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="<?= Chemins::IMAGES . "home/img_carousel_1.png"; ?>" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="<?= Chemins::IMAGES . "home/img_carousel_2.png"; ?>" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="<?= Chemins::IMAGES . "home/img_carousel_3.png"; ?>" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card m-2">
                <div class="card-header bg-success text-white text-uppercase">
                    <i class="fa fa-heart"></i> Top product
                </div>
                <img class="img-fluid border-0" src="<?= Chemins::IMAGES_PRODUITS . strtolower(VariablesGlobales::$topProduct[0]->LibelleCategorie); ?>/<?= VariablesGlobales::$topProduct[0]->ImageProduit; ?>" alt="Card image cap">
                <div class="card-body">
                    <h4 class="card-title text-center"><a href="#" title="View Product"><?= VariablesGlobales::$topProduct[0]->LibelleProduit; ?></a></h4>
                    <div class="row">
                        <div class="col">
                            <p class="btn btn-danger btn-block"><?= VariablesGlobales::$topProduct[0]->PrixHTProduit; ?> $</p>
                        </div>
                        <div class="col">
                            <a href="#" class="btn btn-success btn-block"><i class="fa fa-eye">&nbsp;</i>View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header bg-primary text-white text-uppercase">
                    <i class="fa fa-star"></i> Last products
                </div>
                <div class="card-body">
                    <div class="row">
                    <?php
                    foreach (VariablesGlobales::$lastProducts as $lastProduct) //Permet de crée tout les produits de la catégories
                    {
                    ?>
                        <div class="col-sm">
                            <div class="card box-shadow-product m-2">
                                <span class="badge badge-pill badge-warning m-2">Stock: <?= $lastProduct->QteStockProduit;?></span>
                                <?php
                                if (isset($_SESSION['login_username'])) {                            
                                ?>
                                <a class="btn btn-secondary btn-circle btn-circle-sm float-right m-2" href="index.php?controller=Produit&action=addProductToListFavorite&idProduct=<?= $lastProduct->idProduit; ?>"><i class="fa fa-heart" style="<?= GestionBoutique::checkProductFavoriteColorHeart($_SESSION['id_user'], $lastProduct->idProduit); ?>" ></i></a>
                                <?php
                                } else {
                                ?>
                                <a class="btn btn-secondary btn-circle btn-circle-sm float-right m-2" href="index.php?controller=Produit&action=addProductToListFavorite&idProduct=<?= $lastProduct->idProduit; ?>"><i class="fa fa-heart"></i></a>
                                <?php 
                                }
                                ?>
                                <img class="card-img-top" src="<?= Chemins::IMAGES_PRODUITS . strtolower($lastProduct->LibelleCategorie); ?>/<?= $lastProduct->ImageProduit;?>" alt="Card image cap">
                                <div class="card-body">
                                    <h4 class="card-title"><a href="product.html" title="View Product"><?= $lastProduct->LibelleProduit; ?></a></h4>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <div class="row">
                                        <div class="col">
                                            <p class="btn btn-danger btn-block"><i class="fa fa-tags">&nbsp;</i><?= $lastProduct->PrixHTProduit; ?> $</p>
                                        </div>
                                        <div class="col">
                                            <a href="index.php?controller=Panier&action=addToCart&idProduct=<?= $lastProduct->idProduit; ?>" class="btn btn-success btn-block atc"><i class="fa fa-shopping-basket">&nbsp;</i>Add to cart</a>
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
<div class="container mt-3 mb-4">
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header bg-primary text-white text-uppercase">
                    <i class="fa fa-trophy"></i> Best products
                </div>
                <div class="card-body">
                    <div class="row">
                    <?php
                    foreach (VariablesGlobales::$topProducts as $topProduct) //Permet de crée tout les produits de la catégories
                    {
                    ?>
                        <div class="col-sm">
                            <div class="card box-shadow-product m-2">
                                <span class="badge badge-pill badge-warning m-2">Stock: <?= $topProduct->QteStockProduit;?></span>
                                <?php
                                if (isset($_SESSION['login_username'])) {                            
                                ?>
                                <a class="btn btn-secondary btn-circle btn-circle-sm float-right m-2" href="index.php?controller=Produit&action=addProductToListFavorite&idProduct=<?= $topProduct->idProduit; ?>"><i class="fa fa-heart" style="<?= GestionBoutique::checkProductFavoriteColorHeart($_SESSION['id_user'], $topProduct->idProduit); ?>" ></i></a>
                                <?php
                                } else {
                                ?>
                                <a class="btn btn-secondary btn-circle btn-circle-sm float-right m-2" href="index.php?controller=Produit&action=addProductToListFavorite&idProduct=<?= $topProduct->idProduit; ?>"><i class="fa fa-heart"></i></a>
                                <?php 
                                }
                                ?>
                                <img class="card-img-top" src="<?= Chemins::IMAGES_PRODUITS . strtolower($topProduct->LibelleCategorie); ?>/<?= $topProduct->ImageProduit; ?>" alt="Card image cap">
                                <div class="card-body">
                                    <h4 class="card-title"><a href="product.html" title="View Product"><?= $topProduct->LibelleProduit; ?></a></h4>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <div class="row">
                                        <div class="col">
                                            <p class="btn btn-danger btn-block"><i class="fa fa-tags">&nbsp;</i><?= $topProduct->PrixHTProduit; ?> $</p>
                                        </div>
                                        <div class="col">
                                            <a href="index.php?controller=Panier&action=addToCart&idProduct=<?= $topProduct->idProduit; ?>" class="btn btn-success btn-block atc"><i class="fa fa-shopping-basket">&nbsp;</i>Add to cart</a>
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
