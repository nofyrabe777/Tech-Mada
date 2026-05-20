<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<script src="<?= base_url('assets/js/chart.js') ?>"></script>

<div class="row g-3 mb-4">
    <div class="col-md-5">
        <div class="data-card p-3">
            <h3><i class="bi bi-pie-chart-fill me-2" style="color: var(--forest);"></i> Demandes par Type (Camembert)</h3>
            <div style="position: relative; height:200px; display:flex; justify-content:center;">
                <canvas id="camembertType"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="data-card p-3">
            <h3><i class="bi bi-calendar-week me-2" style="color: var(--leaf);"></i> Flux des départs par jour de la semaine</h3>
            <div style="position: relative; height:200px;">
                <canvas id="barJours"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="data-card">
    <div class="data-card-head">
        <h3><i class="bi bi-card-checklist me-2"></i> Arbitrage des demandes de congés</h3>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>Collaborateur</th>
                <th>Type</th>
                <th>Période</th>
                <th>Jours</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($demandes)): ?>
                <tr><td colspan="5" class="text-center text-muted py-3">Aucun dossier en attente.</td></tr>
            <?php else: ?>
                <?php foreach($demandes as $d): ?>
                    <tr>
                        <td><strong><?= esc($d['nom']) ?></strong> <?= esc($d['prenom']) ?></td>
                        <td><span class="type-badge <?= $d['type_conge_id'] == 2 ? 't-maladie' : 't-annuel' ?>"><?= esc($d['libelle']) ?></span></td>
                        <td>Du <?= date('d/m/Y', strtotime($d['date_debut'])) ?> au <?= date('d/m/Y', strtotime($d['date_fin'])) ?></td>
                        <td class="mono fw-bold"><?= $d['nb_jours'] ?> j</td>
                        <td>
                            <a href="<?= base_url('rh/valider/'.$d['id']) ?>" class="btn-sm btn-forest" style="background:var(--success);"><i class="bi bi-check"></i></a>
                            <a href="<?= base_url('rh/refuser/'.$d['id']) ?>" class="btn-sm" style="background:var(--danger-bg); color:var(--danger); border:1px solid var(--danger-br);"><i class="bi bi-x"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // ═══════════════════════════════════════════
    // GRAPHIC 1 : LE CAMEMBERT (Répartition des types de congés)
    // ═══════════════════════════════════════════
    const ctxPie = document.getElementById('camembertType');
    if (ctxPie) {
        new Chart(ctxPie.getContext('2d'), {
            type: 'pie', // Déclare le mode Camembert
            data: {
                // Récupère les libellés générés par le contrôleur (ex: ['Congé Annuel', 'Congé Maladie'])
                labels: <?= json_encode($camembert_labels ?? ['Aucun']) ?>,
                datasets: [{
                    // Récupère les nombres associés (ex: [12, 4])
                    data: <?= json_encode($camembert_values ?? [0]) ?>,
                    backgroundColor: ['#2d5a3d', '#1a4f7a', '#b8750a'], // Palette Forest, Info, Warn
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom', // Place la légende sous le camembert
                        labels: { boxWidth: 12, font: { family: 'DM Sans' } }
                    }
                }
            }
        });
    }

    // ═══════════════════════════════════════════
    // GRAPHIC 2 : L'HISTOGRAMME (Flux des jours de la semaine)
    // ═══════════════════════════════════════════
    const ctxBar = document.getElementById('barJours');
    if (ctxBar) {
        new Chart(ctxBar.getContext('2d'), {
            type: 'bar', // Déclare le mode histogramme en bâtons
            data: {
                labels: ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'],
                datasets: [{
                    label: 'Nombre de départs en congé',
                    data: <?= json_encode($stats_jours ?? [0, 0, 0, 0, 0]) ?>,
                    backgroundColor: '#5fa876', // Couleur de la feuille (Leaf TechMada)
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }, // Masque la légende inutile ici
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, color: '#7a8f80' }, // Force des sauts de 1 en 1 (pas de 1.5 congé)
                        grid: { color: '#dde8e1' }
                    },
                    x: {
                        ticks: { color: '#7a8f80' },
                        grid: { display: false } // Évite d'encombrer le graphique
                    }
                }
            }
        });
    }
});
</script>

<?= $this->endSection() ?>