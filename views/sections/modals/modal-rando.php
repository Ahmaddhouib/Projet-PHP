  <?php // ===== Modal d'ajout / modification d'une randonnée ===== ?>
  <div id="modal-rando" class="modal">
    <div id="modal-rando-backdrop" class="modal-backdrop"></div>
    <div class="modal-wrap">
      <div class="modal-panel modal-lg">
        <div class="modal-head">
          <h3 id="modal-rando-title" class="modal-title">
            <?php // Le titre change selon qu'on ajoute ou qu'on modifie ?>
            <?php echo isset($randoMod) ? 'Modifier la Randonnée' : 'Nouvelle Randonnée'; ?>
          </h3>
          <a href="controlAdmin.php?section=section-randonnees" class="modal-close">
            <span class="material-symbols-outlined text-stone-400 text-xl">close</span>
          </a>
        </div>
        <?php // enctype multipart/form-data est obligatoire pour l'upload de fichier (photo) ?>
        <form id="form-rando" class="modal-body form-body"
              method="post" action="controlAdmin.php" enctype="multipart/form-data">

          <?php // Champ caché qui indique au contrôleur l'action à effectuer ?>
          <input type="hidden" name="<?php echo isset($randoMod) ? 'modifier_rando' : 'ajouter_rando'; ?>" value="1">
          <input type="hidden" name="section_active" value="section-randonnees">

          <?php // L'ID n'est affiché qu'en mode modification (lecture seule, pour info) ?>
          <?php if (isset($randoMod)): ?>
            <div id="rando-id-row">
              <label for="rando-id" class="form-label">ID</label>
              <input id="rando-id" name="id_randonnee" type="number"
                     value="<?php echo $randoMod['id_randonnee']; ?>" class="form-input disabled" readonly/>
            </div>
          <?php endif; ?>

          <div>
            <label for="rando-titre" class="form-label">Titre *</label>
            <input id="rando-titre" name="titre" type="text" required
                   placeholder="Ex: Sentier des Crêtes"
                   value="<?php echo isset($randoMod['titre']) ? $randoMod['titre'] : ''; ?>"
                   class="form-input"/>
          </div>

          <div class="form-row">
            <div>
              <label for="rando-categorie" class="form-label">Catégorie *</label>
              <select id="rando-categorie" name="categorie" required class="form-input">
                <option value="">— Sélectionner —</option>
                <?php
                // Construction des options à partir d'un tableau associatif (clé = valeur stockée, valeur = libellé)
                $cats = ['montagne'=>'Montagne','desert'=>'Désert','foret'=>'Forêt','bord_de_mer'=>'Bord de mer'];
                foreach ($cats as $val => $lbl):
                    // selected si on est en mode édition et que c'est la catégorie actuelle
                    $sel = isset($randoMod) && $randoMod['categorie'] === $val ? 'selected' : '';
                ?>
                <option value="<?php echo $val; ?>" <?php echo $sel; ?>><?php echo $lbl; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label for="rando-difficulte" class="form-label">Difficulté *</label>
              <select id="rando-difficulte" name="difficulte" required class="form-input">
                <option value="">— Sélectionner —</option>
                <?php
                $diffs = ['facile'=>'Facile','moyen'=>'Moyen','difficile'=>'Difficile'];
                foreach ($diffs as $val => $lbl):
                    $sel = isset($randoMod) && $randoMod['difficulte'] === $val ? 'selected' : '';
                ?>
                <option value="<?php echo $val; ?>" <?php echo $sel; ?>><?php echo $lbl; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div>
            <label for="rando-description" class="form-label">Description</label>
            <textarea id="rando-description" name="description" rows="3"
                      placeholder="Décrivez brièvement la randonnée…"
                      class="form-input" style="resize:none;"><?php echo isset($randoMod['description']) ? $randoMod['description'] : ''; ?></textarea>
          </div>

          <div class="form-row">
            <div>
              <label for="rando-date-debut" class="form-label">Date début *</label>
              <?php // Format datetime-local : on doit reformater la date MySQL en YYYY-MM-DDTHH:MM ?>
              <input id="rando-date-debut" name="date_debut" type="datetime-local" required
                     value="<?php echo isset($randoMod) ? date('Y-m-d\TH:i', strtotime($randoMod['date_debut'])) : ''; ?>"
                     class="form-input"/>
            </div>
            <div>
              <label for="rando-date-fin" class="form-label">Date fin *</label>
              <input id="rando-date-fin" name="date_fin" type="datetime-local" required
                     value="<?php echo isset($randoMod) ? date('Y-m-d\TH:i', strtotime($randoMod['date_fin'])) : ''; ?>"
                     class="form-input"/>
            </div>
          </div>

          <div class="form-row">
            <div>
              <label for="rando-region" class="form-label">Région *</label>
              <input id="rando-region" name="region" type="text" required
                     placeholder="Ex: Zaghouan, Tabarka…"
                     value="<?php echo isset($randoMod['region']) ? $randoMod['region'] : ''; ?>"
                     class="form-input"/>
            </div>
            <div>
              <label for="rando-distance" class="form-label">Distance (km)</label>
              <input id="rando-distance" name="distance" type="number" min="0" step="0.1"
                     placeholder="Ex: 12"
                     value="<?php echo isset($randoMod['distance']) ? $randoMod['distance'] : ''; ?>"
                     class="form-input"/>
            </div>
          </div>

          <div class="form-row">
            <div>
              <label for="rando-capacite" class="form-label">Capacité</label>
              <input id="rando-capacite" name="capacite" type="number" min="1"
                     placeholder="Ex: 30"
                     value="<?php echo isset($randoMod['capacite']) ? $randoMod['capacite'] : ''; ?>"
                     class="form-input"/>
            </div>
            <div>
              <label for="rando-prix" class="form-label">Prix (TND) *</label>
              <input id="rando-prix" name="prix" type="number" min="0" required
                     placeholder="Ex: 3500"
                     value="<?php echo isset($randoMod['prix']) ? $randoMod['prix'] : ''; ?>"
                     class="form-input"/>
            </div>
          </div>

          <div class="form-row">
            <div>
              <label for="rando-bus" class="form-label">Assigner un Bus</label>
              <!-- Liste des bus disponibles (issue de Bus::getAllBus()) -->
              <select id="rando-bus" name="id_bus" class="form-input">
                <option value="">— Aucun —</option>
                <?php foreach ($listeBus as $bus):
                    // selected si en édition et le bus assigné correspond
                    $sel = isset($randoMod) && $randoMod['id_bus'] == $bus['id_bus'] ? 'selected' : '';
                ?>
                <option value="<?php echo $bus['id_bus']; ?>" <?php echo $sel; ?>>
                  Bus #<?php echo $bus['id_bus']; ?> — <?php echo $bus['immat_bus']; ?> (<?php echo $bus['nb_places']; ?> places)
                </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label for="rando-statut" class="form-label">Statut *</label>
              <select id="rando-statut" name="statut" required class="form-input">
                <?php
                $statuts = ['en_cours'=>'En cours','terminee'=>'Terminée'];
                foreach ($statuts as $val => $lbl):
                    $sel = isset($randoMod) && $randoMod['statut'] === $val ? 'selected' : '';
                ?>
                <option value="<?php echo $val; ?>" <?php echo $sel; ?>><?php echo $lbl; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div>
            <label for="rando-image" class="form-label">Photo (JPEG, max 5Mo)</label>
            <div class="flex items-center gap-3">
              <!-- Zone d'upload : on affiche le nom du fichier actuel s'il existe -->
              <label class="upload-zone">
                <span class="material-symbols-outlined">cloud_upload</span>
                <span id="rando-image-label" class="upload-label">
                  <?php echo isset($randoMod) && $randoMod['image'] !== 'default_rando.png'
                    ? $randoMod['image'] : 'Choisir un fichier…'; ?>
                </span>
                <!-- accept="image/jpeg" : limite la sélection au JPEG côté navigateur -->
                <input id="rando-image" name="photo" type="file" accept="image/jpeg,image/jpg" class="hidden"
                       onchange="document.getElementById('rando-image-label').textContent = this.files[0]?.name || 'Choisir un fichier…'"/>
              </label>
            </div>
          </div>

          <div class="modal-foot" style="padding:0 0 0.5rem;">
            <a href="controlAdmin.php?section=section-randonnees" class="btn btn-ghost">Annuler</a>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
