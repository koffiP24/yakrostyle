<?= view('layouts/header') ?>
<section class="auth-card">
    <h1><i class="fa-solid fa-tshirt"></i> Nos vêtements</h1>
    <div class="product-grid">
        <?php foreach ($produits ?? [] as $p): ?>
            <div class="product-card">
                <a href="/produit/<?= esc($p['slug']) ?>">
                    <img src="/images/<?= esc($p['image']) ?>" alt="<?= esc($p['nom']) ?>" onerror="this.src='/images/default.jpg'">
                </a>
                <div class="card-body">
                    <span class="card-cat"><?= esc($p['categorie_nom']) ?> - <?= esc($p['genre']) ?></span>
                    <h3><?= esc($p['nom']) ?></h3>
                    <?php if ($p['stock'] == 0): ?>
                        <p class="stock-ko">Aucun article restant</p>
                    <?php elseif ($p['stock'] < 5): ?>
                        <p class="stock-warning">Quelques articles restants</p>
                    <?php else: ?>
                        <p class="stock-ok">En stock</p>
                    <?php endif; ?>
                    <div class="card-footer">
                        <span class="prix"><?= number_format($p['prix'], 0, ',', ' ') ?> FCFA</span>
                        <form action="/panier/ajouter" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="produit_id" value="<?= $p['id'] ?>">
                            <input type="hidden" name="quantite" value="1">
                            <button class="btn-primary btn-sm"><i class="fa-solid fa-cart-plus"></i> Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?= view('layouts/footer') ?>