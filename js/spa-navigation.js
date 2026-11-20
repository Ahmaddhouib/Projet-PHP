// =====================================================================
// Navigation type SPA (Single-Page Application) entre sections du dashboard
// On évite un rechargement de la page : on cache/affiche les <div> côté JS
// =====================================================================
(function () {
  // Récupération des liens de la sidebar et de toutes les sections
  const navLinks = document.querySelectorAll('#sidebar-nav .nav-link');
  const sections = document.querySelectorAll('.content-section');

  // Active la section ciblée et met à jour le lien actif dans la sidebar
  function activateTab(targetId) {
    // 1) On cache toutes les sections
    sections.forEach(s => s.classList.add('hidden'));
    // 2) On affiche la section cible si elle existe
    const target = document.getElementById(targetId);
    if (target) target.classList.remove('hidden');

    // 3) On met en surbrillance le lien de la sidebar correspondant
    navLinks.forEach(link => {
      if (link.dataset.section === targetId) {
        link.classList.add('active');
      } else {
        link.classList.remove('active');
      }
    });
  }

  // Branche le clic sur chaque lien de la sidebar
  navLinks.forEach(link => {
    link.addEventListener('click', function (e) {
      // preventDefault pour empêcher le saut d'ancre dans l'URL
      e.preventDefault();
      activateTab(this.dataset.section);
    });
  });
})();
