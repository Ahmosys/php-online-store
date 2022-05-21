<nav class="navbar navbar-expand-md navbar-dark bg-secondary">
    <div class="container">
        <a class="navbar-brand" href="index.php">E-commerce</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarsExampleDefault">
            <ul class="navbar-nav m-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=Produit&action=showProduct">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=Contact&action=showContact">Contact</a>
                </li>
                <?php
                if (isset($_SESSION['is_admin'])) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=Admin&action=showIndexAdmin">Admin Panel</a>
                </li>
                <?php
                }
                ?>
            </ul>

            <form action="index.php?controller=Produit&action=searchProduct" method="POST" class="form-inline my-2 my-lg-0">
                <div class="input-group input-group-sm">
                    <input type="text" name="recherche" class="form-control" placeholder="Search for product...">
                    <div class="input-group-append">
                        <button type="button" onclick="form.submit();" class="btn btn-dark btn-number">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
                <a class="btn btn-success btn-sm ml-3" href="index.php?controller=Panier&action=showCart">
                    <i class="fa fa-shopping-cart"></i> Cart
                    <span class="badge badge-light"><?= GestionPanier::getNbProducts(); ?></span>
                </a>
                <?php
                if (!isset($_SESSION['login_username'])) {
                ?>
                <a class="btn btn-primary btn-sm ml-3" href="index.php?controller=Identification&action=showLogin">
                   <i class="fa fa-sign-in"></i> Login
                </a>
                <?php
                } else {
                ?>
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm ml-3 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Welcome <?= $_SESSION['login_username']; ?>&nbsp;🤙
                    </button>
                    <div class="dropdown-menu ml-3" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="index.php?controller=Utilisateur&action=showIndexUser"><i class="fa fa-user-circle"></i>&nbsp;My account</a>
                        <a class="dropdown-item" href="index.php?controller=Utilisateur&action=showOrderHistoryUser"><i class="fa fa-history"></i>&nbsp;My order history</a>
                        <a class="dropdown-item" href="index.php?controller=Utilisateur&action=showFavoriteProductUser"><i class="fa fa-heart"></i>&nbsp;My list of favorites</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="index.php?controller=Identification&action=logOff"><i class="fa fa-sign-in"></i>&nbsp;Disconnect</a>
                    </div>
                </div>
                <?php
                }
                ?>
        </div>
    </div>
</nav>