<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">E-COMMERCE CONTACT</h1>
        <p class="lead text-muted mb-0">Here you will find information about us and the possibility to contact us.</p>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card mt-4 mb-5">
                <div class="card-header bg-primary text-white"><i class="fa fa-envelope"></i> Send a message to newsletter subscribers
                </div>
                <div class="card-body">
                    <form action="index.php?controller=Admin&action=sendMessageNewsletter" method="POST">
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
                            <label for="name">Object of your message</label>
                            <input type="text" class="form-control" id="email_object" name="email_object" aria-describedby="emailHelp" placeholder="Your object here" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="email_message" name="email_message" rows="6" placeholder="Your message here" required></textarea>
                        </div>
                        <div class="mx-auto">
                        <button type="submit" class="btn btn-primary">Submit</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>