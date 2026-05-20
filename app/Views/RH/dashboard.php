<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="data-card">
    <div class="data-card-head">
        <h3>Demandes en attente d'instruction (RH)</h3>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>Collaborateur</th>
                <th>Type d'absence</th>
                <th>Période demandée</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($demandes)): ?>
                <tr>
                    <td colspan="4" style="text-align: center; color: var(--muted); padding: 2.5rem;">
                        <i class="bi bi-clipboard-check" style="font-size: 1.8rem; display:block; opacity: 0.4; margin-bottom: 5px;"></i>
                        Parfait ! Toutes les demandes ont été traitées.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($demandes as $d): ?>
                <tr>
                    <td style="font-weight: 500;">
                        <?= esc(strtoupper($d['nom'])) ?> <?= esc($d['prenom']) ?>
                    </td>
                    <td>
                        <span class="type-badge <?= $d['libelle'] == 'Maladie' ? 't-maladie' : 't-annuel' ?>">
                            <?= esc($d['libelle']) ?>
                        </span>
                    </td>
                    <td class="mono" style="color: var(--muted); font-size: .82rem;">
                        Du <?= esc($d['date_debut']) ?> au <?= esc($d['date_fin']) ?>
                    </td>
                    <td style="text-align: right;">
                        <a href="<?= base_url('rh/valider/'.$d['id']) ?>" 
                           class="btn-sm" style="background: var(--success-bg); color: var(--success); border-color: var(--success-br)">
                            <i class="bi bi-check2"></i> Approuver
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>