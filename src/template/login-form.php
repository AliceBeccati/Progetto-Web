<?php if (!empty($templateParams["errorelogin"])): ?>
    <div class="alert alert-danger">
        <?php echo $templateParams["errorelogin"]; ?>
    </div>
<?php endif; ?>

<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">

            <div class="border rounded p-3 bg-secondary" style="--bs-bg-opacity:.5;">
                <p class="mb-3">Inserisci le tue credenziali per accedere al sito.</p>

                <form action="login.php" method="POST">
                    <div class="mx-auto" style="max-width: 300px;">

                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                                <input
                                    class="form-control bg-secondary"
                                    style="--bs-bg-opacity:.35;"
                                    type="email"
                                    id="email"
                                    name="email"
                                    required
                                />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input
                                class="form-control bg-secondary"
                                style="--bs-bg-opacity:.35;"
                                type="password"
                                id="password"
                                name="password"
                                required
                            />
                        </div>

                        <button class="btn btn-danger w-100" type="submit" id="submit">
                            Invia
                        </button>

                    </div>
                </form>

                <hr class="my-3">

                <p class="mb-2">Se non hai un account clicca il bottone per registrarti</p>

                <a href="registrazione.php" class="btn btn-outline-danger w-100">
                    Registrati
                </a>

            </div>
        </div>
    </div>
</div>
