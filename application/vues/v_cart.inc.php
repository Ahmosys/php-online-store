<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">E-COMMERCE CART</h1>
        <p class="lead text-muted mb-0">Here you will find your shopping cart with the items you have added.</p>
     </div>
</section>
<div class="container mb-4">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col"> </th>
                            <th scope="col">Product</th>
                            <th scope="col">Available</th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col" class="text-right">Price</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php 
                        $lesIdsProduits = array_keys($_SESSION['products']);
                        $subTotal = 0;
                        foreach ($lesIdsProduits as $key=>$value) {
                            $leProduit = GestionBoutique::getProduitById($value);
                            $subTotal += ($leProduit->PrixHTProduit * GestionPanier::getQtyByProduct($value));
                        ?>
                        <tr>
                            <td><img src="<?= Chemins::IMAGES_PRODUITS .  strtolower($leProduit->LibelleCategorie); ?>/<?= $leProduit->ImageProduit; ?>" style="width: 50px; height: 50px;" /> </td>
                            <td><?= $leProduit->LibelleProduit; ?></td>
                            <td>In stock</td>
                            <td class="text-center"><a href="index.php?controller=Panier&action=decrementedQuantity&idProduct=<?= $leProduit->idProduit; ?>&qteProduct=<?= GestionPanier::getQtyByProduct($value); ?>" class="dqc"><i class="fa fa-minus-circle"></i></a>&nbsp;<?= GestionPanier::getQtyByProduct($value); ?>&nbsp;<a href="index.php?controller=Panier&action=incrementedQuantity&idProduct=<?= $leProduit->idProduit; ?>&qteProduct=<?= GestionPanier::getQtyByProduct($value) ;?>" class="iqc"><i class="fa fa-plus-circle"></i></a></td>
                            <td class="text-right"><?= $leProduit->PrixHTProduit; ?> $</td>
                            <td class="text-right"><a href="index.php?controller=Panier&action=removeFromCart&idProduct=<?= $leProduit->idProduit; ?>" class="btn btn-sm btn-danger rfc"><i class="fa fa-trash"></i></a></td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Sub-Total</td>
                            <td class="text-right"><?= $subTotal; ?> $</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Shipping</td>
                            <td class="text-right">6.90 $</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td class="text-right"><strong><?= $subTotal + 6.90; ?> $</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col mb-2">
            <div class="row">
                <div class="col-sm-12  col-md-6">
                    <a href="index.php?controller=Produit&action=showProduct" class="btn btn-block btn-light">Continue Shopping</button></a>
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                <a href="index.php?controller=Panier&action=showCheckout" class="btn btn-block btn-success">Checkout</button></a>
                </div>
            </div>
        </div>
    </div>
</div>