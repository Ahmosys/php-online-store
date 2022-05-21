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
                <h5 class="card-header">Edit my informations</h5>
                <div class="card-body">
                    <form data-toggle="validator" role="form" method="POST" action="index.php?controller=Utilisateur&action=editUser">
                        <h6>Name</h6>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="edit_name" value="<?= VariablesGlobales::$theUser[0]->nomUtilisateur ;?>" required>
                        </div> 
                        <hr>
                        <h6>Last Name</h6>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="edit_last_name" value="<?= VariablesGlobales::$theUser[0]->prenomUtilisateur ;?>" required>
                        </div> 
                        <hr>
                        <h6>Username</h6>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="edit_username" value="<?= VariablesGlobales::$theUser[0]->loginUtilisateur ;?>" readonly>
                        </div> 
                        <hr>
                        <h6>E-mail</h6>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="edit_email" value="<?= VariablesGlobales::$theUser[0]->emailUtilisateur ;?>" readonly>
                        </div> 
                        <hr>                      
                        <h6>Phone Number</h6>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="edit_phone_number" value="<?= VariablesGlobales::$theUser[0]->telUtilisateur ;?>" required>
                        </div> 
                        <hr>
                        <h6>Address</h6>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="edit_address" value="<?= VariablesGlobales::$theUser[0]->adresseRueUtilisateur ;?>" required>
                        </div> 
                        <hr>
                        <h6>Zip Code</h6>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="edit_zip_code" value="<?= VariablesGlobales::$theUser[0]->adresseCpUtilisateur ;?>" required>
                        </div> 
                        <hr>
                        <h6>City</h6>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="edit_city" value="<?= VariablesGlobales::$theUser[0]->adresseVilleUtilisateur ;?>" required>
                        </div> 
                        <hr>
                        <input type="submit" class="btn btn-success btn-block mb-2" value="Confirm the change" name="submit">
                        <a href="index.php?controller=Utilisateur&action=ShowIndexUser" class="btn btn-danger btn-block mb-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>