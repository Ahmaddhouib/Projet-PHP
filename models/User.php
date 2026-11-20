<?php
// =====================================================================
// Modèle User : représente un utilisateur (admin ou randonneur)
// Gère l'authentification, l'inscription et les opérations CRUD
// =====================================================================
class User {
    // Attributs privés (encapsulation)
    private $id_user;        // identifiant auto-incrémenté en BD
    private $nom;            // nom complet
    private $email;          // email — sert d'identifiant de connexion (unique)
    private $password;       // mot de passe (stocké en clair pour ce TP)
    private $role;           // 'admin' ou 'user'
    private $telephone;      // numéro de téléphone
    private $image_profile;  // nom du fichier photo de profil

    // Constructeur avec paramètres par défaut pour faciliter l'usage
    // (ex : un simple new User($email, $pwd) suffit pour la connexion)
    public function __construct($email, $password, $nom = '', $role = 'user', $telephone = '', $image_profile = 'default.png') {
        $this->email         = $email;
        $this->password      = $password;
        $this->nom           = $nom;
        $this->role          = $role;
        $this->telephone     = $telephone;
        $this->image_profile = $image_profile;
    }

    // Méthodes magiques d'accès aux attributs privés
    public function __get($attr) {
        if (!isset($this->$attr)) return "erreur";
        else return ($this->$attr);
    }

    public function __set($attr, $value) {
        $this->$attr = $value;
    }

    public function __isset($attr) {
        return isset($this->$attr);
    }

    // __toString : retourne directement une ligne <tr> pour l'affichage en table
    public function __toString() {
        return "<tr><td>".$this->id_user."</td><td>".$this->nom."</td><td>".$this->email."</td><td>".$this->role."</td><td>".$this->telephone."</td></tr>";
    }

    // Vérifie les identifiants de connexion
    public function connect() {
        include "../DataBase/connexion.php";
        // SELECT avec deux conditions : email + password
        $sql = $conn->prepare("SELECT id_user FROM User WHERE email = :email AND password = :password");
        $sql->execute([':email' => $this->email, ':password' => $this->password]);
        // var_dump($sql->rowCount()); // 1 = identifiants OK, 0 = identifiants invalides
        if ($sql->rowCount() > 0) return true;
        return false;
    }

    // Retourne le rôle de l'utilisateur (utilisé après connexion pour orienter la redirection)
    public function getRole() {
        include "../DataBase/connexion.php";
        $sql = $conn->prepare("SELECT role FROM User WHERE email = :email");
        $sql->execute([':email' => $this->email]);
        $res = $sql->fetch(PDO::FETCH_ASSOC);
        // Si rien trouvé on retourne 'user' par défaut (comportement défensif)
        return $res ? $res['role'] : 'user';
    }

    // Inscrit un nouvel utilisateur
    public function inscrire() {
        include "../DataBase/connexion.php";
        // 1) Vérifier qu'aucun compte n'utilise déjà cet email (unicité)
        $sql = $conn->prepare("SELECT id_user FROM User WHERE email = :email");
        $sql->execute([':email' => $this->email]);
        if ($sql->rowCount() > 0) return false;

        // 2) Insertion avec les paramètres nommés
        $sql = $conn->prepare("INSERT INTO User (nom, email, password, role, telephone, image_profile)
                              VALUES (:nom, :email, :password, :role, :telephone, :image_profile)");
        $sql->execute([
            ':nom'           => $this->nom,
            ':email'         => $this->email,
            ':password'      => $this->password,
            ':role'          => $this->role,
            ':telephone'     => $this->telephone,
            ':image_profile' => $this->image_profile
        ]);
        return true;
    }

    // Supprime un utilisateur par son id
    public function supprimer() {
        include "../DataBase/connexion.php";
        $sql = $conn->prepare("DELETE FROM User WHERE id_user = :id");
        $sql->execute([':id' => $this->id_user]);
    }

    // Modifie les informations d'un utilisateur (sans toucher au mot de passe)
    public function modifier() {
        include "../DataBase/connexion.php";
        // On met à jour tous les champs sauf le mot de passe (géré séparément)
        $sql = $conn->prepare("UPDATE User SET nom = :nom, email = :email, telephone = :telephone,
                              image_profile = :image_profile, role = :role WHERE id_user = :id");
        $sql->execute([
            ':nom'           => $this->nom,
            ':email'         => $this->email,
            ':telephone'     => $this->telephone,
            ':image_profile' => $this->image_profile,
            ':role'          => $this->role,
            ':id'            => $this->id_user
        ]);
    }

    // Modifie uniquement le mot de passe d'un utilisateur
    public function modifierPassword($nouveauPassword) {
        include "../DataBase/connexion.php";
        $sql = $conn->prepare("UPDATE User SET password = :password WHERE id_user = :id");
        $sql->execute([':password' => $nouveauPassword, ':id' => $this->id_user]);
    }

    // Retourne tous les utilisateurs (méthode statique)
    public static function getAllUsers() {
        include "../DataBase/connexion.php";
        $sql = $conn->query("SELECT * FROM User ORDER BY nom");
        // var_dump($sql->fetchAll(PDO::FETCH_ASSOC)); // pour vérifier le contenu
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retourne un utilisateur par son id (utile pour préremplir le modal d'édition)
    public static function getUserById($id) {
        include "../DataBase/connexion.php";
        $sql = $conn->prepare("SELECT * FROM User WHERE id_user = :id");
        $sql->execute([':id' => $id]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    // Retourne l'id d'un utilisateur à partir de son email
    // Sert après la connexion pour identifier l'utilisateur dans les requêtes
    public static function getIdByEmail($email) {
        include "../DataBase/connexion.php";
        $sql = $conn->prepare("SELECT id_user FROM User WHERE email = :email");
        $sql->execute([':email' => $email]);
        $res = $sql->fetch(PDO::FETCH_ASSOC);
        return $res ? $res['id_user'] : null;
    }
}
?>
