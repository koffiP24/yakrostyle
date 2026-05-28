<?= view('layouts/header', ['titre' => 'Modifier un produit']) ?>
<div class="admin-form">
    <h1>✏️ Modifier le produit</h1>
    <form method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <label>Catégorie :</label>
        <select name="categorie_id" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $produit['categorie_id'] ? 'selected' : '' ?>>
                    <?= esc($cat['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Genre :</label>
        <select name="genre" required>
            <?php foreach (['homme','femme','enfant','mixte'] as $g): ?>
                <option value="<?= $g ?>" <?= $g == $produit['genre'] ? 'selected' : '' ?>><?= ucfirst($g) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Nom :</label>
        <input type="text" name="nom" value="<?= esc($produit['nom']) ?>" required>

        <label>Description :</label>
        <textarea name="description" rows="4"><?= esc($produit['description']) ?></textarea>

        <label>Prix (FCFA) :</label>
        <input type="number" name="prix" step="100" value="<?= $produit['prix'] ?>" required>

        <label>Stock :</label>
        <input type="number" name="stock" value="<?= $produit['stock'] ?>" required>

        <label>Style :</label>
        <input type="text" name="style" value="<?= esc($produit['style']) ?>">

        <label>Tissu :</label>
        <input type="text" name="tissu" value="<?= esc($produit['tissu']) ?>">

        <label>Image actuelle :</label>
        <img src="/images/<?= esc($produit['image']) ?>" width="80" style="display:block; margin-bottom:0.5rem;">
        <label>Changer l'image :</label>
        <input type="file" name="image" accept="image/*">

        <label>
            <input type="checkbox" name="promo" value="1" <?= $produit['promo'] ? 'checked' : '' ?>> En promotion
        </label>

        <button type="submit" class="btn-primary">Enregistrer</button>
        <a href="/admin/produits" class="btn-outline">Annuler</a>
    </form>
</div>
<?= view('layouts/footer') ?>