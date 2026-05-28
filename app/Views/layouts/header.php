<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= esc($titre ?? 'YakroStyle') ?> – Mode Yamoussoukro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>
    <div class="topbar">
        <div class="topbar-copy">
            <i class="fa-solid fa-tags"></i>
            Première commande = -75% | Déjà plus de 10 produits achetés = -5%
        </div>
        <button id="theme-toggle" class="icon-btn" type="button" aria-label="Basculer le mode sombre">
            <i class="fa-solid fa-moon"></i>
            <span>Mode sombre</span>
        </button>
    </div>
    <nav class="navbar">
        <div class="container nav-flex">
            <a href="/" class="brand"><i class="fa-solid fa-shop"></i> YakroStyle</a>
            <ul class="nav-links">
            <a href="/produits" class="secondary-link"><i class="fa-solid fa-list"></i> Tous</a>
            <a href="/produits/genre/homme" class="secondary-link"><i class="fa-solid fa-person"></i> Hommes</a>
            <a href="/produits/genre/femme" class="secondary-link"><i class="fa-solid fa-person-dress"></i> Femmes</a>
            <a href="/produits/genre/enfant" class="secondary-link"><i class="fa-solid fa-child"></i> Enfants</a>
            </ul>
            <div class="nav-actions">
                <a href="/panier" class="cart-btn"><i class="fa-solid fa-cart-shopping"></i> <span>Panier</span> (<span id="cart-count"><?= count(session()->get('panier') ?? []) ?></span>)</a>
                <?php if (session()->get('user_id')): ?>
                    <span class="user-badge"><i class="fa-solid fa-user"></i> <?= esc(session()->get('user_nom')) ?></span>
                    <?php if (session()->get('user_role') === 'admin'): ?>
                        <a href="/admin" class="btn-outline"><i class="fa-solid fa-lock"></i> Admin</a>
                    <?php endif; ?>
                    <a href="/deconnexion" class="btn-outline"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a>
                <?php else: ?>
                    <a href="/connexion" class="btn-outline"><i class="fa-solid fa-right-to-bracket"></i> Connexion</a>
                    <a href="/inscription" class="btn-primary"><i class="fa-solid fa-user-plus"></i> Inscription</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="container">
        <?php if (session()->getFlashdata('succes')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('succes') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('erreur')): ?>
            <div class="alert alert-error"><?= session()->getFlashdata('erreur') ?></div>
        <?php endif; ?>