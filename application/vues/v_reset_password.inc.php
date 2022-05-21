<link type="text/css" rel="stylesheet" href="<?= Chemins::STYLES.'style_login.css'?>" />

<div class="container h-auto">
    <div class="row h-auto justify-content-center align-items-center">
        <div class="card w-75" style="margin-top: 120px; margin-bottom: 120px;">
            <h4 class="card-header">Password reset</h4>
            <div class="card-body">
                <form role="form" method="POST" action="index.php?case=resetPassword">
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
                    <?php
                    if (count(VariablesGlobales::$theSuccesses) > 0) {
                        ?>
                        <div class="alert alert-success text-center mt-3">
                            <?php
                            foreach (VariablesGlobales::$theSuccesses as $theSuccess) {
                                echo $theSuccess;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="reset_password"  value="" title="" required="" placeholder="Your password here">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="reset_password_confirm" value="" title="" required="" placeholder="Your password here">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="redirect" value="">
                            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Continue" name="submit">
                        </div>
                    </div>
                </form>
                <br/>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>