<?php
// =====================================================================
// Modèle Participation : représente la demande / inscription d'un user
// à une randonnée. C'est la table d'association entre User et Randonnee
// =====================================================================
class Participation {
    private $id_participation;
    private $id_user;        // clé étrangère vers User
    private $id_randonnee;   // clé étrangère vers Randonnee
    private $statut;         // 'en_attente', 'acceptee' ou 'refusee'
    private $date_creation;  // date+heure d'envoi de la demande

    // Constructeur : on ne crée une participation qu'à partir d'un user et d'une randonnée
    // Le statut initial est toujours 'en_attente' (l'admin doit valider)
    public function __construct($id_user, $id_randonnee) {
        $this->id_user       = $id_user;
        $this->id_randonnee  = $id_randonnee;
        $this->statut        = 'en_attente';
        $this->date_creation = date('Y-m-d H:i:s');
    }

    // Méthodes magiques d'accès
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

    // __toString : ligne <tr> simple pour debug ou affichage
    public function __toString() {
        return "<tr><td>".$this->id_participation."</td><td>".$this->id_user.
               "</td><td>".$this->id_randonnee."</td><td>".$this->statut."</td></tr>";
    }

    // Envoie une demande de participation
    // Retourne true, 'doublon', 'chevauchement' ou 'complet' selon les règles métier
    public function envoyer() {
        include "../DataBase/connexion.php";

        // 1) Vérifier si l'utilisateur a déjà une demande pour cette randonnée
        // (un user ne peut pas postuler 2 fois à la même rando)
        $sql = $conn->prepare("SELECT id_participation FROM Participation
                                 WHERE id_user = :uid AND id_randonnee = :rid");
        $sql->execute([':uid' => $this->id_user, ':rid' => $this->id_randonnee]);
        if ($sql->rowCount() > 0) return 'doublon';

        // 2) Récupérer les dates et la capacité de la randonnée demandée
        $sql = $conn->prepare("SELECT date_debut, date_fin, capacite FROM Randonnee WHERE id_randonnee = :rid");
        $sql->execute([':rid' => $this->id_randonnee]);
        $res = $sql->fetch(PDO::FETCH_ASSOC);
        // var_dump($res); // pour vérifier qu'on a bien récupéré la randonnée
        if (!$res) return false;

        // 3) Vérifier le chevauchement de dates avec les participations déjà acceptées de l'utilisateur
        // Algo classique de chevauchement : (debut1 < fin2) ET (fin1 > debut2)
        $sql = $conn->prepare(
            "SELECT p.id_participation FROM Participation p
             JOIN Randonnee r ON p.id_randonnee = r.id_randonnee
             WHERE p.id_user = :uid AND p.statut = 'acceptee'
             AND r.date_debut < :date_fin AND r.date_fin > :date_debut"
        );
        $sql->execute([
            ':uid'       => $this->id_user,
            ':date_fin'  => $res['date_fin'],
            ':date_debut'=> $res['date_debut']
        ]);
        if ($sql->rowCount() > 0) return 'chevauchement';

        // 4) Insertion finale : la demande est créée avec le statut 'en_attente'
        $sql = $conn->prepare("INSERT INTO Participation (id_user, id_randonnee, statut, date_creation)
                              VALUES (:uid, :rid, :statut, :creation)");
        $sql->execute([
            ':uid'      => $this->id_user,
            ':rid'      => $this->id_randonnee,
            ':statut'   => $this->statut,
            ':creation' => $this->date_creation
        ]);
        return true;
    }

    // Change le statut d'une participation (acceptee / refusee)
    // Si l'admin essaie d'accepter, on vérifie que la capacité n'est pas déjà atteinte
    public function changerStatut() {
        include "../DataBase/connexion.php";

        // Vérification de la capacité uniquement si on tente d'accepter
        if ($this->statut === 'acceptee') {
            // Compter le nombre de participations déjà acceptées pour cette randonnée
            $sql = $conn->prepare(
                "SELECT r.capacite, COUNT(p.id_participation) as nb_acceptes
                 FROM Randonnee r
                 LEFT JOIN Participation p ON r.id_randonnee = p.id_randonnee AND p.statut = 'acceptee'
                 WHERE r.id_randonnee = (SELECT id_randonnee FROM Participation WHERE id_participation = :id)
                 GROUP BY r.id_randonnee, r.capacite"
            );
            $sql->execute([':id' => $this->id_participation]);
            $res = $sql->fetch(PDO::FETCH_ASSOC);
            // echo "<pre>";
            // var_dump($res);
            // echo "</pre>";
            // Si le nombre d'acceptations atteint déjà la capacité, on refuse
            if ($res && $res['nb_acceptes'] >= $res['capacite']) return 'complet';
        }

        // Mise à jour effective du statut
        $sql = $conn->prepare("UPDATE Participation SET statut = :statut WHERE id_participation = :id");
        $sql->execute([':statut' => $this->statut, ':id' => $this->id_participation]);
        return true;
    }

    // Supprime une participation par son id (méthode statique : pas besoin d'instance)
    public static function supprimer($id) {
        include "../DataBase/connexion.php";
        $sql = $conn->prepare("DELETE FROM Participation WHERE id_participation = :id");
        $sql->execute([':id' => $id]);
    }

    // Retourne toutes les participations avec infos utilisateur et randonnée (jointures)
    public static function getAllParticipations() {
        include "../DataBase/connexion.php";
        // Jointure interne : on n'inclut que les participations qui ont bien un user et une rando existants
        $sql = $conn->query(
            "SELECT p.*, u.nom as nom_user, r.titre as titre_rando
             FROM Participation p
             JOIN User u ON p.id_user = u.id_user
             JOIN Randonnee r ON p.id_randonnee = r.id_randonnee
             ORDER BY p.date_creation DESC"
        );
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retourne uniquement les demandes en attente (vue admin)
    public static function getDemandesEnAttente() {
        include "../DataBase/connexion.php";
        $sql = $conn->query(
            "SELECT p.*, u.nom as nom_user, r.titre as titre_rando
             FROM Participation p
             JOIN User u ON p.id_user = u.id_user
             JOIN Randonnee r ON p.id_randonnee = r.id_randonnee
             WHERE p.statut = 'en_attente'
             ORDER BY p.date_creation DESC"
        );
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retourne toutes les participations d'un utilisateur (côté randonneur)
    public static function getParticipationsByUser($id_user) {
        include "../DataBase/connexion.php";
        $sql = $conn->prepare(
            "SELECT p.*, r.titre as titre_rando, r.date_debut, r.date_fin, r.region, r.categorie
             FROM Participation p
             JOIN Randonnee r ON p.id_randonnee = r.id_randonnee
             WHERE p.id_user = :uid
             ORDER BY p.date_creation DESC"
        );
        $sql->execute([':uid' => $id_user]);
        // var_dump($sql->fetchAll(PDO::FETCH_ASSOC));
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
