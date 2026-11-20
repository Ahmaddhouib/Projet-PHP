  <?php // ===== Modal d'ajout / modification d'un utilisateur (participant) ===== ?>
  <div id="modal-participant" class="modal">
    <div id="modal-participant-backdrop" class="modal-backdrop"></div>
    <div class="modal-wrap">
      <div class="modal-panel modal-md">
        <div class="modal-head">
          <h3 id="modal-participant-title" class="modal-title">
            <?php // Le titre change selon qu'on ajoute ou qu'on modifie ?>
            <?php echo isset($userMod) ? 'Modifier le Participant' : 'Ajouter un Participant'; ?>
          </h3>
          <a href="controlAdmin.php?section=section-participants" class="modal-close">
            <span class="material-symbols-outlined text-stone-400 text-xl">close</span>
          </a>
        </div>
        <?php // enctype multipart/form-data est OBLIGATOIRE pour l'upload de la photo ?>
        <form id="form-participant" class="modal-body form-body"
              method="post" action="controlAdmin.php" enctype="multipart/form-data">

          <?php // Champ caché qui indique au contrôleur l'action à effectuer ?>
          <input type="hidden" name="<?php echo isset($userMod) ? 'modifier_user' : 'ajouter_user'; ?>" value="1">
          <input type="hidden" name="section_active" value="section-participants">

          <?php // L'ID n'est affiché qu'en mode modification (lecture seule) ?>
          <?php if (isset($userMod)): ?>
            <div>
              <label for="participant-id" class="form-label">ID</label>
              <input id="participant-id" name="id_user" type="number"
                     value="<?php echo $userMod['id_user']; ?>" class="form-input disabled" readonly/>
            </div>
          <?php endif; ?>

          <div class="form-row">
            <div>
              <label for="participant-nom" class="form-label">Nom *</label>
              <input id="participant-nom" name="nom" type="text" required
                     placeholder="Nom complet"
                     value="<?php echo isset($userMod['nom']) ? $userMod['nom'] : ''; ?>"
                     class="form-input"/>
            </div>
            <div>
              <label for="participant-email" class="form-label">Email *</label>
              <input id="participant-email" name="email" type="email" required
                     placeholder="exemple@email.com"
                     value="<?php echo isset($userMod['email']) ? $userMod['email'] : ''; ?>"
                     class="form-input"/>
            </div>
          </div>

          <div class="form-row">
            <div>
              <!-- En mode édition, le champ password n'est PAS obligatoire (vide = on garde l'ancien) -->
              <label for="participant-password" class="form-label">
                Mot de passe <?php echo isset($userMod) ? '(laisser vide pour ne pas changer)' : '*'; ?>
              </label>
              <input id="participant-password" name="password" type="password"
                     <?php echo isset($userMod) ? '' : 'required'; ?>
                     placeholder="••••••••" class="form-input"/>
            </div>
            <div>
              <label for="participant-telephone" class="form-label">Téléphone</label>
              <input id="participant-telephone" name="telephone" type="tel"
                     placeholder="Ex: 55 123 456"
                     value="<?php echo isset($userMod['telephone']) ? $userMod['telephone'] : ''; ?>"
                     class="form-input"/>
            </div>
          </div>

          <div class="form-row">
            <div>
              <label for="participant-role" class="form-label">Rôle *</label>
              <select id="participant-role" name="role" required class="form-input">
                <?php
                // Construction des options à partir d'un tableau associatif (clé = valeur stockée, valeur = libellé)
                $roles = ['user'=>'User','admin'=>'Admin'];
                foreach ($roles as $val => $lbl):
                    // selected si on est en édition et que c'est le rôle actuel de l'utilisateur
                    $sel = isset($userMod) && $userMod['role'] === $val ? 'selected' : '';
                ?>
                <option value="<?php echo $val; ?>" <?php echo $sel; ?>><?php echo $lbl; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label class="form-label">Photo de profil</label>
              <div class="flex items-center gap-3">
                <!-- Zone d'upload stylisée : input file caché + label cliquable -->
                <label class="upload-zone">
                  <span class="material-symbols-outlined">cloud_upload</span>
                  <span id="participant-image-label" class="upload-label">Choisir un fichier…</span>
                  <!-- onchange : on met à jour le libellé avec le nom du fichier choisi -->
                  <input id="participant-image" name="image_profile" type="file"
                         accept="image/*" class="hidden"
                         onchange="document.getElementById('participant-image-label').textContent = this.files[0]?.name || 'Choisir un fichier…'"/>
                </label>
              </div>
            </div>
          </div>

          <div class="modal-foot" style="padding:0 0 0.5rem;">
            <a href="controlAdmin.php?section=section-participants" class="btn btn-ghost">Annuler</a>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
