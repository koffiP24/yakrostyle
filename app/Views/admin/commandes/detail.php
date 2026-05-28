<?php
if (!isset($commande) || !is_array($commande)) {
    $commande = [
        'id' => '',
        'user_id' => '',
        'adresse' => '',
        'statut' => '',
        'created_at' => '',
        'lignes' => [],
        'total' => 0,
    ];
}
?>
<?= view('layouts/header', ['titre' => 'Détail commande #' . $commande['id']]) ?>
<h1>Commande n°<?= $commande['id'] ?></h1>
<p><strong>Client :</strong> <?= esc($commande['user_id']) ?> (ID utilisateur)</p>
<p><strong>Adresse :</strong> <?= nl2br(esc($commande['adresse'])) ?></p>
<p><strong>Statut :</strong> <?= esc($commande['statut']) ?></p>
<p><strong>Date :</strong> <?= date('d/m/Y H:i', strtotime($commande['created_at'])) ?></p>

<h2>Articles commandés</h2>
<table class="table-admin">
    <thead>
        <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($commande['lignes'] as $ligne): ?>
            <tr>
                <td><?= esc($ligne['nom']) ?></td>
                <td><?= $ligne['quantite'] ?></td>
                <td><?= number_format($ligne['prix_unit'], 0, ',', ' ') ?> FCFA</td>
                <td><?= number_format($ligne['prix_unit'] * $ligne['quantite'], 0, ',', ' ') ?> FCFA</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"><strong>Total général</strong></td>
            <td><strong><?= number_format($commande['total'], 0, ',', ' ') ?> FCFA</strong></td>
        </tr>
    </tfoot>
</table>
<a href="/admin/commandes" class="btn-outline">← Retour aux commandes</a>
<?= view('layouts/footer') ?>