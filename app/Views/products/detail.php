<?php
$produit = $produit ?? [
    'nom' => '',
    'image' => 'default.jpg',
    'promo' => false,
    'categorie_slug' => '',
    'categorie_nom' => '',
    'style' => '',
    'tissu' => '',
    'genre' => '',
    'prix' => 0,
    'description' => '',
    'stock' => 0,
    'id' => 0,
];
?>
<?= view('layouts/header', ['titre' => $produit['nom'] ?: 'Produit']) ?>

<section class="auth-card">

    <div class="detail-wrap">
        <!-- Colonne image -->
        <div class="detail-img">
            <img src="/images/<?= esc($produit['image']) ?>" alt="<?= esc($produit['nom']) ?>" onerror="this.src='/images/default.jpg'">
            <?php if ($produit['promo']): ?>
                <span class="badge-promo">Promotion</span>
            <?php endif; ?>
        </div>

        <!-- Colonne informations -->
        <div class="detail-info">
            <nav class="breadcrumb">
                <a href="/produits">Boutique</a> ›
                <a href="/produits/categorie/<?= esc($produit['categorie_slug'] ?? '') ?>"><?= esc($produit['categorie_nom']) ?></a> ›
                <span><?= esc($produit['nom']) ?></span>
            </nav>

            <h1><i class="fa-solid fa-shirt"></i> <?= esc($produit['nom']) ?></h1>

            <div class="detail-caracteristiques">
                <?php if ($produit['style']): ?>
                    <span class="badge-style"><?= esc($produit['style']) ?></span>
                <?php endif; ?>
                <?php if ($produit['tissu']): ?>
                    <span class="badge-tissu">Tissu : <?= esc($produit['tissu']) ?></span>
                <?php endif; ?>
                <span class="badge-genre"><?= ucfirst(esc($produit['genre'])) ?></span>
            </div>

            <p class="detail-prix">
                <?= number_format($produit['prix'], 0, ',', ' ') ?> FCFA
            </p>

            <div class="detail-description">
                <?= nl2br(esc($produit['description'])) ?>
            </div>

            <?php if ($produit['stock'] == 0): ?>
                <p class="stock-ko">Aucun article restant</p>
            <?php elseif ($produit['stock'] < 5): ?>
                <p class="stock-warning">Quelques articles restants</p>
                <form action="/panier/ajouter" method="POST" class="form-ajout-panier">
                    <?= csrf_field() ?>
                    <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
                    <div class="qty-selector">
                        <label for="quantite">Quantité :</label>
                        <input type="number" id="quantite" name="quantite" value="1" min="1" max="<?= $produit['stock'] ?>">
                    </div>
                    <button type="submit" class="btn-primary btn-lg"><i class="fa-solid fa-cart-plus"></i> Ajouter au panier</button>
                </form>
            <?php else: ?>
                <p class="stock-ok">✅ En stock</p>
                <form action="/panier/ajouter" method="POST" class="form-ajout-panier">
                    <?= csrf_field() ?>
                    <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
                    <div class="qty-selector">
                        <label for="quantite">Quantité :</label>
                        <input type="number" id="quantite" name="quantite" value="1" min="1" max="<?= $produit['stock'] ?>">
                    </div>
                    <button type="submit" class="btn-primary btn-lg"><i class="fa-solid fa-cart-plus"></i> Ajouter au panier</button>
                </form>
            <?php endif; ?>

            <div class="detail-paiement">
                <p><i class="fa-solid fa-lock"></i> Paiement sécurisé : Mobile Money (MTN, Orange) ou espèces à la livraison.</p>
                <p><i class="fa-solid fa-truck-fast"></i> Livraison gratuite à Yamoussoukro.</p>
            </div>
        </div>
    </div>

    <!-- Section produits similaires (optionnelle) -->
    <?php
    // Vous pouvez ajouter ici une requête pour des produits de même catégorie
    // mais ce n'est pas obligatoire pour le fonctionnement de base
    ?>
</section>

<?= view('layouts/footer') ?>