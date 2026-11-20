<?php
// =====================================================================
// Déconnexion : on détruit la session et on retourne au formulaire de connexion
// =====================================================================

session_start();      // on doit redémarrer la session avant de pouvoir la détruire
session_destroy();    // détruit toutes les variables de session côté serveur
header('Location: ../views/ViewMain.php');
exit();
?>
