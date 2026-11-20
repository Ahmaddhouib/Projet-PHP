  <?php // ===== Section "Gestion des Bus" (admin) ===== ?>
  <!-- hidden : par défaut cachée, le JS l'affichera si elle est sélectionnée -->
  <div id="section-bus" class="content-section hidden">
    <div class="sec-hdr">
      <div>
        <h2 class="sec-title">Gestion des Bus</h2>
        <p class="sec-desc">Créez, modifiez et supprimez les bus de transport.</p>
      </div>
      <!-- Lien "Nouveau Bus" : déclenche le modal en mode ajout -->
      <a href="controlAdmin.php?section=section-bus&new_bus=1" class="btn btn-primary">
        <span class="material-symbols-outlined text-[18px]">add</span>
        Nouveau Bus
      </a>
    </div>

    <div class="card">
      <div class="card-hdr">
        <h3 class="card-title">Liste des Bus</h3>
        <!-- count() compte le nombre de bus pour l'afficher comme badge -->
        <span class="result-count"><?php echo count($listeBus); ?> bus</span>
      </div>
      <div class="overflow-x-auto">
        <table class="tbl">
          <thead>
            <tr>
              <th>ID</th>
              <th>Immatriculation</th>
              <th>Nb. Places</th>
              <th>Chauffeur</th>
              <th>Tél. Chauffeur</th>
              <th class="tbl-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php // Cas où la liste est vide : message à la place du tableau ?>
            <?php if (empty($listeBus)): ?>
            <tr><td colspan="6" class="text-center py-6 text-stone-400">Aucun bus enregistré.</td></tr>
            <?php else: ?>
            <?php // Parcours du tableau des bus pour générer une ligne par bus ?>
            <?php foreach ($listeBus as $b): ?>
            <tr>
              <td><?php echo $b['id_bus']; ?></td>
              <td><?php echo $b['immat_bus']; ?></td>
              <td><?php echo $b['nb_places']; ?></td>
              <td><?php echo $b['chauffeur']; ?></td>
              <td><?php echo $b['tel_chauff']; ?></td>
              <td class="tbl-right">
                <div class="act-group">
                  <!-- Lien Modifier : ouvre le modal préchargé avec les infos du bus -->
                  <a href="controlAdmin.php?section=section-bus&edit_bus=<?php echo $b['id_bus']; ?>"
                     title="Modifier" class="act-btn">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                  </a>
                  <!-- Lien Supprimer : confirm() empêche les suppressions accidentelles -->
                  <a href="controlAdmin.php?section=section-bus&supprimer_bus=<?php echo $b['id_bus']; ?>"
                     title="Supprimer" class="act-btn act-del"
                     onclick="return confirm('Supprimer ce bus ?')">
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                  </a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <?php // Encart "vide" stylisé, affiché uniquement si aucun bus en BD ?>
      <?php if (empty($listeBus)): ?>
      <div class="empty-state">
        <span class="material-symbols-outlined">directions_bus</span>
        <p>Aucun bus enregistré. Créez-en un nouveau.</p>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <?php
  // Afficher le modal si on demande l'édition d'un bus existant ou la création d'un nouveau
  if (isset($busMod) || isset($_GET['new_bus'])):
    include 'modals/modal-bus.php';
  endif;
  ?>
