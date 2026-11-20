    <?php // Tableau des randonnées proposées au randonneur, avec bouton "Participer" ?>
    <div class="card">
      <div class="card-hdr">
        <h3 class="card-title">Liste des Randonnées</h3>
        <span class="result-count"><?php echo count($listeRandonnees); ?> randonnée(s)</span>
      </div>
      <div class="overflow-x-auto">
        <table class="tbl">
          <thead>
            <tr>
              <th>ID</th>
              <th>Titre</th>
              <th>Description</th>
              <th>Catégorie</th>
              <th>Date Début</th>
              <th>Date Fin</th>
              <th>Région</th>
              <th>Distance</th>
              <th>Difficulté</th>
              <th>Capacité</th>
              <th>Photo</th>
              <th>Statut</th>
              <th>Prix</th>
              <th class="tbl-right">Participer</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($listeRandonnees)): ?>
            <tr><td colspan="14" class="text-center py-6 text-stone-400">Aucune randonnée disponible.</td></tr>
            <?php else: ?>
            <?php // Affichage de chaque randonnée disponible avec un bouton « Participer » ?>
            <?php foreach ($listeRandonnees as $r): ?>
            <tr>
              <td><?php echo $r['id_randonnee']; ?></td>
              <td><?php echo $r['titre']; ?></td>
              <td style="max-width:240px;white-space:normal;"><?php echo $r['description']; ?></td>
              <td>
                <?php
                // Conversion de la valeur stockée en BD en libellé lisible
                $cats = ['montagne'=>'Montagne','desert'=>'Désert','foret'=>'Forêt','bord_de_mer'=>'Bord de mer'];
                echo isset($cats[$r['categorie']]) ? $cats[$r['categorie']] : $r['categorie'];
                ?>
              </td>
              <td><?php echo date('d/m/Y H:i', strtotime($r['date_debut'])); ?></td>
              <td><?php echo date('d/m/Y H:i', strtotime($r['date_fin'])); ?></td>
              <td><?php echo $r['region']; ?></td>
              <td><?php echo $r['distance']; ?> km</td>
              <td>
                <?php
                // Tableau associatif difficulté -> classe CSS du badge
                $diffClass = ['facile'=>'badge-green','moyen'=>'badge-yellow','difficile'=>'badge-red'];
                $cls = isset($diffClass[$r['difficulte']]) ? $diffClass[$r['difficulte']] : 'badge-muted';
                echo '<span class="badge '.$cls.'">'.ucfirst($r['difficulte']).'</span>';
                ?>
              </td>
              <td><?php echo $r['capacite']; ?></td>
              <td>
                <?php
                //Si la photo existe on l'affiche, sinon « Pas de photo »
                $photoPath = "../Randonnée-photo/" . $r['image'];
                $photoHtml = (!empty($r['image']) && file_exists($photoPath))
                    ? "<img src='$photoPath' width='50' height='50' style='object-fit:cover;border-radius:4px;' alt='photo'>"
                    : "Pas de photo";
                echo $photoHtml;
                ?>
              </td>
              <td>
                <?php // Statut visuel coloré (vert si encore disponible) ?>
                <?php echo $r['statut'] === 'en_cours'
                  ? '<span class="badge badge-green">En cours</span>'
                  : '<span class="badge badge-muted">Terminée</span>'; ?>
              </td>
              <td><?php echo number_format($r['prix'], 2, ',', ' '); ?> TND</td>
              <td class="tbl-right">
                <?php // Le bouton « Participer » n'apparaît que pour les randonnées en cours ?>
                <?php if ($r['statut'] === 'en_cours'): ?>
                <!-- Formulaire POST envoyé à controlUser.php : déclenche envoyer_demande -->
                <form method="post" action="controlUser.php" style="display:inline;">
                  <input type="hidden" name="envoyer_demande">
                  <input type="hidden" name="id_randonnee" value="<?php echo $r['id_randonnee']; ?>">
                  <button type="submit" class="act-btn act-join" title="Participer">
                    <span class="material-symbols-outlined text-[18px]">how_to_reg</span>
                  </button>
                </form>
                <?php else: ?>
                <!-- Pour les randonnées terminées : pas de bouton, juste un texte gris -->
                <span class="text-stone-400 text-sm">Terminée</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <?php // État vide stylisé : icône + message si aucune rando ne correspond aux filtres ?>
      <?php if (empty($listeRandonnees)): ?>
      <div class="empty-state">
        <span class="material-symbols-outlined">search_off</span>
        <p>Aucune randonnée trouvée. Modifiez vos filtres.</p>
      </div>
      <?php endif; ?>
    </div>
