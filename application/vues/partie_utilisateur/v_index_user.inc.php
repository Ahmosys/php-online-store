<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">Welcome to your account settings <?= $_SESSION['login_username']; ?></h1>
        <p class="lead text-muted mb-0">Here you will find the possibility to manage your preferences.</p>
    </div>
</section>
<div id="myModalDelete" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Delete the account 🗑</h5>
            </div>
            <div class="modal-body">
                <p class="text-center">I confirm my request to <span class="text-danger">delete</span> my account under the conditions defined in the privacy policy.</p>
            </div>
            <div class="modal-footer">
                <a href="index.php?controller=Utilisateur&action=deleteUser"><button type="button" class="btn btn-danger">Delete the account</button></a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
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
                <h5 class="card-header">My informations</h5>
                <div class="card-body">
                    <h6>Name</h6>
                    <p><?= VariablesGlobales::$theUser[0]->prenomUtilisateur ;?></p>
                    <hr>
                    <h6>Last name</h6>
                    <p><?= VariablesGlobales::$theUser[0]->nomUtilisateur ;?></p>
                    <hr>
                    <h6>Username</h6>
                    <p><?= VariablesGlobales::$theUser[0]->loginUtilisateur ;?></p>
                    <hr>
                    <h6>E-mail</h6>
                    <p><?= VariablesGlobales::$theUser[0]->emailUtilisateur ;?></p>
                    <hr>
                    <h6>Phone number</h6>
                    <p><?= VariablesGlobales::$theUser[0]->telUtilisateur ;?></p>
                    <hr>
                    <h6>Address</h6>
                    <p><?= VariablesGlobales::$theUser[0]->adresseRueUtilisateur . ", " . VariablesGlobales::$theUser[0]->adresseCpUtilisateur . " " . VariablesGlobales::$theUser[0]->adresseVilleUtilisateur;?></p>
                    <hr>                    
                    <a class="btn btn-outline-secondary btn-block mb-2" href="index.php?controller=Utilisateur&action=showEditUser">Edit my data</a>
                    <button type="button" id="btnDeleteAccount" class="btn btn-outline-danger btn-block">Delete my account</button>
                </div>
            </div>
        </div>
    </div>
</div>