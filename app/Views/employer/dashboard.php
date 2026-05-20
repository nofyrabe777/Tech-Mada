<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<link href="<?= base_url('assets/css/fullcalendar.css') ?>" rel="stylesheet">
<script src="<?= base_url('assets/js/fullcalendar.js') ?>"></script>

<div class="data-card mb-4">
    <div class="data-card-head" style="background: var(--ink); color: var(--white); border-bottom: none;">
        <h3 style="color: var(--white); margin: 0;"><i class="bi bi-pie-chart-fill me-2" style="color: var(--mint);"></i> Mon Solde de Congés</h3>
    </div>
    <div class="p-3" style="background: var(--white);">
        <div class="row g-3">
            <?php if (empty($mes_soldes)): ?>
                <div class="col-12 text-center text-muted py-2">Aucun droit initialisé pour cette année.</div>
            <?php else: ?>
                <?php foreach ($mes_soldes as $solde): ?>
                    <div class="col-md-6">
                        <div class="p-3 border rounded d-flex justify-content-between align-items-center" style="background: var(--cream); border-color: var(--border) !important;">
                            <div>
                                <span class="type-badge <?= $solde['type_conge_id'] == 2 ? 't-maladie' : 't-annuel' ?>">
                                    <?= $solde['type_conge_id'] == 2 ? 'Congé Maladie' : 'Congé Annuel' ?>
                                </span>
                                <div style="font-size: .75rem; color: var(--muted); margin-top: 5px;">
                                    Attribués : <strong><?= $solde['jours_attribues'] ?> j</strong> · Pris : <strong><?= $solde['jours_pris'] ?> j</strong>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="mono" style="font-size: 1.8rem; font-weight: 700; color: var(--forest); line-height: 1; display: block;"><?= $solde['restant'] ?></span>
                                <span style="font-size: .65rem; text-transform: uppercase; color: var(--muted);">jours restants</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="data-card">
            <div class="data-card-head">
                <h3><i class="bi bi-clock-history me-2"></i> Historique de mes demandes</h3>
            </div>
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Période</th>
                        <th>Type</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($mes_conges)): ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">Aucune demande de congé enregistrée pour le moment.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($mes_conges as $conge): ?>
                            <tr>
                                <td>Du <?= date('d/m', strtotime($conge['date_debut'])) ?> au <?= date('d/m', strtotime($conge['date_fin'])) ?></td>
                                <td><span class="type-badge <?= $conge['type_conge_id'] == 2 ? 't-maladie' : 't-annuel' ?>"><?= $conge['type_conge_id'] == 2 ? 'Maladie' : 'Annuel' ?></span></td>
                                <td><span class="statut <?= $conge['statut'] == 'approuvee' ? 's-approuvee' : ($conge['statut'] == 'refusee' ? 's-refusee' : 's-attente') ?>"><?= esc($conge['statut']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-section">
            <h3><i class="bi bi-calendar-plus me-2"></i> Nouvelle Demande</h3>
            
            <div id="calendar" class="mb-3" style="background:#fff; padding:10px; border-radius:8px; border:1px solid var(--border); min-height: 250px;"></div>
            
            <form action="<?= base_url('employer/demande') ?>" method="post">
                <div class="mb-2">
                    <label class="f-label">Type de congé</label>
                    <select name="type_conge_id" class="f-select" required>
                        <option value="1">Congé Annuel</option>
                        <option value="2">Congé Maladie</option>
                    </select>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="f-label">Date Début</label>
                        <input type="date" name="date_debut" id="start_date" class="f-input" required>
                    </div>
                    <div class="col-6">
                        <label class="f-label">Date Fin</label>
                        <input type="date" name="date_fin" id="end_date" class="f-input" required>
                    </div>
                </div>
                <button type="submit" class="btn-forest w-100" style="justify-content:center;"><i class="bi bi-send"></i> Envoyer la demande</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Diagnostic de sécurité hors-ligne : vérifie si le fichier JS est bien chargé
    if (typeof FullCalendar === 'undefined') {
        console.error("Erreur : Le fichier public/assets/js/fullcalendar.js est introuvable ou mal chargé.");
        document.getElementById('calendar').innerHTML = "<div class='text-danger p-2'><i class='bi bi-exclamation-triangle'></i> Impossible de charger le calendrier hors-ligne (Fichier JS manquant dans assets/js/).</div>";
        return;
    }

    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            selectable: true,
            headerToolbar: { 
                left: 'prev,next', 
                center: 'title', 
                right: '' 
            },
            // Injection sécurisée des événements
            events: [
                <?php if (!empty($mes_conges)): ?>
                    <?php foreach($mes_conges as $conge): ?>
                    {
                        title: '<?= $conge['type_conge_id'] == 2 ? "Maladie" : "Annuel" ?>',
                        start: '<?= $conge['date_debut'] ?>',
                        end: '<?= date('Y-m-d', strtotime($conge['date_fin'] . ' +1 day')) ?>',
                        backgroundColor: '<?= $conge['statut'] == "approuvee" ? "#2d5a3d" : ($conge['statut'] == "refusee" ? "#c0392b" : "#b8750a") ?>',
                        borderColor: 'transparent'
                    },
                    <?php endforeach; ?>
                <?php endif; ?>
            ],
            select: function(info) {
                let endDate = new Date(info.endStr);
                endDate.setDate(endDate.getDate() - 1);
                let formattedEndDate = endDate.toISOString().split('T')[0];

                // Remplit automatiquement les champs sans bloquer la saisie manuelle
                document.getElementById('start_date').value = info.startStr;
                document.getElementById('end_date').value = formattedEndDate;
            }
        });
        calendar.render();
    }
});
</script>

<?= $this->endSection() ?>