    <?php // Tableau récapitulatif des randonnées (utilisé dans la section admin-randonnees) ?>
    <div class="card">
      <div class="card-hdr">
        <h3 class="card-title">Liste des Randonnées</h3>
        <span class="result-count"><?php echo count($listeRandonnees); ?> randonnée(s)</span>
      </div>
      <div class="overflow-x-auto">
        <table class="tbl" id="rando-table">
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
              <th>Bus</th>
              <th>Statut</th>
              <th>Prix</th>
              <th class="tbl-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($listeRandonnees)): ?>
            <tr><td colspan="15" class="text-center py-6 text-stone-400">Aucune randonnée trouvée.</td></tr>
            <?php else: ?>
            <?php // Parcours du tableau des randonnées récupéré dans le contrôleur ?>
            <?php foreach ($listeRandonnees as $r): ?>
            <tr>
              <td><?php echo $r['id_randonnee']; ?></td>
              <td><?php echo $r['titre']; ?></td>
              <td style="max-width:240px;white-space:normal;"><?php echo $r['description']; ?></td>
              <td>
                <?php
                // Conversion de la valeur stockée en BD (clé) en libellé lisible (valeur)
                $cats = ['montagne'=>'Montagne','desert'=>'Désert','foret'=>'Forêt','bord_de_mer'=>'Bord de mer'];
                echo isset($cats[$r['categorie']]) ? $cats[$r['categorie']] : $r['categorie'];
                ?>
              </td>
              <?php // strtotime() : convertit la chaîne MySQL en timestamp pour formater ?>
              <td><?php echo date('d/m/Y H:i', strtotime($r['date_debut'])); ?></td>
              <td><?php echo date('d/m/Y H:i', strtotime($r['date_fin'])); ?></td>
              <td><?php echo $r['region']; ?></td>
              <td><?php echo $r['distance']; ?> km</td>
              <td>
                <?php
                // Couleur du badge selon la difficulté (vert / jaune / rouge)
                $diffClass = ['facile'=>'badge-green','moyen'=>'badge-yellow','difficile'=>'badge-red'];
                $cls = isset($diffClass[$r['difficulte']]) ? $diffClass[$r['difficulte']] : 'badge-muted';
                // ucfirst() met la première lettre en majuscule pour l'affichage
                echo '<span class="badge '.$cls.'">'.ucfirst($r['difficulte']).'</span>';
                ?>
              </td>
              <td><?php echo $r['capacite']; ?></td>
              <td>
                <?php 
                // si la photo existe on l'affiche, sinon « Pas de photo »
                $photoPath = "../Randonnée-photo/" . $r['image'];
                $photoHtml = (!empty($r['image']) && file_exists($photoPath))
                    ? "<img src='$photoPath' width='50' height='50' style='object-fit:cover;border-radius:4px;' alt='photo'>"
                    : "Pas de photo";
                // var_dump($photoPath);
                echo $photoHtml;
                ?>
              </td>
              <td>
                <?php // Affichage conditionnel : on n'affiche le bus que s'il y en a un ?>
                <?php echo $r['id_bus'] ? 'Bus #'.$r['id_bus'].' ('.$r['immat_bus'].')' : '—'; ?>
              </td>
              <td>
                <?php // Badge vert si la randonnée est en cours, gris sinon ?>
                <?php echo $r['statut'] === 'en_cours'
                  ? '<span class="badge badge-green">En cours</span>'
                  : '<span class="badge badge-muted">Terminée</span>'; ?>
              </td>
              <?php // number_format() : 2 décimales, virgule comme séparateur, espace pour les milliers ?>
              <td><?php echo number_format($r['prix'], 2, ',', ' '); ?> TND</td>
              <td class="tbl-right">
                <div class="act-group">
                  <a href="controlAdmin.php?section=section-randonnees&edit_rando=<?php echo $r['id_randonnee']; ?>"
                     title="Modifier" class="act-btn">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                  </a>
                  <a href="controlAdmin.php?section=section-randonnees&supprimer_rando=<?php echo $r['id_randonnee']; ?>"
                     title="Supprimer" class="act-btn act-del"
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
