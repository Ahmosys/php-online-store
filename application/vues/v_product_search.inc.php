<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading ">RESULT OF YOUR SEARCH</h1>
        <p class="lead text-muted mb-0">You will find here the products corresponding to your search.</p>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="row">
                <?php
                foreach (VariablesGlobales::$theResearchProducts as $theProduct) //Permet de crée tout les produits de la catégories
                {
                ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card mb-4 box-shadow-product">
                        <span class="badge badge-pill badge-warning m-2">Stock: <?= $theProduct->QteStockProduit; ?></span>
                        <?php
                        if (isset($_SESSION['login_username'])) {                            
                        ?>
                        <a class="btn btn-secondary btn-circle btn-circle-sm float-right m-2" href="index.php?controller=Produit&action=addProductToListFavorite&idProduct=<?= $theProduct->idProduit; ?>"><i class="fa fa-heart" style="<?= GestionBoutique::checkProductFavoriteColorHeart($_SESSION['id_user'], $theProduct->idProduit); ?>" ></i></a>
                        <?php
                        } else {
                        ?>
                        <a class="btn btn-secondary btn-circle btn-circle-sm float-right m-2" href="index.php?controller=Produit&action=addProductToListFavorite&idProduct=<?= $theProduct->idProduit; ?>"><i class="fa fa-heart"></i></a>
                        <?php 
                        }
                        ?>
                        <img class="card-img-top" src="<?= Chemins::IMAGES_PRODUITS . strtolower($theProduct->LibelleCategorie); ?>/<?= $theProduct->ImageProduit; ?>" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title"><a href="product.html" title="View Product"><?= $theProduct->LibelleProduit; ?></a></h4>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <div class="row">
                                <div class="col">
                                    <p class="btn btn-danger btn-block"><i class="fa fa-tags">&nbsp;</i><?= $theProduct->PrixHTProduit; ?>$</p>
                                </div>
                                <div class="col">
                                    <a href="index.php?controller=Panier&action=addToCart&idProduct=<?= $theProduct->idProduit; ?>" class="btn btn-success btn-block atc"><i class="fa fa-shopping-basket">&nbsp;</i>Add to cart</a>
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