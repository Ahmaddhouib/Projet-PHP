<?php
// =====================================================================
// Contrôleur Admin : gère toutes les actions du tableau de bord administrateur
//   - CRUD Randonnées
//   - CRUD Bus
//   - Validation des participations (accepter / refuser / supprimer)
//   - CRUD Utilisateurs
// À la fin, prépare les variables pour ViewAdmin.php et l'inclut
// =====================================================================

include_once "../models/User.php";
include_once "../models/Bus.php";
include_once "../models/Randonnee.php";
include_once "../models/Participation.php";

// Vérification de la session : seul un admin connecté peut accéder à cette page
session_start();
if (!isset($_SESSION["user"]) || $_SESSION["role"] !== 'admin') {
    header('Location: control-cnx.php');
    exit();
}

$email = $_SESSION["user"];
$message = '';

// echo "<pre>";
// var_dump($_POST); // pour voir tout ce qui est envoyé par les formulaires
// echo "</pre>";

// ============================================================
// RANDONNÉES — CRUD
// ============================================================

// Ajouter une randonnée
if (isset($_POST['ajouter_rando'])) {

    // Validation côté serveur des champs obligatoires
    if (empty($_POST['titre']) || empty($_POST['categorie']) || empty($_POST['date_debut']) ||
        empty($_POST['date_fin']) || empty($_POST['region']) || empty($_POST['difficulte']) ||
        empty($_POST['prix'])) {
        echo "<script>alert('Veuillez remplir tous les champs obligatoires.');</script>";
    } else {
        // Création de l'objet Randonnee à partir des données du formulaire
        // Les champs facultatifs (distance, capacite, id_bus) reçoivent des valeurs par défaut
        $rando = new Randonnee(
            $_POST['categorie'],
            $_POST['titre'],
            $_POST['description'],
            $_POST['date_debut'],
            $_POST['date_fin'],
            $_POST['region'],
            !empty($_POST['distance']) ? $_POST['distance'] : 0,
            $_POST['difficulte'],
            !empty($_POST['capacite']) ? $_POST['capacite'] : 0,
            'default_rando.png',
            !empty($_POST['id_bus']) ? $_POST['id_bus'] : null,
            $_POST['statut'],
            $_POST['prix']
        );
        // Insertion en BD : on récupère l'id généré (utile pour nommer la photo)
        $idRando = $rando->ajouter();

        // Upload de la photo (même logique que dans le cours sur les fichiers)
        //var_dump($_FILES);
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $fichier = $_FILES['photo'];

            // Contrôle de la taille : maximum 5 Mo (5 000 000 octets)
            if ($fichier['size'] > 5000000) {
                echo "<script>alert('Taille maximale : 5Mo.');</script>";
            } else {
                // Contrôle du type : seul le JPEG est accepté pour les photos de randonnée
                $allowed_file_types = array('jpg', 'jpeg');
                $file_info = pathinfo($fichier['name']);
                if (in_array(strtolower($file_info['extension']), $allowed_file_types)) {
                    // Construction du nom : photo_<idRando>.jpg (lié à l'id de la rando)
                    $uploadDir = "../Randonnée-photo/";
                    $nom_destination = "photo_" . $idRando . ".jpg";
                    $destination = $uploadDir . $nom_destination;
                    // Déplacement du fichier temporaire vers le dossier final
                    if (move_uploaded_file($fichier['tmp_name'], $destination)) {
                        // Mettre à jour le champ image dans la BD avec le nouveau nom de fichier
                        include "../DataBase/connexion.php";
                        $sql = $BD->prepare("UPDATE Randonnee SET image = :img WHERE id_randonnee = :id");
                        $sql->execute([':img' => $nom_destination, ':id' => $idRando]);
                    }
                } else {
                    echo "<script>alert('Type de fichier non autorisé. Seul le JPEG est accepté.');</script>";
                }
            }
        }

        // Redirection JavaScript après ajout pour afficher la liste mise à jour
        echo "<script>alert('Randonnée ajoutée avec succès.');
              window.location.href='controlAdmin.php?section=section-randonnees';</script>";
        exit();
    }
}

// Modifier une randonnée
if (isset($_POST['modifier_rando'])) {
    if (empty($_POST['id_randonnee']) || empty($_POST['titre'])) {
        echo "<script>alert('Données manquantes pour la modification.');</script>";
    } else {
        // Création d'un nouvel objet Randonnee avec les nouvelles valeurs du formulaire
        $rando = new Randonnee(
            $_POST['categorie'],
            $_POST['titre'],
            $_POST['description'],
            $_POST['date_debut'],
            $_POST['date_fin'],
            $_POST['region'],
            !empty($_POST['distance']) ? $_POST['distance'] : 0,
            $_POST['difficulte'],
            !empty($_POST['capacite']) ? $_POST['capacite'] : 0,
            '',
            !empty($_POST['id_bus']) ? $_POST['id_bus'] : null,
            $_POST['statut'],
            $_POST['prix']
        );
        // On affecte l'id (passé dans le champ caché) pour cibler la bonne ligne en BD
        $rando->id_randonnee = $_POST['id_randonnee'];

        // Conserver l'image existante si aucune nouvelle photo n'est uploadée
        $randoActuelle = Randonnee::getRandonneeById($_POST['id_randonnee']);
        $rando->image  = $randoActuelle['image'];

        // Upload de la nouvelle photo si présente (même contrôle qu'à l'ajout)
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $fichier = $_FILES['photo'];
            if ($fichier['size'] > 5000000) {
                echo "<script>alert('Taille maximale : 5Mo.');</script>";
            } else {
                $allowed_file_types = array('jpg', 'jpeg');
                $file_info = pathinfo($fichier['name']);
                if (in_array(strtolower($file_info['extension']), $allowed_file_types)) {
                    $uploadDir = "../Randonnée-photo/";
                    // Le nom est basé sur l'id, donc l'ancienne photo est écrasée
                    $nom_destination = "photo_" . $_POST['id_randonnee'] . ".jpg";
                    $destination = $uploadDir . $nom_destination;
                    if (move_uploaded_file($fichier['tmp_name'], $destination)) {
                        $rando->image = $nom_destination;
                    }
                } else {
                    echo "<script>alert('Type de fichier non autorisé. Seul le JPEG est accepté.');</script>";
                }
            }
        }

        // Mise à jour finale en BD
        $rando->modifier();
        echo "<script>alert('Randonnée modifiée avec succès.');
              window.location.href='controlAdmin.php?section=section-randonnees';</script>";
        exit();
    }
}

// Supprimer une randonnée (action déclenchée par un lien GET)
if (isset($_GET['supprimer_rando'])) {
    // Objet Randonnee "vide" : on ne renseigne que l'id pour appeler supprimer()
    $rando = new Randonnee('', '', '', '', '', '', 0, '', 0, '', null, 'en_cours', 0);
    $rando->id_randonnee = $_GET['supprimer_rando'];
    $rando->supprimer();
    echo "<script>alert('Randonnée supprimée.');
          window.location.href='controlAdmin.php?section=section-randonnees';</script>";
    exit();
}

// ============================================================
// BUS — CRUD
// ============================================================

// Ajouter un bus
if (isset($_POST['ajouter_bus'])) {
    // Validation : tous les champs du bus sont obligatoires
    if (empty($_POST['immat_bus']) || empty($_POST['nb_places']) ||
        empty($_POST['chauffeur']) || empty($_POST['tel_chauff'])) {
        echo "<script>alert('Veuillez remplir tous les champs du bus.');</script>";
    } else {
        $bus = new Bus($_POST['immat_bus'], $_POST['nb_places'], $_POST['chauffeur'], $_POST['tel_chauff']);
        // ajouter() retourne false si l'immatriculation existe déjà (contrainte d'unicité)
        if ($bus->ajouter()) {
            echo "<script>alert('Bus ajouté avec succès.');
                  window.location.href='controlAdmin.php?section=section-bus';</script>";
            exit();
        } else {
            echo "<script>alert('Cette immatriculation existe déjà.');</script>";
        }
    }
}

// Modifier un bus
if (isset($_POST['modifier_bus'])) {
    if (empty($_POST['id_bus'])) {
        echo "<script>alert('ID bus manquant.');</script>";
    } else {
        $bus = new Bus($_POST['immat_bus'], $_POST['nb_places'], $_POST['chauffeur'], $_POST['tel_chauff']);
        // Affectation de l'id via le setter magique pour cibler le bon bus
        $bus->id_bus = $_POST['id_bus'];
        $bus->modifier();
        echo "<script>alert('Bus modifié avec succès.');
              window.location.href='controlAdmin.php?section=section-bus';</script>";
        exit();
    }
}

// Supprimer un bus
if (isset($_GET['supprimer_bus'])) {
    $bus = new Bus('', 0, '', ''); // objet vide juste pour appeler la méthode
    $bus->id_bus = $_GET['supprimer_bus'];
    $bus->supprimer();
    echo "<script>alert('Bus supprimé.');
          window.location.href='controlAdmin.php?section=section-bus';</script>";
    exit();
}

// ============================================================
// PARTICIPATIONS — Accepter / Refuser / Supprimer
// ============================================================

// Accepter une demande
if (isset($_POST['accepter'])) {
    // On crée une participation "vide" puis on lui affecte l'id et le nouveau statut
    $p = new Participation(0, 0);
    $p->id_participation = $_POST['id_participation'];
    $p->statut = 'acceptee';
    // changerStatut() retourne 'complet' si la capacité de la randonnée est dépassée
    $resultat = $p->changerStatut();
    if ($resultat === 'complet') {
        echo "<script>alert('Impossible : la capacité maximale est atteinte.');</script>";
    } else {
        echo "<script>alert('Demande acceptée.');
              window.location.href='controlAdmin.php?section=section-demandes';</script>";
        exit();
    }
}

// Refuser une demande
if (isset($_POST['refuser'])) {
    $p = new Participation(0, 0);
    $p->id_participation = $_POST['id_participation'];
    $p->statut = 'refusee';
    $p->changerStatut();
    echo "<script>alert('Demande refusée.');
          window.location.href='controlAdmin.php?section=section-demandes';</script>";
    exit();
}

// Supprimer une participation (suppression définitive)
if (isset($_GET['supprimer_part'])) {
    // supprimer() est statique : on l'appelle directement sur la classe
    Participation::supprimer($_GET['supprimer_part']);
    echo "<script>alert('Participation supprimée.');
          window.location.href='controlAdmin.php?section=section-demandes';</script>";
    exit();
}

// Ajouter une participation directement (admin) : crée + accepte en un seul coup
if (isset($_POST['ajouter_participation'])) {
    if (empty($_POST['id_user_part']) || empty($_POST['id_randonnee_part'])) {
        echo "<script>alert('Veuillez sélectionner un utilisateur et une randonnée.');</script>";
    } else {
        $p = new Participation($_POST['id_user_part'], $_POST['id_randonnee_part']);
        // envoyer() applique les règles métier (doublon, chevauchement)
        $resultat = $p->envoyer();
        if ($resultat === true) {
            // L'admin peut court-circuiter la validation : on accepte directement
            include "../DataBase/connexion.php";
            $sql = $BD->prepare("UPDATE Participation SET statut = 'acceptee'
                                  WHERE id_user = :uid AND id_randonnee = :rid");
            $sql->execute([':uid' => $_POST['id_user_part'], ':rid' => $_POST['id_randonnee_part']]);
            echo "<script>alert('Participant ajouté avec succès.');
                  window.location.href='controlAdmin.php?section=section-demandes';</script>";
            exit();
        } elseif ($resultat === 'doublon') {
            echo "<script>alert('Cet utilisateur a déjà une demande pour cette randonnée.');</script>";
        } else {
            echo "<script>alert('Erreur lors de l\'ajout du participant.');</script>";
        }
    }
}

// ============================================================
// UTILISATEURS — CRUD
// ============================================================

// Ajouter un utilisateur
if (isset($_POST['ajouter_user'])) {
    if (empty($_POST['nom']) || empty($_POST['email']) || empty($_POST['password'])) {
        echo "<script>alert('Veuillez remplir les champs obligatoires.');</script>";
    } else {
        $u = new User($_POST['email'], $_POST['password'], $_POST['nom'],
                      $_POST['role'], $_POST['telephone'], 'default.png');

        // Upload photo de profil si présente (jpg, png, gif acceptés)
        if (isset($_FILES['image_profile']) && $_FILES['image_profile']['error'] == 0) {
            $fichier = $_FILES['image_profile'];
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            $file_info = pathinfo($fichier['name']);
            if (in_array(strtolower($file_info['extension']), $allowed)) {
                // Nom unique basé sur le timestamp pour éviter les collisions à l'ajout
                $nom_img = 'user_' . time() . '.' . $file_info['extension'];
                move_uploaded_file($fichier['tmp_name'], "../Randonnée-photo/" . $nom_img);
                $u->image_profile = $nom_img;
            }
        }
        // inscrire() retourne false si l'email est déjà utilisé (unicité)
        if ($u->inscrire()) {
            echo "<script>alert('Utilisateur ajouté avec succès.');
                  window.location.href='controlAdmin.php?section=section-participants';</script>";
            exit();
        } else {
            echo "<script>alert('Cet email est déjà utilisé.');</script>";
        }
    }
}

// Modifier un utilisateur
if (isset($_POST['modifier_user'])) {
    if (empty($_POST['id_user'])) {
        echo "<script>alert('ID utilisateur manquant.');</script>";
    } else {
        // On ne touche pas au mot de passe ici (chaîne vide), il sera changé séparément si fourni
        $u = new User($_POST['email'], '', $_POST['nom'], $_POST['role'], $_POST['telephone']);
        $u->id_user = $_POST['id_user'];
        // On récupère la photo actuelle pour la conserver par défaut (si pas de nouvelle photo)
        $userActuel = User::getUserById($_POST['id_user']);
        $u->image_profile = $userActuel['image_profile'];

        // Upload nouvelle photo de profil si présente
        if (isset($_FILES['image_profile']) && $_FILES['image_profile']['error'] == 0) {
            $fichier = $_FILES['image_profile'];
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            $file_info = pathinfo($fichier['name']);
            if (in_array(strtolower($file_info['extension']), $allowed)) {
                // Nom basé sur l'id pour écraser systématiquement l'ancienne photo
                $nom_img = 'user_' . $_POST['id_user'] . '.' . $file_info['extension'];
                move_uploaded_file($fichier['tmp_name'], "../Randonnée-photo/" . $nom_img);
                $u->image_profile = $nom_img;
            }
        }

        $u->modifier();

        // Changer le mot de passe uniquement si l'admin a saisi un nouveau mot de passe
        if (!empty($_POST['password'])) {
            $u->modifierPassword($_POST['password']);
        }

        echo "<script>alert('Utilisateur modifié avec succès.');
              window.location.href='controlAdmin.php?section=section-participants';</script>";
        exit();
    }
}

// Supprimer un utilisateur
if (isset($_GET['supprimer_user'])) {
    $u = new User('', '');
    $u->id_user = $_GET['supprimer_user'];
    $u->supprimer();
    echo "<script>alert('Utilisateur supprimé.');
          window.location.href='controlAdmin.php?section=section-participants';</script>";
    exit();
}

// ============================================================
// RÉCUPÉRATION DES DONNÉES POUR LA VUE
// ============================================================

// Recherche des randonnées (si filtre appliqué) ou liste complète sinon
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

// Données partagées par toutes les sections de l'admin (chargées à chaque appel)
$listeBus             = Bus::getAllBus();
$demandesEnAttente    = Participation::getDemandesEnAttente();
$toutesParticipations = Participation::getAllParticipations();
$listeUsers           = User::getAllUsers();

// Données pour les modals d'édition (préremplissage à partir de l'id passé en GET)
$randoMod = isset($_GET['edit_rando'])   ? Randonnee::getRandonneeById($_GET['edit_rando']) : null;
$busMod   = isset($_GET['edit_bus'])     ? Bus::getBusById($_GET['edit_bus'])               : null;
$userMod  = isset($_GET['edit_user'])    ? User::getUserById($_GET['edit_user'])            : null;

// Section active (pour que spa-navigation.js sache quelle section afficher au chargement)
$section = isset($_GET['section']) ? $_GET['section'] : 'section-randonnees';

// echo "<pre>";
// var_dump($listeRandonnees);
// echo "</pre>";

// On délègue maintenant l'affichage à la vue admin (modèle MVC)
include "../views/ViewAdmin.php";
?>
