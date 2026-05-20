<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="data-card mb-4">
    <div class="data-card-head" style="background: var(--ink); color: var(--white); border-bottom: none;">
        <h3 style="color: var(--white); margin: 0; font-size: 0.95rem;">
            <i class="bi bi-pie-chart-fill me-2" style="color: var(--mint);"></i> 
            Mes Droits & Soldes Disponibles — Année En Cours
        </h3>
    </div>
    <div class="p-3" style="background: var(--white);">
        <div class="row g-3">
            <?php if (empty($mes_soldes)): ?>
                <div class="col-12 text-center text-muted py-3">
                    <i class="bi bi-exclamation-circle d-block mb-1" style="font-size: 1.2rem;"></i> 
                    Aucun droit aux congés n'a été initialisé pour votre compte.
                </div>
            <?php else: ?>
                <?php foreach ($mes_soldes as $solde): ?>
                    <div class="col-md-6">
                        <div class="p-3 border rounded d-flex justify-content-between align-items-center" style="background: var(--cream); border-color: var(--border) !important;">
                            <div>
                                <span class="type-badge <?= $solde['type_conge_id'] == 2 ? 't-maladie' : 't-annuel' ?>" style="font-size: 0.72rem; display: inline-block; margin-bottom: 6px;">
                                    <?= $solde['type_conge_id'] == 2 ? 'Congé Maladie' : 'Congé Annuel' ?>
                                </span>
                                <div style="font-size: .75rem; color: var(--muted);">
                                    Attribués : <strong style="color: var(--ink);"><?= $solde['jours_attribues'] ?> j</strong> · 
                                    Pris : <strong style="color: var(--ink);"><?= $solde['jours_pris'] ?> j</strong>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="mono" style="font-size: 1.8rem; font-weight: 700; color: var(--forest); line-height: 1; display: block;">
                                    <?= $solde['restant'] ?>
                                </span>
                                <span style="font-size: .68rem; text-transform: uppercase; color: var(--muted); letter-spacing: 0.05em; font-weight: 500;">jours restants</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-8">
        <div class="data-card">
            <div class="data-card-head">
                <h3>Mes demandes récentes</h3>
            </div>
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Date de Début</th>
                        <th>Date de Fin</th>
                        <th>Statut de l'instruction</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($mes_conges)): ?>
                        <tr>
                            <td colspan="3" style="text-align: center; color: var(--muted); padding: 2rem;">
                                <i class="bi bi-calendar-x" style="font-size: 1.5rem; display:block; margin-bottom: 5px;"></i>
                                Aucune demande enregistrée à ce jour.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($mes_conges as $c): ?>
                        <tr>
                            <td class="mono"><?= esc($c['date_debut']) ?></td>
                            <td class="mono"><?= esc($c['date_fin']) ?></td>
                            <td>
                                <span class="statut <?= $c['statut'] == 'approuvee' ? 's-approuvee' : ($c['statut'] == 'refusee' ? 's-refusee' : 's-attente') ?>">
                                    <?= esc($c['statut']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-section">
            <h3 style="margin-bottom: 1.25rem;">Nouveau congé</h3>
            <form action="<?= base_url('employer/demande') ?>" method="post">
                <div class="mb-3">
                    <label class="f-label">Nature du congé</label>
                    <select name="type_id" class="f-select">
                        <option value="1">Congé Annuel</option>
                        <option value="2">Absence Maladie</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="f-label">Premier jour d'absence</label>
                    <input type="date" name="date_debut" class="f-input" required>
                </div>
                <div class="mb-4">
                    <label class="f-label">Dernier jour d'absence</label>
                    <input type="date" name="date_fin" class="f-input" required>
                </div>
                <button type="submit" class="btn-forest w-100" style="justify-content: center;">
                    <i class="bi bi-send"></i> Soumettre la demande
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>