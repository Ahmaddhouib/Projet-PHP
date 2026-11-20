    <?php
    // ===== Panneau de filtres réutilisable (admin et user) =====
    // Le formulaire envoie les critères en GET vers $filterAction (admin ou user)
    // Les valeurs précédentes sont conservées via la condition isset($_GET[...]) === ...
    ?>
    <div class="filter-panel">
      <div class="card" style="padding:1.25rem;">
        <div class="filter-hdr">
          <span class="material-symbols-outlined">filter_alt</span>
          <h3>Recherche &amp; Filtres</h3>
        </div>
        <!-- Méthode GET pour pouvoir bookmarker la recherche / partager l'URL -->
        <form method="get" action="<?php echo $filterAction; ?>">
          <!-- Marqueur qui sera testé dans le contrôleur (isset($_GET['recherche_rando'])) -->
          <input type="hidden" name="recherche_rando" value="1">
          <input type="hidden" name="section" value="section-randonnees">
          <div class="filter-grid">
            <div>
              <label class="filter-label">Catégorie</label>
              <!-- Pour chaque option : on ajoute "selected" si le critère est déjà coché en URL -->
              <select name="categorie" class="form-input">
                <option value="">Toutes</option>
                <option value="montagne" <?php echo (isset($_GET['categorie']) && $_GET['categorie']==='montagne') ? 'selected' : ''; ?>>Montagne</option>
                <option value="desert"   <?php echo (isset($_GET['categorie']) && $_GET['categorie']==='desert')   ? 'selected' : ''; ?>>Désert</option>
                <option value="foret"    <?php echo (isset($_GET['categorie']) && $_GET['categorie']==='foret')    ? 'selected' : ''; ?>>Forêt</option>
                <option value="bord_de_mer" <?php echo (isset($_GET['categorie']) && $_GET['categorie']==='bord_de_mer') ? 'selected' : ''; ?>>Bord de mer</option>
              </select>
            </div>
            <div>
              <label class="filter-label">Difficulté</label>
              <select name="difficulte" class="form-input">
                <option value="">Toutes</option>
                <option value="facile"    <?php echo (isset($_GET['difficulte']) && $_GET['difficulte']==='facile')    ? 'selected' : ''; ?>>Facile</option>
                <option value="moyen"     <?php echo (isset($_GET['difficulte']) && $_GET['difficulte']==='moyen')     ? 'selected' : ''; ?>>Moyen</option>
                <option value="difficile" <?php echo (isset($_GET['difficulte']) && $_GET['difficulte']==='difficile') ? 'selected' : ''; ?>>Difficile</option>
              </select>
            </div>
            <div>
              <label class="filter-label">Lieu (région)</label>
              <!-- Pré-remplissage du champ texte avec la valeur précédente (échappée pour la sécurité) -->
              <input name="region" type="text" placeholder="Ex: Zaghouan, Tabarka…"
                     value="<?php echo isset($_GET['region']) ? $_GET['region'] : ''; ?>"
                     class="form-input"/>
            </div>
            <div>
              <label class="filter-label">Prix max (TND)</label>
              <input name="prix_max" type="number" min="0" placeholder="Ex: 5000"
                     value="<?php echo isset($_GET['prix_max']) ? $_GET['prix_max'] : ''; ?>"
                     class="form-input"/>
            </div>
          </div>
          <div class="filter-actions">
            <button type="submit" class="btn btn-primary">
              <span class="material-symbols-outlined text-[16px]">search</span> Rechercher
            </button>
            <!-- Lien Réinitialiser : retourne à la liste sans filtres -->
            <a href="<?php echo $filterAction; ?>?section=section-randonnees" class="btn btn-ghost">Réinitialiser</a>
          </div>
        </form>
      </div>
    </div>
