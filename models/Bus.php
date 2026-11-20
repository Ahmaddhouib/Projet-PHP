<?php
// =====================================================================
// Modèle Bus : représente un bus utilisé pour transporter les randonneurs
// La classe encapsule les attributs d'un bus et les opérations CRUD
// =====================================================================
class Bus {
    // Attributs privés (encapsulation) — accessibles via __get / __set
    private $id_bus;       // identifiant auto-incrémenté en BD
    private $immat_bus;    // numéro d'immatriculation (unique)
    private $nb_places;    // nombre de places disponibles dans le bus
    private $chauffeur;    // nom du chauffeur
    private $tel_chauff;   // numéro de téléphone du chauffeur

    // Constructeur : appelé automatiquement à la création de l'objet
    // L'id n'est pas demandé car il est généré par MySQL (AUTO_INCREMENT)
    public function __construct($immat_bus, $nb_places, $chauffeur, $tel_chauff) {
        $this->immat_bus  = $immat_bus;
        $this->nb_places  = $nb_places;
        $this->chauffeur  = $chauffeur;
        $this->tel_chauff = $tel_chauff;
    }

    // Méthode magique __get : appelée quand on lit un attribut privé depuis l'extérieur
    public function __get($attr) {
        if (!isset($this->$attr)) return "erreur";
        else return ($this->$attr);
    }

    // Méthode magique __set : appelée quand on affecte une valeur à un attribut privé
    public function __set($attr, $value) {
        $this->$attr = $value;
    }

    // Méthode magique __isset : appelée par isset() sur un attribut privé
    public function __isset($attr) {
        return isset($this->$attr);
    }

    // Méthode magique __toString : appelée quand on echo l'objet
    // Ici on retourne directement une balise <option> pour les <select> de l'admin
    public function __toString() {
        return "<option value='".$this->id_bus."'>Bus #".$this->id_bus." — ".$this->immat_bus." (".$this->nb_places." places)</option>";
    }

    // Ajoute un bus (vérifie l'immatriculation en double)
    public function ajouter() {
        include "../DataBase/connexion.php";
        // 1) Vérifier qu'aucun bus n'a déjà la même immatriculation
        $sql = $conn->prepare("SELECT id_bus FROM Bus WHERE immat_bus = :immat");
        $sql->execute([':immat' => $this->immat_bus]);
        // var_dump($sql->rowCount()); // 0 = pas de doublon, >0 = déjà présent
        if ($sql->rowCount() > 0) return false;

        // 2) Insertion réelle dans la table Bus en utilisant des paramètres nommés (sécurité)
        $sql = $conn->prepare("INSERT INTO Bus (immat_bus, nb_places, chauffeur, tel_chauff)
                              VALUES (:immat, :places, :chauffeur, :tel)");
        $sql->execute([
            ':immat'    => $this->immat_bus,
            ':places'   => $this->nb_places,
            ':chauffeur'=> $this->chauffeur,
            ':tel'      => $this->tel_chauff
        ]);
        return true;
    }

    // Supprime un bus
    public function supprimer() {
        include "../DataBase/connexion.php";
        // Suppression par id : la contrainte ON DELETE SET NULL met à jour Randonnee.id_bus
        $sql = $conn->prepare("DELETE FROM Bus WHERE id_bus = :id");
        $sql->execute([':id' => $this->id_bus]);
    }

    // Modifie les informations d'un bus
    public function modifier() {
        include "../DataBase/connexion.php";
        // UPDATE complet : on met à jour tous les champs de l'enregistrement
        $sql = $conn->prepare("UPDATE Bus SET immat_bus = :immat, nb_places = :places,
                              chauffeur = :chauffeur, tel_chauff = :tel WHERE id_bus = :id");
        $sql->execute([
            ':immat'    => $this->immat_bus,
            ':places'   => $this->nb_places,
            ':chauffeur'=> $this->chauffeur,
            ':tel'      => $this->tel_chauff,
            ':id'       => $this->id_bus
        ]);
    }

    // Retourne tous les bus (méthode statique car ne dépend pas d'une instance)
    public static function getAllBus() {
        include "../DataBase/connexion.php";
        // query() : pas de paramètres, donc on évite prepare/execute
        $sql = $conn->query("SELECT * FROM Bus ORDER BY id_bus");
        // fetchAll renvoie un tableau associatif de toutes les lignes
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retourne un bus par son id
    public static function getBusById($id) {
        include "../DataBase/connexion.php";
        $sql = $conn->prepare("SELECT * FROM Bus WHERE id_bus = :id");
        $sql->execute([':id' => $id]);
        // fetch() : une seule ligne (ou false si rien trouvé)
        return $sql->fetch(PDO::FETCH_ASSOC);
    }
}
?>
