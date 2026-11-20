<?php
// =====================================================================
// Connexion à la base de données MySQL via PDO
// Cette page est incluse partout où on a besoin de l'objet $conn
// =====================================================================

try
     {
         // Création d'un nouvel objet PDO :
         //  - 'mysql:host=localhost;dbname=randonnee_db' : SGBD utilisé, serveur, et nom de la BD
         //  - 'root' : nom d'utilisateur MySQL par défaut sous XAMPP
         //  - ''     : mot de passe vide (configuration locale par défaut)
        $BD= new PDO('mysql:host=localhost;dbname=randonnee_db','root','');
        // On garde aussi une variable $conn pour homogénéiser l'usage dans les modèles
        $conn = $BD;

        // var_dump($conn); // pour vérifier que la connexion est bien établie
     }
        catch(PDOException $e)
     {
         // En cas d'échec de connexion, on stoppe l'exécution et on affiche l'erreur
         die('Erreur : '.$e->getMessage());
     }
?>
