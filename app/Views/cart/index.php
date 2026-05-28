<?= view('layouts/header', ['titre' => 'Mon panier']) ?>

<section class="auth-card">
    <h1><i class="fa-solid fa-shopping-cart"></i> Mon panier</h1>

    <?php if (empty($panier)): ?>
        <div class="cart-empty">
            <p>Votre panier est vide.</p>
            <a href="/produits" class="btn-primary">Découvrir nos vêtements</a>
        </div>
    <?php else: ?>
        <?php
        $total = 0;
        foreach ($panier as $item) {
            $total += $item['prix'] * $item['quantite'];
        }
        ?>
        <div class="cart-wrap">
            <!-- Liste des articles -->
            <div class="cart-items">
                <?php foreach ($panier as $id => $item): ?>
                    <div class="cart-row">
                        <div class="cart-img">
                            <img src="/images/<?= esc($item['image']) ?>" alt="<?= esc($item['nom']) ?>" onerror="this.src='/images/default.jpg'">
                        </div>
                        <div class="cart-info">
                            <h3><?= esc($item['nom']) ?></h3>
                            <p class="cart-prix"><?= number_format($item['prix'], 0, ',', ' ') ?> FCFA / pièce</p>
                        </div>
                        <form action="/panier/modifier" method="POST" class="cart-qty">
                            <?= csrf_field() ?>
                            <input type="hidden" name="produit_id" value="<?= $id ?>">
                            <label>Quantité :</label>
                            <input type="number" name="quantite" value="<?= $item['quantite'] ?>" min="0">
                            <button type="submit" class="btn-outline btn-sm">Mettre à jour</button>
                        </form>
                        <div class="cart-total-ligne">
                            <?= number_format($item['prix'] * $item['quantite'], 0, ',', ' ') ?> FCFA
                        </div>
                        <a href="/panier/supprimer/<?= $id ?>" class="btn-danger btn-sm" onclick="return confirm('Retirer cet article ?')"><i class="fa-solid fa-trash"></i></a>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Résumé et validation -->
            <aside class="cart-summary">
                <h2>Récapitulatif</h2>
                <table class="cart-summary-table">
                    <tr>
                        <td>Sous-total</td>
                        <td><?= number_format($total, 0, ',', ' ') ?> FCFA</td>
                    </tr>
                    <tr>
                        <td>Livraison</td>
                        <td><strong>Gratuite</strong> (Yamoussoukro)</td>
                    </tr>
                    <tr class="total-row">
                        <td><strong>Total</strong></td>
                        <td><strong><?= number_format($total, 0, ',', ' ') ?> FCFA</strong></td>
                    </tr>
                </table>
                <a href="/commande" class="btn-primary btn-block"><i class="fa-solid fa-credit-card"></i> Passer la commande</a>
                <a href="/panier/vider" class="btn-outline btn-block" onclick="return confirm('Vider tout le panier ?')"><i class="fa-solid fa-trash-can"></i> Vider le panier</a>
                <a href="/produits" class="btn-outline btn-block"><i class="fa-solid fa-arrow-left"></i> Continuer mes achats</a>
            </aside>
        </div>
    <?php endif; ?>
</section>

<?= view('layouts/footer') ?>