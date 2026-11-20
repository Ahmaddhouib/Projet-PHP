  <?php // ===== Section "Randonnées Disponibles" (vue randonneur) ===== ?>
  <div id="section-randonnees" class="content-section">
    <div class="sec-hdr">
      <div>
        <h2 class="sec-title">Randonnées Disponibles</h2>
        <p class="sec-desc">Consultez, recherchez et participez aux randonnées.</p>
      </div>
    </div>

    <?php
    // Le panneau de filtres est partagé entre admin et user :
    // ici on cible controlUser.php au lieu de controlAdmin.php
    $filterAction = 'controlUser.php';
    $filterPrefix = 'ran-';
    include 'filtre-recherche.php';
    ?>

    <?php // Tableau listant les randonnées avec un bouton "Participer" ?>
    <?php include 'randonneur-table-randonnees.php'; ?>
  </div>
