<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">E-COMMERCE CONTACT</h1>
        <p class="lead text-muted mb-0">Here you will find information about us and the possibility to contact us.</p>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card" style="margin-bottom: 100px;">
                    <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-envelope"></i> Contact us
                </div>
                <div class="card-body">
                    <form action="index.php?controller=Contact&action=sendMessageFromForm" method="POST">
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
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="contact_name" aria-describedby="emailHelp" placeholder="Your name here" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="contact_email" aria-describedby="emailHelp" placeholder="Your e-mail here" required>
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="contact_message" rows="6" placeholder="Your message here" required></textarea>
                        </div>
                        <div class="form-group">
                            <input id="checkbox_accept" type="checkbox" name="accept" required>
                            <label for="checkbox_accept">I have read and accept the <a href="index.php?case=showPrivacyPolicy">privacy policy</a> of this site.</label>
                        </div>
                        <div class="h-captcha mb-2" data-sitekey="40b0cc96-6809-458a-8bf4-6528dc08fa98"></div>
                        <div class="mx-auto">
                        <button type="submit" class="btn btn-primary text-right">Submit</button></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="card bg-light mb-3">
                <div class="card-header bg-success text-white text-uppercase"><i class="fa fa-home"></i> Address</div>
                <div class="card-body">
                    <p>3 rue des Champs Elysées</p>
                    <p>75008 PARIS</p>
                    <p>France</p>
                    <p>Email : email@example.com</p>
                    <p>Tel. +33 12 56 11 51 84</p>
                </div>
            </div>
        </div>
    </div>
</div>