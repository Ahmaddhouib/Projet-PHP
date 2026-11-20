  <?php // ===== Section "Historique des Participations" (vue randonneur) — acceptées ou refusées ===== ?>
  <div id="section-historique" class="content-section hidden">
    <div class="mb-6">
      <h2 class="sec-title">Historique des Participations</h2>
      <p class="sec-desc">Consultez vos participations acceptées et refusées.</p>
    </div>

    <div class="card">
      <div class="card-hdr">
        <h3 class="card-title">Participations</h3>
        <span class="result-count"><?php echo count($monHistorique); ?> participation(s)</span>
      </div>
      <div class="overflow-x-auto">
        <table class="tbl">
          <thead>
            <tr>
              <th>ID</th>
              <th>Randonnée</th>
              <th>Catégorie</th>
              <th>Région</th>
              <th>Date Début</th>
              <th>Date Fin</th>
              <th>Statut</th>
              <th>Date Demande</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($monHistorique)): ?>
            <tr><td colspan="8" class="text-center py-6 text-stone-400">Aucun historique.</td></tr>
            <?php else: ?>
            <?php // Parcours de l'historique : participations acceptées ou refusées ?>
            <?php foreach ($monHistorique as $h): ?>
            <tr>
              <td><?php echo $h['id_participation']; ?></td>
              <td><?php echo $h['titre_rando']; ?></td>
              <td>
                <?php
                // Conversion de la valeur stockée en BD en libellé lisible
                $cats = ['montagne'=>'Montagne','desert'=>'Désert','foret'=>'Forêt','bord_de_mer'=>'Bord de mer'];
                echo isset($cats[$h['categorie']]) ? $cats[$h['categorie']] : $h['categorie'];
                ?>
              </td>
              <td><?php echo $h['region']; ?></td>
              <td><?php echo date('d/m/Y', strtotime($h['date_debut'])); ?></td>
              <td><?php echo date('d/m/Y', strtotime($h['date_fin'])); ?></td>
              <td>
                <?php // Badge vert pour acceptée, rouge pour refusée ?>
                <?php echo $h['statut'] === 'acceptee'
                  ? '<span class="badge badge-green">Acceptée</span>'
                  : '<span class="badge badge-red">Refusée</span>'; ?>
              </td>
              <td><?php echo date('d/m/Y H:i', strtotime($h['date_creation'])); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <?php // État vide stylisé : icône + message si pas d'historique ?>
      <?php if (empty($monHistorique)): ?>
      <div class="empty-state">
        <span class="material-symbols-outlined">history_toggle_off</span>
        <p>Aucun historique de participation pour le moment.</p>
      </div>
      <?php endif; ?>
    </div>
  </div>
