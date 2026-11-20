<?php
// =====================================================================
// Contrôleur de connexion : reçoit le formulaire envoyé par ViewCnx.php
// Vérifie les identifiants et redirige vers la bonne interface (admin/user)
// =====================================================================

include_once "../models/User.php";
session_start();

// Si la page est appelée sans soumission de formulaire, on retourne au formulaire
// (ex : accès direct à l'URL du contrôleur)
if (empty($_POST)) {
    header("Location: ../views/ViewCnx.php");
    exit();
}

$message = '';

//var_dump($_POST); // pour vérifier les données reçues du formulaire

// Vérification que les deux champs sont remplis
if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    // Récupération des données du formulaire
    $email    = $_POST["email"];
    $password = $_POST["password"];

    // Création d'un objet User avec uniquement email + password (les autres champs ont des valeurs par défaut)
    $u = new User($email, $password);

    // connect() retourne true si l'utilisateur existe avec ce couple email/password
    if ($u->connect()) {
        // Connexion réussie — on stocke l'email dans la session pour identifier l'utilisateur
        $_SESSION["user"] = $email;

        // Selon le rôle, on redirige vers le panneau admin ou l'interface randonneur
        if ($u->getRole() === "admin") {
            $_SESSION["role"] = "admin";
            header('Location: ../controller/controlAdmin.php');
        } else {
            $_SESSION["role"] = "user";
            header('Location: ../controller/controlUser.php');
        }
        exit();
    } else {
        // Identifiants invalides : on prépare un message d'erreur
        $message = "Email ou mot de passe incorrect";
    }
} else {
    // Un champ au moins est vide
    $message = "Veuillez remplir tous les champs";
}

// On ré-affiche la vue de connexion avec le message d'erreur dans $message
include "../views/ViewCnx.php";
exit();
?>
