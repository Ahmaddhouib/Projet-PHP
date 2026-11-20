<?php
// =====================================================================
// Contrôleur Randonneur (utilisateur normal) :
//   - permet d'envoyer une demande de participation à une randonnée
//   - récupère les données nécessaires à ViewRandonneur.php
// =====================================================================

include_once "../models/User.php";
include_once "../models/Randonnee.php";
include_once "../models/Participation.php";

// Vérification de la session : tout utilisateur connecté peut accéder ici
session_start();
if (!isset($_SESSION["user"])) {
    header('Location: control-cnx.php');
    exit();
}

// Récupération de l'utilisateur connecté à partir de son email (stocké en session)
$email   = $_SESSION["user"];
$id_user = User::getIdByEmail($email);
$message = '';

// ============================================================
// ENVOYER UNE DEMANDE DE PARTICIPATION
// ============================================================

if (isset($_POST['envoyer_demande'])) {
    if (empty($_POST['id_randonnee'])) {
        echo "<script>alert('Randonnée introuvable.');</script>";
    } else {

        //var_dump($_POST); // pour vérifier l'id de la randonnée envoyée
        // Création d'un objet Participation pour l'utilisateur courant
        $p = new Participation($id_user, $_POST['id_randonnee']);
        // envoyer() retourne true ou 'doublon' / 'chevauchement' / 'complet'
        $resultat = $p->envoyer();

        // On affiche un message différent selon le résultat des règles métier
        if ($resultat === true) {
            echo "<script>alert('Demande envoyée avec succès ! Elle est en attente de validation.');
                  window.location.href='controlUser.php?section=section-mes-demandes';</script>";
            exit();
        } elseif ($resultat === 'doublon') {
            echo "<script>alert('Vous avez déjà envoyé une demande pour cette randonnée.');
                  window.location.href='controlUser.php?section=section-randonnees';</script>";
            exit();
        } elseif ($resultat === 'chevauchement') {
            echo "<script>alert('Impossible : vous participez déjà à une randonnée dont les dates se chevauchent.');
                  window.location.href='controlUser.php?section=section-randonnees';</script>";
            exit();
        } elseif ($resultat === 'complet') {
            echo "<script>alert('Cette randonnée est complète.');
                  window.location.href='controlUser.php?section=section-randonnees';</script>";
            exit();
        } else {
            echo "<script>alert('Erreur lors de l\'envoi de la demande.');</script>";
        }
    }
}

// ============================================================
// RÉCUPÉRATION DES DONNÉES POUR LA VUE
// ============================================================

// Recherche des randonnées si un filtre est appliqué, sinon liste complète
if (isset($_GET['recherche_rando'])) {
    $listeRandonnees = Randonnee::chercherRandonnees(
        isset($_GET['categorie']) ? $_GET['categorie'] : '',
        isset($_GET['difficulte']) ? $_GET['difficulte'] : '',
        isset($_GET['region']) ? $_GET['region'] : '',
        isset($_GET['prix_max']) ? $_GET['prix_max'] : ''
    );
} else {
    $listeRandonnees = Randonnee::getAllRandonnees();
}

// Participations de l'utilisateur connecté uniquement
$toutesParticipations = Participation::getParticipationsByUser($id_user);

// echo "<pre>";
// var_dump($toutesParticipations);
// echo "</pre>";

// On répartit les participations selon leur statut :
//   - 'en_attente' va dans "Mes demandes"
//   - 'acceptee'/'refusee' vont dans "Mon historique"
$mesDemandesEnAttente = [];
$monHistorique = [];
foreach ($toutesParticipations as $p) {
    if ($p['statut'] === 'en_attente') {
        $mesDemandesEnAttente[] = $p;
    } else {
        $monHistorique[] = $p;
    }
}

// Section active (utilisée par le JS pour afficher le bon bloc)
$section = isset($_GET['section']) ? $_GET['section'] : 'section-randonnees';

// On affiche la vue randonneur en lui passant toutes les variables ci-dessus
include "../views/ViewRandonneur.php";
?>
