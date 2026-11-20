<!DOCTYPE html>
<!-- =====================================================================
     Vue principale de l'admin : assemble la sidebar + le contenu (4 sections)
     Chaque section est dans un fichier séparé pour faciliter la maintenance
     ===================================================================== -->
<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Nature's Breath - Admin Dashboard</title>
<!-- Polices Google + icônes Material -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Literata:ital,opsz,wght@0,6..72,200..900;1,6..72,200..900&amp;family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind CDN + configuration personnalisée -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script src="../js/tailwind-config-admin.js"></script>
<link rel="stylesheet" href="../css/dashboard.css"/>
</head>
<body class="bg-background text-on-surface flex min-h-screen" data-active-section="<?php echo htmlspecialchars($section); ?>">

<!-- Barre latérale gauche (navigation entre les 4 sections) -->
<aside class="sidebar">
  <div class="px-6 mb-10">
    <h2 class="brand brand-lg">Nature's Breath</h2>
    <p class="brand-sub">Admin Panel</p>
  </div>
  <!-- Liens de navigation : data-section indique la section à afficher (géré en JS) -->
  <nav id="sidebar-nav" class="flex-1 flex flex-col gap-1">
    <a class="nav-link" href="#" data-section="section-randonnees">
      <span class="material-symbols-outlined">hiking</span>
      <span>Gestion des Randonnées</span>
    </a>
    <a class="nav-link" href="#" data-section="section-bus">
      <span class="material-symbols-outlined">directions_bus</span>
      <span>Gestion des Bus</span>
    </a>
    <a class="nav-link" href="#" data-section="section-demandes">
      <span class="material-symbols-outlined">assignment_ind</span>
      <span>Demandes de Participation</span>
    </a>
    <a class="nav-link" href="#" data-section="section-participants">
      <span class="material-symbols-outlined">group</span>
      <span>Gestion des Participants</span>
    </a>
  </nav>
  <!-- Bouton de déconnexion (appelle logout.php qui détruit la session) -->
  <div class="mt-auto px-4">
    <a href="logout.php" class="btn-logout" style="display:flex;align-items:center;gap:0.5rem;text-decoration:none;">
      <span class="material-symbols-outlined">logout</span>
      <span>Déconnexion</span>
    </a>
  </div>
</aside>

<!-- Conteneur principal : header + contenu + footer -->
<div class="shell">
  <header class="topbar">
    <div class="flex items-center">
      <h1 class="brand brand-xl">Nature's Breath</h1>
    </div>
    <div style="font-size:0.875rem;color:var(--c-on-surface-variant);">
      <!-- Affichage de l'email connecté -->
      Connecté : <?php echo $email; ?>
    </div>
  </header>
  <main class="canvas">

    <?php // Inclusion des quatre sections de l'admin (une seule est visible à la fois) ?>
    <?php include 'sections/admin-randonnees.php'; ?>

    <?php include 'sections/admin-bus.php'; ?>

    <?php include 'sections/admin-demandes.php'; ?>

    <?php include 'sections/admin-participants.php'; ?>

  </main>
  <footer class="dash-footer">
    <div class="flex flex-col items-center gap-1">
      <span class="material-symbols-outlined footer-icon">landscape</span>
      <span class="footer-text">END OF PATH</span>
    </div>
  </footer>
</div>

<!-- Scripts de navigation entre sections (clic + section active au chargement) -->
<script src="../js/spa-navigation.js"></script>
<script src="../js/active-section.js"></script>
</body>
</html>
