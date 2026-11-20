<?php
// =====================================================================
// Modèle Randonnee : représente une sortie randonnée organisée
// Chaque randonnée peut être associée à un bus (id_bus) — relation 1..n
// =====================================================================
class Randonnee {
    // Attributs privés représentant les colonnes de la table Randonnee
    private $id_randonnee;
    private $categorie;     // ex : montagne, désert, forêt, mer
    private $titre;
    private $description;
    private $date_debut;
    private $date_fin;
    private $region;
    private $distance;      // distance en km
    private $difficulte;    // ex : facile, moyen, difficile
    private $capacite;      // nombre maximum de participants
    private $image;         // nom du fichier photo
    private $id_bus;        // clé étrangère vers Bus (peut être NULL)
    private $date_creation; // date d'ajout dans la BD
    private $statut;        // ex : a_venir, en_cours, terminee
    private $prix;          // prix en TND

    // Constructeur : reçoit toutes les valeurs sauf id et date_creation
    public function __construct($categorie, $titre, $description, $date_debut, $date_fin,
                                $region, $distance, $difficulte, $capacite, $image,
                                $id_bus, $statut, $prix) {
        $this->categorie     = $categorie;
        $this->titre         = $titre;
        $this->description   = $description;
        $this->date_debut    = $date_debut;
        $this->date_fin      = $date_fin;
        $this->region        = $region;
        $this->distance      = $distance;
        $this->difficulte    = $difficulte;
        $this->capacite      = $capacite;
        $this->image         = $image;
        // Si aucun bus n'est fourni, on met NULL pour respecter la contrainte
        $this->id_bus        = $id_bus ? $id_bus : null;
        // La date de création est calculée automatiquement à la création de l'objet
        $this->date_creation = date('Y-m-d');
        $this->statut        = $statut;
        $this->prix          = $prix;
    }

    // Méthodes magiques (encapsulation)
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

    // __toString : ligne <tr> pour le tableau d'admin
    public function __toString() {
        return "<tr><td>".$this->id_randonnee."</td><td>".$this->titre."</td><td>".$this->categorie.
               "</td><td>".$this->date_debut."</td><td>".$this->date_fin."</td><td>".$this->region.
               "</td><td>".$this->difficulte."</td><td>".$this->prix." TND</td></tr>";
    }

    // Ajoute une randonnée et retourne son id
    public function ajouter() {
        include "../DataBase/connexion.php";
        $sql = $conn->prepare("INSERT INTO Randonnee (categorie, titre, description, date_debut, date_fin,
                              region, distance, difficulte, capacite, image, id_bus, date_creation, statut, prix)
                              VALUES (:cat, :titre, :desc, :debut, :fin, :region, :dist, :diff, :capa,
                              :image, :bus, :creation, :statut, :prix)");
        $sql->execute([
            ':cat'      => $this->categorie,
            ':titre'    => $this->titre,
            ':desc'     => $this->description,
            ':debut'    => $this->date_debut,
            ':fin'      => $this->date_fin,
            ':region'   => $this->region,
            ':dist'     => $this->distance,
            ':diff'     => $this->difficulte,
            ':capa'     => $this->capacite,
            ':image'    => $this->image,
            ':bus'      => $this->id_bus,
            ':creation' => $this->date_creation,
            ':statut'   => $this->statut,
            ':prix'     => $this->prix
        ]);
        // lastInsertId() retourne l'id généré par AUTO_INCREMENT
        // Utile pour nommer la photo "photo_<id>.jpg"
        return $conn->lastInsertId();
    }

    // Supprime une randonnée (les participations sont supprimées en cascade via la contrainte FK)
    public function supprimer() {
        include "../DataBase/connexion.php";
        $sql = $conn->prepare("DELETE FROM Randonnee WHERE id_randonnee = :id");
        $sql->execute([':id' => $this->id_randonnee]);
    }

    // Modifie une randonnée existante
    public function modifier() {
        include "../DataBase/connexion.php";
        $sql = $conn->prepare("UPDATE Randonnee SET categorie = :cat, titre = :titre, description = :desc,
                              date_debut = :debut, date_fin = :fin, region = :region, distance = :dist,
                              difficulte = :diff, capacite = :capa, image = :image, id_bus = :bus,
                              statut = :statut, prix = :prix WHERE id_randonnee = :id");
        $sql->execute([
            ':cat'    => $this->categorie,
            ':titre'  => $this->titre,
            ':desc'   => $this->description,
            ':debut'  => $this->date_debut,
            ':fin'    => $this->date_fin,
            ':region' => $this->region,
            ':dist'   => $this->distance,
            ':diff'   => $this->difficulte,
            ':capa'   => $this->capacite,
            ':image'  => $this->image,
            ':bus'    => $this->id_bus,
            ':statut' => $this->statut,
            ':prix'   => $this->prix,
            ':id'     => $this->id_randonnee
        ]);
    }

    // Retourne toutes les randonnées avec les infos du bus associé (jointure)
    public static function getAllRandonnees() {
        include "../DataBase/connexion.php";
        // LEFT JOIN : on récupère aussi les randonnées sans bus (id_bus NULL)
        $sql = $conn->query("SELECT r.*, b.immat_bus, b.nb_places
                            FROM Randonnee r
                            LEFT JOIN Bus b ON r.id_bus = b.id_bus
                            ORDER BY r.date_debut DESC");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retourne une randonnée par son id (avec immatriculation du bus)
    public static function getRandonneeById($id) {
        include "../DataBase/connexion.php";
        $sql = $conn->prepare("SELECT r.*, b.immat_bus FROM Randonnee r
                              LEFT JOIN Bus b ON r.id_bus = b.id_bus
                              WHERE r.id_randonnee = :id");
        $sql->execute([':id' => $id]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    // Recherche des randonnées selon des critères (filtre dynamique)
    // Les paramètres optionnels permettent de filtrer ou non sur chaque champ
    public static function chercherRandonnees($categorie = '', $difficulte = '', $region = '', $prix_max = '') {
        include "../DataBase/connexion.php";
        // On commence avec une requête de base toujours vraie (1=1)
        // afin de pouvoir ajouter des AND ... AND ... sans tester si c'est le 1er
        $requete = "SELECT r.*, b.immat_bus, b.nb_places FROM Randonnee r
                    LEFT JOIN Bus b ON r.id_bus = b.id_bus WHERE 1=1";
        $params = [];

        // On ajoute chaque condition uniquement si le critère est renseigné
        if (!empty($categorie)) {
            $requete .= " AND r.categorie = :categorie";
            $params[':categorie'] = $categorie;
        }
        if (!empty($difficulte)) {
            $requete .= " AND r.difficulte = :difficulte";
            $params[':difficulte'] = $difficulte;
        }
        if (!empty($region)) {
            // LIKE %...% pour une recherche partielle sur la région
            $requete .= " AND r.region LIKE :region";
            $params[':region'] = '%' . $region . '%';
        }
        if (!empty($prix_max)) {
            $requete .= " AND r.prix <= :prix_max";
            $params[':prix_max'] = $prix_max;
        }

        $requete .= " ORDER BY r.date_debut DESC";
        //echo $requete; 
        // var_dump($params);
        $sql = $conn->prepare($requete);
        $sql->execute($params);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
