<h2>Login</h2>

<?php if (!empty($templateParams["errorelogin"])): ?>
    <div class="alert alert-danger">
        <?php echo $templateParams["errorelogin"]; ?>
    </div>
<?php endif; ?>

<form action="login.php" method="POST">
    <div class="row justify-content-center mb-5">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <section class="bg-secondary border p-4" style="--bs-bg-opacity: .5;">
                        <p>Inserisci le tue credenziali per accedere al sito.</p>
                        <div class="row col-md-8">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label" for="email">Email</label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control bg-secondary" style="--bs-bg-opacity: .4;" 
                                           type="email" id="email" name="email" required />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="col-6">
                                    <input class="form-control bg-secondary" style="--bs-bg-opacity: .4;" 
                                           type="password" id="password" name="password" required />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12 text-end">
                                    <input class="btn btn-danger" type="submit" id="submit" value="Invia">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</form>
