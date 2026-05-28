<?= view('layouts/header', ['titre' => $titre ?? 'Connexion']) ?>

<section class="auth-card">
    <h1><i class="fa-solid fa-right-to-bracket"></i> Connexion</h1>
    <p>Connectez-vous pour profiter des offres exclusives et finaliser facilement votre commande.</p>

    <form action="/connexion" method="POST">
        <?= csrf_field() ?>

        <label for="email">Email</label>
        <div class="input-icon">
            <i class="fa-solid fa-envelope"></i>
            <input id="email" type="email" name="email" required autocomplete="email" placeholder="votre@email.ci">
        </div>

        <label for="mot_de_passe">Mot de passe</label>
        <div class="input-icon input-password">
            <i class="fa-solid fa-lock"></i>
            <input id="mot_de_passe" type="password" name="mot_de_passe" required autocomplete="current-password" placeholder="••••••••">
            <button type="button" class="password-toggle" data-target="mot_de_passe" aria-label="Afficher ou masquer le mot de passe">
                <i class="fa-solid fa-eye"></i>
            </button>
        </div>

        <button type="submit" class="btn-primary">Se connecter</button>
    </form>

    <p>Pas encore de compte ? <a href="/inscription">Créez un compte</a> maintenant.</p>
</section>

<?= view('layouts/footer') ?>