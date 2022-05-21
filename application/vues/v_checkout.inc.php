<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">E-COMMERCE CHECKOUT</h1>
        <p class="lead text-muted mb-0">Here you will find a summary of your order before proceeding to payment.</p>
    </div>
</section>
<div class="container mb-4">
    <div class="row">
        <aside class="col-lg-9 mt-2">
            <div class="card">
                <h5 class="card-header">
                    Your order content
                </h5>
                <div class="card-body">
                    <?php 
                    $lesIdsProduits = array_keys($_SESSION['products']);
                    $subTotal = 0;
                    foreach ($lesIdsProduits as $key=>$value) {
                        $leProduit = GestionBoutique::getProduitById($value);
                        $subTotal += ($leProduit->PrixHTProduit * GestionPanier::getQtyByProduct($value));
                    ?>
                    <div class="row align-items-center">
                        <div class="col-10">
                            <h6 class="card-title"><?= $leProduit->LibelleProduit; ?></h6>
                            <p class="card-text mb-0">Price : <?= $leProduit->PrixHTProduit; ?> $</p>
                            <p class="card-text">Quantity : <?= GestionPanier::getQtyByProduct($value) ;?></p>
                        </div>
                        <div class="col-2">
                            <img src="<?= Chemins::IMAGES_PRODUITS .  strtolower($leProduit->LibelleCategorie); ?>/<?= $leProduit->ImageProduit; ?>" class="img-fluid" /> 
                        </div>
                    </div>
                    <hr />
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="card mt-2">
                <h5 class="card-header">
                    Your informations
                </h5>
                <div class="card-body">
                <h6 class="card-title">Your shipping address</h6>
                <p class="card-text mb-0"><?= VariablesGlobales::$theUser[0]->nomUtilisateur . " " .  VariablesGlobales::$theUser[0]->prenomUtilisateur; ?></p>
                <p class="card-text"><?= VariablesGlobales::$theUser[0]->adresseRueUtilisateur . ", " . VariablesGlobales::$theUser[0]->adresseCpUtilisateur . " " . VariablesGlobales::$theUser[0]->adresseVilleUtilisateur  ;?></p>
                <h6 class="card-title">Your shipping method</h6>
                <p class="card-text">Fast-delivery</p>
                </div>
            </div>
        </aside>
        <aside class="col-lg-3 mt-2">
            <div class="card">
                <h5 class="card-header">
                    Summary
                </h5>
                <div class="card-body">
                    <h6 class="card-title m-0">Sub-Total</h6>
                    <p class="card-text"><?= $subTotal; ?> $</p>
                    <h6 class="card-title m-0">Shipping</h6>
                    <p class="card-text">6.90 $</p>
                    <h6 class="card-title m-0">Total</h6>
                    <?php if (isset($_SESSION["promo_code"])) { ?>
                        <p class="card-text mb-0"><del><?= $subTotal; ?> $</del></p>
                        <p class="card-text text-success font-weight-bold"><?= (isset($_SESSION["promo_code"])) ? Utils::getValuePercentage($subTotal, $_SESSION["promo_code"][0]->tauxPromotion)  : $subTotal + 6.90; ?> $ (<?= $_SESSION["promo_code"][0]->idCodePromotion . " -" . $_SESSION["promo_code"][0]->tauxPromotion . "%"?>)</p>
                    <?php } else { ?>
                        <p class="card-text"><?= $subTotal + 6.90; ?> $</p>
                    <?php } ?>
                    <hr />
                    <h6 class="card-title m-0">Promotion code</h6>
                    <form action="index.php?controller=Panier&action=checkPromotionCode" method="POST">
                        <div class="input-group my-3">
                            <input type="text" class="form-control" placeholder="Your promo code" name="promo_code_checkout" id="promo_code_checkout">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">Apply</button>
                            </div>
                        </div>
                    </form>
                    <hr />
                    <div class="text-center">
                        <a href="#" class="btn btn-success text-center">Proceed to payment&nbsp;<i class="fa fa-paypal"></i></a>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>