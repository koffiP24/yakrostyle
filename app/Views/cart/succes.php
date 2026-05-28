<?php
$commande = $commande ?? [];
$lignes = $commande['lignes'] ?? [];
?>

<?= view('layouts/header', ['titre' => $titre ?? 'Commande confirmée']) ?>

<section class="success-card">
    <h1><i class="fa-solid fa-check-circle"></i> Commande confirmée</h1>
    <p>Merci ! Votre commande n°<?= esc($commande['id'] ?? '') ?> a bien été enregistrée.</p>
    <p><strong>Total payé :</strong> <?= number_format($commande['total'] ?? 0, 0, ',', ' ') ?> FCFA</p>

    <div class="checkout-overview">
        <h2><i class="fa-solid fa-box-open"></i> Détails de la commande</h2>
        <?php if (empty($lignes)): ?>
            <p>Aucun détail de commande disponible.</p>
        <?php else: ?>
            <ul class="checkout-items">
                <?php foreach ($lignes as $ligne): ?>
                    <li>
                        <strong><?= esc($ligne['nom'] ?? '') ?></strong>
                        <span><?= esc($ligne['quantite'] ?? 0) ?> × <?= number_format($ligne['prix_unit'] ?? 0, 0, ',', ' ') ?> FCFA</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div style="margin-top:1.5rem; display:flex; gap:0.9rem; flex-wrap:wrap;">
        <a href="/produits" class="btn-primary"><i class="fa-solid fa-arrow-right"></i> Retour à la boutique</a>
        <a href="/" class="btn-outline"><i class="fa-solid fa-house"></i> Accueil</a>
    </div>
</section>

<?= view('layouts/footer') ?>