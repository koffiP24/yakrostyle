<?= view('layouts/header', ['titre' => $titre ?? 'Inscription']) ?>

<section class="auth-card">
    <h1><i class="fa-solid fa-user-plus"></i> Inscription</h1>
    <p>Créez votre compte pour obtenir des réductions et suivre facilement vos commandes.</p>

    <form action="/inscription" method="POST">
        <?= csrf_field() ?>

        <label for="nom">Nom complet</label>
        <div class="input-icon">
            <i class="fa-solid fa-user"></i>
            <input id="nom" type="text" name="nom" required autocomplete="name" placeholder="Votre nom">
        </div>

        <label for="email">Email</label>
        <div class="input-icon">
            <i class="fa-solid fa-envelope"></i>
            <input id="email" type="email" name="email" required autocomplete="email" placeholder="votre@email.ci">
        </div>

        <label for="mot_de_passe">Mot de passe</label>
        <div class="input-icon input-password">
            <i class="fa-solid fa-lock"></i>
            <input id="mot_de_passe" type="password" name="mot_de_passe" required autocomplete="new-password" placeholder="••••••••">
            <button type="button" class="password-toggle" data-target="mot_de_passe" aria-label="Afficher ou masquer le mot de passe">
                <i class="fa-solid fa-eye"></i>
            </button>
        </div>

        <button type="submit" class="btn-primary">Créer mon compte</button>
    </form>

    <p>Déjà un compte ? <a href="/connexion">Connectez-vous</a>.</p>
</section>

<?= view('layouts/footer') ?>