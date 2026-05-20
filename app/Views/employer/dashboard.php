<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

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