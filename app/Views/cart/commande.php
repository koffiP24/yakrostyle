<?php
$panier = $panier ?? [];
$reduction = $reduction ?? 0;
$total = $total ?? array_sum(array_map(fn($i) => ($i['prix'] ?? 0) * ($i['quantite'] ?? 0), $panier));
$montantRemise = $montantRemise ?? round($total * $reduction / 100, 2);
$totalApresRemise = $totalApresRemise ?? max(0, $total - $montantRemise);
?>

<?= view('layouts/header', ['titre' => $titre ?? 'Validation de la commande']) ?>

<section class="checkout-card">
    <h1><i class="fa-solid fa-receipt"></i> Validation de la commande</h1>

    <div class="promo-banner">
        <i class="fa-solid fa-percent"></i>
        <?php if ($reduction > 0): ?>
            <?= $reduction === 75 ? 'Promo première commande : -75%' : 'Client fidèle : -5% sur cette commande' ?>
        <?php else: ?>
            Aucune réduction automatique.
        <?php endif; ?>
    </div>

    <div class="checkout-grid">
        <div class="checkout-overview">
            <h2><i class="fa-solid fa-shopping-basket"></i> Votre panier</h2>
            <?php if (empty($panier)): ?>
                <p>Votre panier est vide. Merci de revenir après avoir ajouté des articles.</p>
            <?php else: ?>
                <ul class="checkout-items">
                    <?php foreach ($panier as $item): ?>
                        <li>
                            <strong><?= esc($item['nom'] ?? '') ?></strong>
                            <span><?= esc($item['quantite'] ?? 0) ?> × <?= number_format($item['prix'] ?? 0, 0, ',', ' ') ?> FCFA</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <dl class="checkout-summary">
                <dt>Sous-total</dt>
                <dd><?= number_format($total, 0, ',', ' ') ?> FCFA</dd>
                <?php if ($reduction > 0): ?>
                    <dt>Remise <?= $reduction ?>%</dt>
                    <dd>- <?= number_format($montantRemise, 0, ',', ' ') ?> FCFA</dd>
                <?php endif; ?>
                <dt>Total à payer</dt>
                <dd><strong><?= number_format($totalApresRemise, 0, ',', ' ') ?> FCFA</strong></dd>
            </dl>
        </div>

        <div class="checkout-form">
            <h2><i class="fa-solid fa-location-dot"></i> Adresse de livraison</h2>
            <form action="/commande/confirmer" method="POST">
                <?= csrf_field() ?>

                <label for="adresse">Adresse complète</label>
                <textarea id="adresse" name="adresse" rows="5" required placeholder="Votre adresse de livraison à Yamoussoukro"></textarea>

                <button type="submit" class="btn-primary"><i class="fa-solid fa-check"></i> Confirmer ma commande</button>
            </form>
        </div>
    </div>
</section>

<?= view('layouts/footer') ?>