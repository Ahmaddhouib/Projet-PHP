<!DOCTYPE html>
<!-- =====================================================================
     Vue principale du randonneur (utilisateur classique)
     Trois sections : voir les randonnées, ses demandes en attente, son historique
     ===================================================================== -->
<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Nature's Breath - Espace Randonneur</title>
<!-- Polices et icônes Material -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Literata:ital,opsz,wght@0,6..72,200..900;1,6..72,200..900&amp;family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script src="../js/tailwind-config-admin.js"></script>
<link rel="stylesheet" href="../css/dashboard.css"/>
</head>
<!-- data-active-section : récupéré côté JS (active-section.js) pour afficher la bonne section au chargement -->
<body class="bg-background text-on-surface flex min-h-screen" data-active-section="<?php echo htmlspecialchars($section); ?>">

<!-- Barre latérale : navigation entre les 3 sections -->
<aside class="sidebar">
  <div class="px-6 mb-10">
    <h2 class="brand brand-lg">Nature's Breath</h2>
    <p class="brand-sub">Espace Randonneur</p>
  </div>
  <nav id="sidebar-nav" class="flex-1 flex flex-col gap-1">
    <a class="nav-link" href="#" data-section="section-randonnees">
      <span class="material-symbols-outlined">hiking</span>
      <span>Randonnées</span>
    </a>
    <a class="nav-link" href="#" data-section="section-mes-demandes">
      <span class="material-symbols-outlined">pending_actions</span>
      <span>Mes Demandes</span>
    </a>
    <a class="nav-link" href="#" data-section="section-historique">
      <span class="material-symbols-outlined">history</span>
      <span>Historique</span>
    </a>
  </nav>
  <!-- Bouton de déconnexion -->
  <div class="mt-auto px-4">
    <a href="logout.php" class="btn-logout" style="display:flex;align-items:center;gap:0.5rem;text-decoration:none;">
      <span class="material-symbols-outlined">logout</span>
      <span>Déconnexion</span>
    </a>
  </div>
</aside>

<!-- Conteneur principal -->
<div class="shell">
  <header class="topbar">
    <div class="flex items-center">
      <h1 class="brand brand-xl">Nature's Breath</h1>
    </div>
    <div style="font-size:0.875rem;color:var(--c-on-surface-variant);">
      <!-- Affichage de l'email connecté ) -->
      Connecté : <?php echo $email; ?>
    </div>
  </header>
  <main class="canvas">

    <?php // Inclusion des trois sections du randonneur (une seule est visible à la fois) ?>
    <?php include 'sections/randonneur-randonnees.php'; ?>

    <?php include 'sections/randonneur-demandes.php'; ?>

    <?php include 'sections/randonneur-historique.php'; ?>

  </main>
  <footer class="dash-footer">
    <div class="flex flex-col items-center gap-1">
      <span class="material-symbols-outlined footer-icon">landscape</span>
      <span class="footer-text">END OF PATH</span>
    </div>
  </footer>
</div>


<!-- Scripts JS pour la navigation entre sections -->
<script src="../js/spa-navigation.js"></script>
<script src="../js/active-section.js"></script>
</body>
</html>
