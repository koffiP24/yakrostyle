<?= view('layouts/header') ?>
<h1>Nos vêtements</h1>
<div class="product-grid">
    <?php foreach ($produits as $p): ?>
        <div class="product-card">
            <a href="/produit/<?= esc($p['slug']) ?>">
                <img src="/images/<?= esc($p['image']) ?>" alt="<?= esc($p['nom']) ?>" onerror="this.src='/images/default.jpg'">
            </a>
            <div class="card-body">
                <span class="card-cat"><?= esc($p['categorie_nom']) ?> - <?= esc($p['genre']) ?></span>
                <h3><?= esc($p['nom']) ?></h3>
                <div class="card-footer">
                    <span class="prix"><?= number_format($p['prix'], 0, ',', ' ') ?> FCFA</span>
                    <form action="/panier/ajouter" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="produit_id" value="<?= $p['id'] ?>">
                        <input type="hidden" name="quantite" value="1">
                        <button class="btn-primary btn-sm">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?= view('layouts/footer') ?>