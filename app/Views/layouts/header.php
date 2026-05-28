<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= esc($titre ?? 'YakroStyle') ?> – Mode Yamoussoukro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<nav class="navbar">
    <div class="container nav-flex">
        <a href="/" class="brand">👕 YakroStyle</a>
        <ul class="nav-links">
            <li><a href="/produits">Tous</a></li>
            <li><a href="/produits/genre/homme">Hommes</a></li>
            <li><a href="/produits/genre/femme">Femmes</a></li>
            <li><a href="/produits/genre/enfant">Enfants</a></li>
        </ul>
        <div class="nav-actions">
            <a href="/panier" class="cart-btn">🛒 (<span id="cart-count"><?= count(session()->get('panier') ?? []) ?></span>)</a>
            <?php if (session()->get('user_id')): ?>
                <span><?= esc(session()->get('user_nom')) ?></span>
                <?php if (session()->get('user_role') === 'admin'): ?>
                    <a href="/admin" class="btn-outline">Admin</a>
                <?php endif; ?>
                <a href="/deconnexion" class="btn-outline">Déconnexion</a>
            <?php else: ?>
                <a href="/connexion" class="btn-outline">Connexion</a>
                <a href="/inscription" class="btn-primary">Inscription</a>
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