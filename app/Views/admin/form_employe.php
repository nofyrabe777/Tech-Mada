<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="form-section">
    <h3>Ajouter un nouvel employé</h3>

    <form action="<?= base_url('admin/save') ?>" method="post" class="mt-2">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="f-label">Nom</label>
                <input type="text" name="nom" class="f-input" required placeholder="Ex: RAKOTO">
            </div>
            <div class="col-md-6 mb-3">
                <label class="f-label">Prénom</label>
                <input type="text" name="prenom" class="f-input" required placeholder="Ex: Soa">
            </div>
        </div>

        <div class="mb-3">
            <label class="f-label">Adresse Email</label>
            <input type="email" name="email" class="f-input" required placeholder="soa@techmada.mg">
        </div>

        <div class="mb-3">
            <label class="f-label">Mot de passe temporaire</label>
            <input type="password" name="password" class="f-input" required placeholder="••••••••">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="f-label">Rôle au sein de la structure</label>
                <select name="role" class="f-select">
                    <option value="employe">Employé</option>
                    <option value="rh">Responsable RH</option>
                    <option value="admin">Administrateur</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="f-label">Département affecté</label>
                <select name="departement_id" class="f-select">
                    <?php foreach($departements as $dep): ?>
                        <option value="<?= $dep['id'] ?>"><?= esc($dep['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mb-4">
            <label class="f-label">Date d'embauche effective</label>
            <input type="date" name="date_embauche" class="f-input" value="<?= date('Y-m-d') ?>">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-forest">
                <i class="bi bi-check-lg"></i> Enregistrer le collaborateur
            </button>
            <a href="<?= base_url('admin/utilisateurs') ?>" class="btn-secondary">Annuler</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>