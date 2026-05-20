<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="data-card">
    <div class="data-card-head">
        <h3>Gestion des Collaborateurs</h3>
        <a href="<?= base_url('admin/create') ?>" class="btn-forest">
            <i class="bi bi-plus-lg"></i> Ajouter un employé
        </a>
    </div>
    
    <table class="tbl">
        <thead>
            <tr>
                <th>Nom & Prénom</th>
                <th>Email</th>
                <th>Département</th>
                <th>Rôle</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employes as $emp): ?>
            <tr>
                <td style="font-weight: 500; color: var(--ink);">
                    <?= esc(strtoupper($emp['nom'])) ?> <?= esc($emp['prenom']) ?>
                </td>
                <td class="mono" style="font-size: .85rem; color: var(--muted);"><?= esc($emp['email']) ?></td>
                <td style="color: var(--muted);"><?= esc($emp['nom_departement']) ?></td>
                <td>
                    <span class="type-badge <?= $emp['role'] == 'admin' ? 't-maladie' : ($emp['role'] == 'rh' ? 't-special' : 't-sans-solde') ?>">
                        <?= esc(strtoupper($emp['role'])) ?>
                    </span>
                </td>
                <td style="text-align: right;">
                    <a href="<?= base_url('admin/delete/'.$emp['id']) ?>" 
                       onclick="return confirm('Supprimer définitivement ce collaborateur ?')" 
                       class="btn-sm" style="background: var(--danger-bg); color: var(--danger); border-color: var(--danger-br)">
                       <i class="bi bi-trash"></i> Supprimer
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>