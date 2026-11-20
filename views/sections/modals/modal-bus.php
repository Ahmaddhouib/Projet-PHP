  <?php // ===== Modal d'ajout / modification d'un bus ===== ?>
  <div id="modal-bus" class="modal">
    <!-- Fond semi-transparent : un clic dessus pourrait fermer le modal -->
    <div id="modal-bus-backdrop" class="modal-backdrop"></div>
    <div class="modal-wrap">
      <div class="modal-panel modal-md">
        <div class="modal-head">
          <h3 id="modal-bus-title" class="modal-title">
            <?php // Le titre change selon qu'on ajoute ou qu'on modifie ?>
            <?php echo isset($busMod) ? 'Modifier le Bus' : 'Nouveau Bus'; ?>
          </h3>
          <!-- Croix de fermeture : redirige vers la liste sans paramètre d'édition -->
          <a href="controlAdmin.php?section=section-bus" class="modal-close">
            <span class="material-symbols-outlined text-stone-400 text-xl">close</span>
          </a>
        </div>
        <form id="form-bus" class="modal-body form-body" method="post" action="controlAdmin.php">

          <?php // Champ caché qui indique au contrôleur l'action à effectuer ?>
          <input type="hidden" name="<?php echo isset($busMod) ? 'modifier_bus' : 'ajouter_bus'; ?>" value="1">
          <input type="hidden" name="section_active" value="section-bus">

          <?php // L'ID n'est affiché qu'en mode modification (readonly pour information) ?>
          <?php if (isset($busMod)): ?>
            <div>
              <label for="bus-id" class="form-label">ID</label>
              <input id="bus-id" name="id_bus" type="number"
                     value="<?php echo $busMod['id_bus']; ?>" class="form-input disabled" readonly/>
            </div>
          <?php endif; ?>

          <div>
            <label for="bus-immat" class="form-label">Immatriculation *</label>
            <!-- Pré-remplissage si édition, vide si ajout -->
            <input id="bus-immat" name="immat_bus" type="text" required
                   placeholder="Ex: TN-1234-AB"
                   value="<?php echo isset($busMod['immat_bus']) ? $busMod['immat_bus'] : ''; ?>"
                   class="form-input"/>
          </div>

          <div>
            <label for="bus-places" class="form-label">Nombre de places *</label>
            <input id="bus-places" name="nb_places" type="number" min="1" required
                   placeholder="Ex: 50"
                   value="<?php echo isset($busMod['nb_places']) ? $busMod['nb_places'] : ''; ?>"
                   class="form-input"/>
          </div>

          <div class="form-row">
            <div>
              <label for="bus-chauffeur" class="form-label">Chauffeur *</label>
              <input id="bus-chauffeur" name="chauffeur" type="text" required
                     placeholder="Nom complet"
                     value="<?php echo isset($busMod['chauffeur']) ? $busMod['chauffeur'] : ''; ?>"
                     class="form-input"/>
            </div>
            <div>
              <label for="bus-tel" class="form-label">Tél. Chauffeur *</label>
              <input id="bus-tel" name="tel_chauff" type="tel" required
                     placeholder="Ex: 55 123 456"
                     value="<?php echo isset($busMod['tel_chauff']) ? $busMod['tel_chauff'] : ''; ?>"
                     class="form-input"/>
            </div>
          </div>

          <div class="modal-foot" style="padding:0 0 0.5rem;">
            <a href="controlAdmin.php?section=section-bus" class="btn btn-ghost">Annuler</a>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
