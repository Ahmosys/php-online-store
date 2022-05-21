<link type="text/css" rel="stylesheet" href="<?= Chemins::STYLES.'style_login.css'?>" />

<div class="container h-auto">
    <div class="row h-auto justify-content-center align-items-center">
        <div class="card w-75" style="margin-top: 120px; margin-bottom: 120px;">
            <h4 class="card-header">Login</h4>
            <div class="card-body">
                <form data-toggle="validator" role="form" method="post" action="index.php?controller=Identification&action=checkConnection">
                    <?php
                    if (count(VariablesGlobales::$theErrors) > 0) {
                        ?>
                        <div class="alert alert-danger text-center mt-3">
                            <?php
                            foreach (VariablesGlobales::$theErrors as $theError) {
                                echo $theError;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="login_username" value="" title="Four (4) or more characters" required="" placeholder="Your username here">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-unlock" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="password" name="login_password" id="login_password" class="form-control" title="Four (4) or more characters" required="" placeholder="Your password here">
                                    <div class="input-group-append">
                                        <button type="button" id="btn_view_password" name="btn_view_password" class="btn btn-secondary"><i class="fa fa-eye"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox_remember" type="checkbox" name="remember">
                            <label for="checkbox_remember">Logging in automatically</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="redirect" value="">
                            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Login" name="submit">
                        </div>
                    </div>
                </form>
                <br/>
                <div class="clear"></div>
                <i class="fa fa-user fa-fw"></i>Don't have an account yet ?&nbsp;<a href="index.php?controller=Identification&action=showRegister">Register</a><br>
                <i class="fa fa-user fa-fw"></i>Forgot your password ?&nbsp;<a href="index.php?controller=Identification&action=showForgotPassword">Reset</a><br>
            </div>
        </div>
    </div>
</div>