  <?php // ===== Section "Gestion des Randonnées" (admin) ===== ?>
  <div id="section-randonnees" class="content-section">
    <div class="sec-hdr">
      <div>
        <h2 class="sec-title">Gestion des Randonnées</h2>
        <p class="sec-desc">Créez, modifiez, supprimez et recherchez des randonnées.</p>
      </div>
      <!-- Bouton "Nouvelle Randonnée" : ajoute new_rando=1 dans l'URL pour déclencher le modal en mode ajout -->
      <a href="controlAdmin.php?section=section-randonnees&new_rando=1" class="btn btn-primary">
        <span class="material-symbols-outlined text-[18px]">add</span>
        Nouvelle Randonnée
      </a>
    </div>

    <?php
    // Le panneau de filtres est partagé entre admin et user :
    //   - $filterAction : page cible du formulaire de filtres
    //   - $filterPrefix : préfixe pour différencier les noms (vide ici)
    $filterAction = 'controlAdmin.php';
    $filterPrefix = '';
    include 'filtre-recherche.php';
    ?>

    <?php // Inclusion du tableau listant toutes les randonnées ?>
    <?php include 'admin-table-randonnees.php'; ?>
  </div>

  <?php
  // Affiche le modal d'édition / ajout :
  //   - si $randoMod est défini  -> mode modification (préremplie)
  //   - sinon si new_rando=1 dans l'URL -> mode ajout (champs vides)
  if (isset($randoMod) || isset($_GET['new_rando'])):
    include 'modals/modal-rando.php';
  endif;
  ?>
