<!DOCTYPE html>
<!-- =====================================================================
     Page de connexion : formulaire envoyé en POST vers control-cnx.php
     Si la variable $message est définie (depuis le contrôleur), elle s'affiche en rouge
     ===================================================================== -->
<html class="light" lang="fr">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <!-- Tailwind via CDN + plugins forms et container-queries -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Literata:ital,opsz,wght@0,7..72,200..900;1,7..72,200..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />

  <!-- Configuration Tailwind personnalisée pour l'écran de connexion -->
  <script src="../js/tailwind-config-cnx.js"></script>

  <link rel="stylesheet" href="../css/connexion.css"/>
</head>

<body class="bg-background text-on-background min-h-screen flex flex-col overflow-x-hidden">

  <!-- En-tête : logo / nom de l'application -->
  <header
    class="bg-[#faf6f0] dark:bg-stone-950 border-b border-stone-200/50 dark:border-stone-800/50 shadow-sm dark:shadow-none flex justify-between items-center w-full px-6 py-4 fixed top-0 z-50">
    <div class="font-['Literata'] serif text-2xl font-bold text-[#4a7c59] dark:text-[#6fb082] tracking-tight">Nature's
      Breath</div>
  </header>

  <!-- Bloc principal : carte centrée contenant le formulaire de connexion -->
  <main class="flex-grow flex items-center justify-center px-4 pt-20 pb-24">
    <div
      class="w-full max-w-md bg-surface-container-lowest rounded-xl shadow-[0_4px_20px_rgba(46,50,48,0.06)] p-8 md:p-10 border border-outline-variant/30">

      <div class="text-center mb-8">
        <h2 class="text-3xl text-primary font-bold tracking-tight mb-2">Bienvenue</h2>
        <p class="text-on-surface-variant font-body">Connectez-vous à votre espace naturel</p>
      </div>

      <!-- Formulaire envoyé en POST vers le contrôleur de connexion -->
      <form action="../controller/control-cnx.php" method="post" class="space-y-6">
        <div class="space-y-1.5">
          <label class="text-sm font-label font-semibold text-on-surface-variant ml-1" for="email">Email</label>
          <input
            class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 focus:ring-2 focus:ring-primary/20 text-on-surface placeholder-outline/50 transition-all font-body"
            id="email" name="email" placeholder="votre@email.com" type="email" />
        </div>
        <div class="space-y-1.5">
          <label class="text-sm font-label font-semibold text-on-surface-variant ml-1" for="password">Password</label>
          <input
            class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 focus:ring-2 focus:ring-primary/20 text-on-surface placeholder-outline/50 transition-all font-body"
            id="password" name="password" placeholder="••••••••" type="password" />
        </div>
        <button
          class="w-full bg-primary text-on-primary py-3.5 rounded-xl font-bold text-lg hover:opacity-90 active:scale-[0.98] transition-all duration-200 shadow-md"
          type="submit">
          Se connecter
        </button>
      </form>
      <?php // Affichage conditionnel d'un message d'erreur (rempli par le contrôleur) ?>
      <?php if (!empty($message)): ?>
        <p style="color:red; text-align:center; margin-top:1rem;"><?php echo $message; ?></p>
      <?php endif; ?>
    </div>
  </main>

  <!-- Pied de page décoratif -->
  <footer
    class="bg-transparent text-stone-400 dark:text-stone-600 font-['Nunito_Sans'] uppercase tracking-widest text-xs w-full flex flex-col items-center justify-center gap-2 mt-auto pb-8">
    <span class="material-symbols-outlined text-stone-400/50" data-icon="landscape">landscape</span>
    <div class="opacity-80">END OF PATH</div>
  </footer>

  <!-- Bulles décoratives en arrière-plan -->
  <div class="fixed bottom-0 left-0 w-full h-1/2 -z-10 pointer-events-none opacity-20">
    <div
      class="absolute bottom-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-[120px] translate-x-1/4 translate-y-1/4">
    </div>
    <div class="absolute top-1/2 left-0 w-64 h-64 bg-tertiary/10 rounded-full blur-[80px] -translate-x-1/2"></div>
  </div>
</body>
</html>
