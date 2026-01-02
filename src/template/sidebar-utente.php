<div class="text-center mb-4">
    <i class="bi bi-person-circle display-1 text-secondary"></i>
    
    <h4 class="fw-bold mt-3">
        <?php echo $_SESSION["user"]["name"]; ?>
    </h4>
    
    <p class="text-muted mb-1">
        <?php echo $_SESSION["user"]["email"]; ?>
    </p>

    <span class="badge bg-danger rounded-pill">
        <?php echo strtoupper($_SESSION["user"]["ruolo"]); ?>
    </span>
</div>

<?php if (!empty($_SESSION["user"]["bio"])): ?>
    <div class="bg-white card bg-light p-3 mb-4 text-start">
        <small class="text-muted text-uppercase fw-bold">Bio:</small>
        <p class="mb-0 fst-italic">
            "<?php echo $_SESSION["user"]["bio"]; ?>"
        </p>
    </div>
<?php endif; ?>

<a href="gestioneLogin.php?logout=1" class="btn btn-danger w-100">
    <i class="bi bi-box-arrow-right"></i> Logout
</a>