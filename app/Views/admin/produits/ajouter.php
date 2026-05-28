<?= view('layouts/header', ['titre' => 'Ajouter un produit']) ?>
<div class="admin-form">
    <h1>➕ Ajouter un produit</h1>
    <form method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <label>Catégorie :</label>
        <select name="categorie_id" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= esc($cat['nom']) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Genre :</label>
        <select name="genre" required>
            <option value="homme">Homme</option>
            <option value="femme">Femme</option>
            <option value="enfant">Enfant</option>
            <option value="mixte">Mixte</option>
        </select>

        <label>Nom :</label>
        <input type="text" name="nom" required>

        <label>Description :</label>
        <textarea name="description" rows="4"></textarea>

        <label>Prix (FCFA) :</label>
        <input type="number" name="prix" step="100" required>

        <label>Stock :</label>
        <input type="number" name="stock" value="0" required>

        <label>Style :</label>
        <input type="text" name="style" placeholder="simple, chic, fashion, sportswear, traditionnel">

        <label>Tissu :</label>
        <input type="text" name="tissu" placeholder="coton, jean, bazin, wax, lin">

        <label>Image :</label>
        <input type="file" name="image" accept="image/*">

        <label>
            <input type="checkbox" name="promo" value="1"> En promotion
        </label>

        <button type="submit" class="btn-primary">Ajouter le produit</button>
        <a href="/admin/produits" class="btn-outline">Annuler</a>
    </form>
</div>
<?= view('layouts/footer') ?>