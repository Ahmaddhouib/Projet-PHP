  <?php // ===== Section "Demandes de Participation" (admin) ===== ?>
  <div id="section-demandes" class="content-section hidden">
    <div class="sec-hdr">
      <div>
        <h2 class="sec-title">Demandes de Participation</h2>
        <p class="sec-desc">Examinez et validez les demandes d'inscription aux randonnées.</p>
      </div>
    </div>

    <!-- Premier bloc : uniquement les demandes en attente -->
    <div class="card">
      <div class="card-hdr">
        <h3 class="card-title">Demandes en attente</h3>
        <span class="result-count"><?php echo count($demandesEnAttente); ?> demande(s)</span>
      </div>
      <div class="overflow-x-auto">
        <table class="tbl">
          <thead>
            <tr>
              <th>ID</th>
              <th>Randonneur</th>
              <th>Randonnée</th>
              <th>Statut</th>
              <th>Date Demande</th>
              <th class="tbl-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($demandesEnAttente)): ?>
            <tr><td colspan="6" class="text-center py-6 text-stone-400">Aucune demande en attente.</td></tr>
            <?php else: ?>
            <?php // Affichage de chaque demande en attente avec boutons Accepter / Refuser ?>
            <?php foreach ($demandesEnAttente as $d): ?>
            <tr>
              <td><?php echo $d['id_participation']; ?></td>
              <td><?php echo $d['nom_user']; ?></td>
              <td><?php echo $d['titre_rando']; ?></td>
              <td><span class="badge badge-yellow">En attente</span></td>
              <?php // strtotime() convertit la date MySQL en timestamp pour la formater en jj/mm/aaaa ?>
              <td><?php echo date('d/m/Y H:i', strtotime($d['date_creation'])); ?></td>
              <td class="tbl-right">
                <div class="act-group">
                  <!-- Mini formulaire avec deux boutons : Accepter ou Refuser -->
                  <form method="post" action="controlAdmin.php" style="display:inline;">
                    <input type="hidden" name="id_participation" value="<?php echo $d['id_participation']; ?>">
                    <input type="hidden" name="section_active" value="section-demandes">
                    <button name="accepter" value="1" class="btn btn-primary btn-sm" title="Accepter">
                      <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    </button>
                    <button name="refuser" value="1" class="btn btn-ghost btn-sm" title="Refuser">
                      <span class="material-symbols-outlined text-[16px]">cancel</span>
                    </button>
                  </form>
                  <!-- Suppression définitive (en plus de Accepter/Refuser) -->
                  <a href="controlAdmin.php?section=section-demandes&supprimer_part=<?php echo $d['id_participation']; ?>"
                     class="act-btn act-del" title="Supprimer"
                     onclick="return true">
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
    </div>

    <!-- Second bloc : toutes les participations (acceptées, refusées, en attente) -->
    <div class="card" style="margin-top:1.5rem;">
      <div class="card-hdr">
        <h3 class="card-title">Toutes les participations</h3>
        <span class="result-count"><?php echo count($toutesParticipations); ?> participation(s)</span>
      </div>

      <div class="overflow-x-auto">
        <table class="tbl">
          <thead>
            <tr>
              <th>ID</th>
              <th>Randonneur</th>
              <th>Randonnée</th>
              <th>Statut</th>
              <th>Date</th>
              <th class="tbl-right">Supprimer</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($toutesParticipations)): ?>
            <tr><td colspan="6" class="text-center py-6 text-stone-400">Aucune participation.</td></tr>
            <?php else: ?>
            <?php foreach ($toutesParticipations as $p): ?>
            <tr>
              <td><?php echo $p['id_participation']; ?></td>
              <td><?php echo htmlspecialchars($p['nom_user']); ?></td>
              <td><?php echo htmlspecialchars($p['titre_rando']); ?></td>
              <td>
                <?php
                // Couleur et libellé du badge selon le statut de la participation
                // Tableaux associatifs : statut -> classe CSS et statut -> libellé FR
                $badgeMap = ['en_attente'=>'badge-yellow','acceptee'=>'badge-green','refusee'=>'badge-red'];
                $labelMap = ['en_attente'=>'En attente','acceptee'=>'Acceptée','refusee'=>'Refusée'];
                // Garde-fou : si le statut n'est pas reconnu, on utilise une classe neutre
                $cls = isset($badgeMap[$p['statut']]) ? $badgeMap[$p['statut']] : 'badge-muted';
                // var_dump($p['statut']);
                echo '<span class="badge '.$cls.'">'.$labelMap[$p['statut']].'</span>';
                ?>
              </td>
              <td><?php echo date('d/m/Y H:i', strtotime($p['date_creation'])); ?></td>
              <td class="tbl-right">
                <a href="controlAdmin.php?section=section-demandes&supprimer_part=<?php echo $p['id_participation']; ?>"
                   class="act-btn act-del" title="Supprimer"
                   onclick="return confirm('Supprimer cette participation ?')">
                  <span class="material-symbols-outlined text-[18px]">delete</span>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
