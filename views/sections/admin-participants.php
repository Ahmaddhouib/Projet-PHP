  <?php // ===== Section "Gestion des Participants" (admin) — gère les utilisateurs ===== ?>
  <div id="section-participants" class="content-section hidden">
    <div class="sec-hdr">
      <div>
        <h2 class="sec-title">Gestion des Participants</h2>
        <p class="sec-desc">Gérez la liste des utilisateurs inscrits sur la plateforme.</p>
      </div>
      <!-- Lien "Ajouter un Participant" : ouvre le modal en mode ajout -->
      <a href="controlAdmin.php?section=section-participants&new_user=1" class="btn btn-primary">
        <span class="material-symbols-outlined text-[18px]">person_add</span>
        Ajouter un Participant
      </a>
    </div>

    <div class="card">
      <div class="card-hdr">
        <h3 class="card-title">Liste des Participants</h3>
        <span class="result-count"><?php echo count($listeUsers); ?> utilisateur(s)</span>
      </div>
      <div class="overflow-x-auto">
        <table class="tbl">
          <thead>
            <tr>
              <th>ID</th>
              <th>Photo</th>
              <th>Nom</th>
              <th>Email</th>
              <th>Téléphone</th>
              <th>Rôle</th>
              <th class="tbl-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($listeUsers)): ?>
            <tr><td colspan="7" class="text-center py-6 text-stone-400">Aucun utilisateur enregistré.</td></tr>
            <?php else: ?>
            <?php // Boucle sur tous les utilisateurs ?>
            <?php foreach ($listeUsers as $u): ?>
            <tr>
              <td><?php echo $u['id_user']; ?></td>
              <td>
                <?php
                // Même logique que le cours : on affiche la photo si elle existe, sinon « Pas de photo »
                $imgPath = "../Randonnée-photo/" . $u['image_profile'];
                // file_exists vérifie que le fichier existe vraiment sur le disque
                $imgHtml = (!empty($u['image_profile']) && file_exists($imgPath))
                    ? "<img src='$imgPath' width='40' height='40' style='object-fit:cover;border-radius:50%;' alt='photo'>"
                    : "Pas de photo";
                // var_dump($imgPath);
                echo $imgHtml;
                ?>
              </td>
              <td><?php echo $u['nom']; ?></td>
              <td><?php echo $u['email']; ?></td>
              <td><?php echo $u['telephone']; ?></td>
              <td>
                <?php // Badge coloré selon le rôle (admin vs user) ?>
                <?php echo $u['role'] === 'admin'
                  ? '<span class="badge badge-green">Admin</span>'
                  : '<span class="badge badge-yellow">User</span>'; ?>
              </td>
              <td class="tbl-right">
                <div class="act-group">
                  <a href="controlAdmin.php?section=section-participants&edit_user=<?php echo $u['id_user']; ?>"
                     title="Modifier" class="act-btn">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                  </a>
                  <a href="controlAdmin.php?section=section-participants&supprimer_user=<?php echo $u['id_user']; ?>"
                     title="Supprimer" class="act-btn act-del"
                     onclick="return confirm('Supprimer cet utilisateur ?')">
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
  </div>

  <?php
  // Affiche le modal en mode ajout (new_user=1) ou modification ($userMod défini)
  if (isset($userMod) || isset($_GET['new_user'])):
    include 'modals/modal-participant.php';
  endif;
  ?>
