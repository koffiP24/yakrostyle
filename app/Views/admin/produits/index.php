<?= view('layouts/header') ?>
<h1>Gestion des produits</h1>
<a href="/admin/produits/ajouter" class="btn-primary">+ Ajouter un produit</a>
<table class="table-admin">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $produits = $produits ?? []; ?>
        <?php foreach ($produits as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><img src="/images/<?= esc($p['image']) ?>" width="50"></td>
                <td><?= esc($p['nom']) ?></td>
                <td><?= number_format($p['prix'], 0, ',', ' ') ?> FCFA</td>
                <td><?= $p['stock'] ?></td>
                <td>
                    <a href="/admin/produits/modifier/<?= $p['id'] ?>">✏️ Modifier</a>
                    <a href="/admin/produits/supprimer/<?= $p['id'] ?>" onclick="return confirm('Supprimer ?')">🗑️ Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= view('layouts/footer') ?>