// =====================================================================
// Sélectionne la section à afficher au chargement de la page (vue randonneur)
// La valeur est transmise par PHP via l'attribut data-active-section sur <body>
// =====================================================================
(function() {
  // Récupération de la section ciblée depuis l'attribut data-* du <body>
  var section = document.body.dataset.activeSection;
  var target = document.getElementById(section);
  if (target) {
    // 1) On cache toutes les sections
    document.querySelectorAll('.content-section').forEach(function(s) { s.classList.add('hidden'); });
    // 2) On affiche la section ciblée
    target.classList.remove('hidden');
    // 3) On met le bon lien en surbrillance dans la sidebar
    document.querySelectorAll('#sidebar-nav .nav-link').forEach(function(link) {
      if (link.dataset.section === section) link.classList.add('active');
      else link.classList.remove('active');
    });
  }
})();
