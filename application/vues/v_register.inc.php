<link type="text/css" rel="stylesheet" href="<?= Chemins::STYLES . 'style_contact_sent.css' ?>" />

<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="card w-75" style="margin-top: 60px; margin-bottom: 120px;">
            <h4 class="card-header">Register</h4>
            <div class="card-body">
                <form id="registerUser" data-toggle="validator" role="form" method="post" action="index.php?controller=Identification&action=registerUser">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="register_username" id="register_username" value="" pattern="^[a-z-A-Z-0-9_-]{3,15}$" title="Please enter a valid username !" required="" placeholder="Your username here">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="register_last_name" id="register_last_name" value="" pattern="^[a-zA-Zéèà]{3,20}$" title="Please enter a valid last name !" required="" placeholder="Your last name here">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-12">
                            <div class="" id="alert_placeholder_username"></div>
                    </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="register_name" id="register_name" value="" pattern="^[a-zA-Zéèà]{3,20}$" title="Please enter a valid  name !" required="" placeholder="Your name here">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>E-mail</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-at" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="email" class="form-control" name="register_email" id="register_email" value="" required="" placeholder="Your e-mail here">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="tel" class="form-control" name="register_phone_number" id="register_phone_number" value="" pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}" title="Please enter a valid phone number !" required="" placeholder="Your phone number here">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-map-pin" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="register_address" id="register_address" value="" pattern="^[a-z-A-Zéèà-0-9_-]{3,250}$" title="Please enter a valid address !" required="" placeholder="Your address here">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Zip Code</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-map-pin" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="register_zip_code" id="register_zip_code" value="" pattern="[0-9]{5}" title="Please enter a valid zip code !" required="" placeholder="Your zip code here">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>City</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-map-pin" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="register_city" id="register_city" value="" pattern="^[a-zA-Zéèà]{3,50}$" title="Please enter a valid city !" required="" placeholder="Your city here">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-unlock" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="password" name="register_password" id="register_password" class="form-control" pattern=".{4,}" title="Please enter a valid password !" required="" placeholder="Your password here">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-unlock" aria-hidden="true"></i></span>
                                    </div>
                                    <input type="password" name="register_confirm_password" id="register_confirm_password" class="form-control" pattern=".{4,}" title="Please enter a valid password !" required="" placeholder="Your password here">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="" id="alert_placeholder_password"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox_accept" type="checkbox" name="checkbox_accept" required="true">
                                <label for="checkbox_accept"> I have read and accept the <a href="index.php?case=showPrivacyPolicy">privacy policy</a> of this site.</label>
                            </div>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox_newsletter" type="checkbox" checked="true" name="checkbox_newsletter" value="yes">
                                <label for="checkbox_newsletter"> I would like to receive new offers, promotional codes and news by email.</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="h-captcha mb-2" data-sitekey="40b0cc96-6809-458a-8bf4-6528dc08fa98"></div>
                        </div>
                        <div class="col-md-12">
                            <input type="hidden" name="redirect" value="">
                            <input type="submit" class="btn btn-primary btn-md btn-block mt-2" value="Create an account" name="submit">
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>