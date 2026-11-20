  <?php // ===== Section "Mes Demandes" (vue randonneur) — uniquement les demandes en attente ===== ?>
  <div id="section-mes-demandes" class="content-section hidden">
    <div class="mb-6">
      <h2 class="sec-title">Mes Demandes</h2>
      <p class="sec-desc">Suivez l'état de vos demandes de participation.</p>
    </div>

    <div class="card">
      <div class="card-hdr">
        <h3 class="card-title">Participations en attente</h3>
        <span class="result-count"><?php echo count($mesDemandesEnAttente); ?> demande(s)</span>
      </div>
      <div class="overflow-x-auto">
        <table class="tbl">
          <thead>
            <tr>
              <th>ID</th>
              <th>Randonnée</th>
              <th>Région</th>
              <th>Date Début</th>
              <th>Date Fin</th>
              <th>Statut</th>
              <th>Date Demande</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($mesDemandesEnAttente)): ?>
            <tr><td colspan="7" class="text-center py-6 text-stone-400">Aucune demande en attente.</td></tr>
            <?php else: ?>
            <?php // Parcours des demandes encore en attente de validation par l'admin ?>
            <?php foreach ($mesDemandesEnAttente as $d): ?>
            <tr>
              <td><?php echo $d['id_participation']; ?></td>
              <td><?php echo $d['titre_rando']; ?></td>
              <td><?php echo $d['region']; ?></td>
              <td><?php echo date('d/m/Y', strtotime($d['date_debut'])); ?></td>
              <td><?php echo date('d/m/Y', strtotime($d['date_fin'])); ?></td>
              <td><span class="badge badge-yellow">En attente</span></td>
              <td><?php echo date('d/m/Y H:i', strtotime($d['date_creation'])); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <?php // État vide stylisé : icône + message si pas de demandes ?>
      <?php if (empty($mesDemandesEnAttente)): ?>
      <div class="empty-state">
        <span class="material-symbols-outlined">inbox</span>
        <p>Aucune demande en attente pour le moment.</p>
      </div>
      <?php endif; ?>
    </div>
  </div>
