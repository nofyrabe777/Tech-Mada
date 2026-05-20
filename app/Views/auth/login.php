<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>Connexion — TechMada RH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <style>
        :root{
            --ink: #1c2b1e; --forest: #2d5a3d; --forest2: #3d7a52; --leaf: #5fa876;
            --mint: #d4ede0; --cream: #f8f6f1; --white: #ffffff; --border: #dde8e1;
            --muted: #7a8f80; --danger: #c0392b; --danger-bg:#fdf0ee; --danger-br:#f0b8b2;
        }
        body{font-family:'DM Sans',sans-serif;background:var(--cream);color:var(--ink);margin:0}
        h3, .auth-title{font-family:'Playfair Display',serif}
        
        .geo-bg{ position:relative; overflow:hidden; }
        .geo-bg::before{
            content:''; position:absolute; inset:0;
            background-image: repeating-linear-gradient(0deg,transparent,transparent 39px,rgba(255,255,255,.03) 40px), repeating-linear-gradient(90deg,transparent,transparent 39px,rgba(255,255,255,.03) 40px);
            pointer-events:none; z-index:0;
        }
        .auth-page{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem;background:var(--ink)}
        .auth-split{display:grid;grid-template-columns:1fr 420px;max-width:900px;width:100%;border-radius:16px;overflow:hidden;background:var(--white);box-shadow:0 10px 30px rgba(0,0,0,0.15)}
        .auth-left{background:var(--forest);padding:3rem;display:flex;flex-direction:column;justify-content:space-between}
        .auth-left-brand{font-family:'Playfair Display',serif;font-size:1.6rem;color:var(--white);margin:0}
        .auth-left-brand span{display:block;font-size:.85rem;font-weight:300;font-family:'DM Sans',sans-serif;color:rgba(255,255,255,.5);margin-top:4px}
        .auth-left-text{color:rgba(255,255,255,.6);font-size:.875rem;line-height:1.7}
        .auth-left-text strong{color:var(--white);display:block;font-size:1.25rem;font-family:'Playfair Display',serif;margin-bottom:.5rem}
        .auth-right{padding:2.5rem;display:flex;flex-direction:column;justify-content:center}
        .auth-title{font-size:1.3rem;font-weight:700;margin:0 0 .25rem}
        .auth-sub{font-size:.85rem;color:var(--muted);margin:0 0 1.75rem}
        
        .f-group{margin-bottom:1.25rem}
        .f-label{font-size:.8rem;font-weight:500;color:var(--ink);margin-bottom:5px;display:block}
        .f-input{width:100%;border:1.5px solid var(--border);border-radius:8px;padding:10px 12px;font-size:.875rem}
        .f-input:focus{border-color:var(--forest);outline:none;box-shadow:0 0 0 3px rgba(45,90,61,.1)}
        .btn-primary{background:var(--forest);color:var(--white);border:none;border-radius:8px;padding:11px 20px;font-weight:500;font-size:.9rem;width:100%;transition:background .15s}
        .btn-primary:hover{background:var(--forest2)}
        .flash-error{background:var(--danger-bg);color:var(--danger);border:1px solid var(--danger-br);padding:10px;border-radius:8px;font-size:.85rem;margin-bottom:1rem;display:flex;align-items:center;gap:8px}
        @media(max-width:768px){.auth-split{grid-template-columns:1fr}.auth-left{display:none}}
    </style>
</head>
<body>

<div class="auth-page geo-bg">
    <div class="auth-split">
        <div class="auth-left">
            <div>
                <p class="auth-left-brand">TechMada RH<span>Espace Intranet</span></p>
                <p class="auth-left-text" style="margin-top:2.5rem">
                    <strong>Gestion Simplifiée des Congés.</strong>
                    Suivez vos soldes, déposez vos demandes et accédez à vos outils internes en quelques clics.
                </p>
            </div>
            <div style="font-size:.7rem; color:rgba(255,255,255,0.3)">© 2026 TechMada Corporation</div>
        </div>

        <div class="auth-right">
            <p class="auth-title">Connexion</p>
            <p class="auth-sub">Entrez vos accès pour ouvrir votre session.</p>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="flash-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('attemptLogin') ?>" method="post">
                <div class="f-group">
                    <label class="f-label">Adresse email</label>
                    <input type="email" name="email" class="f-input" placeholder="nom@techmada.mg" required>
                </div>
                <div class="f-group">
                    <label class="f-label">Mot de passe</label>
                    <input type="password" name="password" class="f-input" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-primary" style="margin-top:.5rem">
                    Se connecter <i class="bi bi-arrow-right-short"></i>
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>