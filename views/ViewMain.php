<!DOCTYPE html>
<!-- =====================================================================
     Page d'accueil publique : présente l'application Nature's Breath
     Aucune logique PHP, juste une vitrine avec 4 thèmes (montagne, désert, forêt, mer)
     Le bouton "Connexion" du menu redirige vers ViewCnx.php
     ===================================================================== -->
<html class="light" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link
        href="https://fonts.googleapis.com/css2?family=Literata:ital,opsz,wght@0,7..72,200..900;1,7..72,200..900&amp;family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
      <script src="../js/tailwind-config-main.js"></script>

    <link rel="stylesheet" href="../css/main.css"/>
</head>

<body class="bg-background text-on-surface selection:bg-primary/20">

    <!-- Astuce CSS-only : checkbox cachée + label pour ouvrir/fermer le menu sans JS -->
    <input class="hidden" id="mobile-menu-toggle" type="checkbox" />

    <!-- Menu latéral (caché par défaut, glisse en place quand la checkbox est cochée) -->
    <aside
        class="fixed inset-y-0 left-0 w-80 bg-[#faf6f0] dark:bg-[#1a1c1a] border-r border-stone-200 dark:border-stone-800 shadow-2xl dark:shadow-none z-[60] transition-transform -translate-x-full duration-300 ease-in-out"
        id="side-nav-container">
        <div class="h-full flex flex-col p-6">
            <div class="mb-10">
                <label
                    class="cursor-pointer inline-flex items-center gap-2 text-stone-500 hover:text-primary transition-colors"
                    for="mobile-menu-toggle">
                    <span class="material-symbols-outlined" data-icon="close">close</span>
                    <span class="font-label text-sm font-bold uppercase tracking-widest">Fermer</span>
                </label>
            </div>
            <div class="mb-10">
                <h2 class="text-2xl font-serif text-[#4a7c59] text-center">Nature's Breath</h2>
            </div>
            <nav class="flex flex-col gap-2">
                <a class="flex items-center gap-4 text-stone-600 dark:text-stone-400 px-4 py-3 hover:bg-stone-100 dark:hover:bg-stone-800 rounded-xl transition-colors"
                    href="ViewCnx.php">
                    <span class="material-symbols-outlined" data-icon="login">login</span>
                    <span class="font-label font-medium">Connexion</span>
                </a>


            </nav>
            <div class="mt-auto pt-6 border-t border-stone-200 dark:border-stone-800">
                <div class="flex items-center gap-3 px-4 py-2 opacity-60 grayscale">
                    <span class="material-symbols-outlined" data-icon="landscape">landscape</span>
                    <span class="font-label text-xs uppercase tracking-tighter">Nature's Breath </span>
                </div>
            </div>
        </div>
    </aside>
    
    <header
        class="fixed top-0 left-0 w-full z-50 flex items-center px-6 py-4 bg-[#faf6f0] dark:bg-[#1a1c1a] transition-all">
        <div class="flex items-center gap-4">
            <label
                class="cursor-pointer p-2 rounded-full hover:bg-stone-200/50 dark:hover:bg-stone-800/50 transition-colors active:scale-95 duration-150 text-[#4a7c59] dark:text-[#a3cfab]"
                for="mobile-menu-toggle">
                <span class="material-symbols-outlined" data-icon="menu">menu</span>
            </label>
            <div class="text-xl font-bold font-serif text-[#4a7c59] dark:text-[#a3cfab] whitespace-nowrap">
                Nature's Breath
            </div>
        </div>
        <div class="flex-1"></div>
    </header>
    <main class="pt-0">

        <!-- Section Hero : grande image plein écran avec slogan -->
        <section class="relative h-screen flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-stone-900/20 z-10"></div>
            <img alt="Panoramic view of mountain peaks" class="absolute inset-0 w-full h-full object-cover"
                data-alt="Cinematic immersive panoramic view of layered blue mountain peaks shrouded in soft morning mist under a clear calm sky"
                src="..\assets\photos\Gemini_Generated_Image_85aril85aril85ar.png" />
            <div class="relative z-20 flex flex-col items-center text-center px-6 max-w-4xl">
                <h1
                    class="text-5xl md:text-7xl lg:text-8xl text-white font-headline leading-tight drop-shadow-lg mb-8 text-center">
                    Respirez. Marchez. Explorez.
                </h1>

            </div>
            <div
                class="absolute z-20 flex flex-col items-center gap-2 animate-bounce bottom-[40px] left-[50%] -translate-x-[50%] -ml-[50px]">
                <span class="font-label text-white/70 text-xs tracking-[0.3em] pl-[0.3em] uppercase text-center">
                    Découvrir
                </span>
                <span class="material-symbols-outlined text-white/70 leading-none"
                    data-icon="keyboard_double_arrow_down">
                    keyboard_double_arrow_down
                </span>
            </div>
        </section>
        
        <!-- Section galerie : 4 blocs thématiques (Montagne, Désert, Forêt, Mer) -->
        <section class="space-y-0">

            <!-- Bloc Montagne (texte à gauche / image à droite) -->
            <div class="group relative h-[819px] flex items-center overflow-hidden bg-white border-b border-stone-100">
                <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center z-20">
                    <div
                        class="order-2 md:order-1 transition-all duration-1000 transform translate-y-10 group-hover:translate-y-0 opacity-80 group-hover:opacity-100">
                        <h2 class="text-4xl md:text-6xl text-on-surface font-headline mb-6">Montagne</h2>
                        <p class="text-on-surface-variant font-body text-lg max-w-md leading-relaxed mb-8">
                            Élevez votre esprit sur les sommets enneigés, là où l'air est pur et le silence souverain.
                        </p>

                    </div>
                    <div class="order-1 md:order-2 flex justify-center">
                        <div
                            class="w-full max-w-lg aspect-square bg-surface-container rounded-3xl overflow-hidden relative shadow-sm">
                            <img alt="Montagne"
                                class="w-full h-full object-cover mix-blend-multiply opacity-80 grayscale group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700"
                                data-alt="Minimalist flat digital art illustration of jagged snow-capped mountain peaks against a soft cream sky with clean vector lines"
                                src="..\assets\photos\66e92876-fb3a-4386-b162-6cec4393e33f.jpg" />
                            <div
                                class="absolute inset-0 bg-gradient-to-tr from-surface-container via-transparent to-transparent">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bloc Désert (image à gauche / texte à droite) -->
            <div
                class="group relative h-[819px] flex items-center overflow-hidden bg-surface-container-low border-b border-stone-100">
                <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center z-20">
                    <div class="flex justify-center">
                        <div
                            class="w-full max-w-lg aspect-square bg-surface-variant rounded-3xl overflow-hidden relative shadow-sm">
                            <img alt="Désert"
                                class="w-full h-full object-cover mix-blend-multiply opacity-80 grayscale group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700"
                                data-alt="Flat digital art style vector illustration of rolling desert sand dunes with a single tall cactus silhouette under a warm sun"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDoh_NNjz7XlqtxHJRq6-lpb7XtmZ8MnpvCpvV0oefUfeVTShnaKvO3PfmyQ7bQip2hG51Bvc1SumSWQXbEE7dA0DEgw_TwaZzr2DkJtV2p8_VU6NotfMaj4OZG5pkgj22xm8enYuXCzOGao_U8hmIjfNT4Uon-j-a7qD4xbsSxR9QLDIyX2PDrgo9qwFw4_rfXTiMjVgJAPd3sQgPOLf09uzJXQl921oBa6fT_lHWug_Yhr31HTdxfXmlzl-ikFoexF40LxmVTPsU" />
                            <div
                                class="absolute inset-0 bg-gradient-to-bl from-surface-variant via-transparent to-transparent">
                            </div>
                        </div>
                    </div>
                    <div
                        class="transition-all duration-1000 transform translate-y-10 group-hover:translate-y-0 opacity-80 group-hover:opacity-100">
                        <h2 class="text-4xl md:text-6xl text-on-surface font-headline mb-6">Désert</h2>
                        <p class="text-on-surface-variant font-body text-lg max-w-md leading-relaxed mb-8">
                            Explorez l'immensité dorée et la beauté sculptée par le vent des paysages arides.
                        </p>

                    </div>
                </div>
            </div>
            
            <!-- Bloc Forêt -->
            <div class="group relative h-[819px] flex items-center overflow-hidden bg-white border-b border-stone-100">
                <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center z-20">
                    <div
                        class="order-2 md:order-1 transition-all duration-1000 transform translate-y-10 group-hover:translate-y-0 opacity-80 group-hover:opacity-100">
                        <h2 class="text-4xl md:text-6xl text-on-surface font-headline mb-6">Forêt</h2>
                        <p class="text-on-surface-variant font-body text-lg max-w-md leading-relaxed mb-8">
                            Perdez-vous entre les troncs centenaires et le murmure des feuilles dans les sous-bois.
                        </p>

                    </div>
                    <div class="order-1 md:order-2 flex justify-center">
                        <div
                            class="w-full max-w-lg aspect-square bg-surface-container-high rounded-3xl overflow-hidden relative shadow-sm">
                            <img alt="Forêt"
                                class="w-full h-full object-cover mix-blend-multiply opacity-80 grayscale group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700"
                                data-alt="Flat vector digital illustration of dense pine forest with geometric tree shapes and varying shades of deep evergreen and sage"
                                src="..\assets\photos\foret.jpg" />
                            <div
                                class="absolute inset-0 bg-gradient-to-tr from-surface-container-high via-transparent to-transparent">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bloc Bord de mer -->
            <div class="group relative h-[819px] flex items-center overflow-hidden bg-surface-container-low">
                <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center z-20">
                    <div class="flex justify-center">
                        <div
                            class="w-full max-w-lg aspect-square bg-secondary-container rounded-3xl overflow-hidden relative shadow-sm">
                            <img alt="Bord de mer"
                                class="w-full h-full object-cover mix-blend-multiply opacity-80 grayscale group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-700"
                                data-alt="Stylized flat vector illustration of rhythmic ocean waves crashing against sharp dark cliffs under a misty pale sky"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCeE0Im_3NCOb7PJIjFsCxV8oTGqz9azE0o9OBfhIxCyus8b_JF1ii-aeV7JAkRnVuVcqfSCBWH0xQzhq0GAEHw8Pm_OQdN7kcTBELNHJqnGNthfdFRJ7AhsO0icui5gbCQTSaxA5Cok80RNlknI9lw_88VDffG7XiwBR1IJ4cWmdMRMSs9Qj3LGylAlgZ5VcEJ0zBl04Ken5D0maIQbePsQ7qskTQ-Rd3oRMkZ0QfFblaP0-IbYnCXiWnpY40wdclXjqfW5mrtbxA" />
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-secondary-container via-transparent to-transparent">
                            </div>
                        </div>
                    </div>
                    <div
                        class="transition-all duration-1000 transform translate-y-10 group-hover:translate-y-0 opacity-80 group-hover:opacity-100">
                        <h2 class="text-4xl md:text-6xl text-on-surface font-headline mb-6">Bord de mer</h2>
                        <p class="text-on-surface-variant font-body text-lg max-w-md leading-relaxed mb-8">
                            Respirez l'iode et laissez-vous guider par le rythme éternel des marées.
                        </p>

                    </div>
                </div>
            </div>
        </section>
    </main>
    
    <footer class="w-full flex flex-col items-center justify-center gap-2 mt-auto bg-transparent full-width pb-8">
        <div class="mb-4">
            <span class="material-symbols-outlined text-stone-400 text-4xl" data-icon="landscape">landscape</span>
        </div>
        <div class="font-sans text-xs tracking-widest uppercase text-stone-400 dark:text-stone-600">
            END OF PATH
        </div>
    </footer>
</body>

</html>