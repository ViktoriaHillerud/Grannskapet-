<?php
class Incident {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function createIncident($type, $descr, $place, $userId) {
        try {
            $query = "INSERT INTO incidents (type, descr, time, place, user_id) 
                      VALUES (:type, :descr, NOW(), :place, :userId)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":type", $type);
            $stmt->bindParam(":descr", $descr);
            $stmt->bindParam(":place", $place);
            $stmt->bindParam(":userId", $userId);
            $stmt->execute();
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
        }
    }

    public function getIncidentsForUserNeighbourGroups($id) {
        $query = "
            SELECT i.*
            FROM incidents i
            JOIN incident_neighbourgroup ing ON i.id = ing.incident_id
            JOIN user_neighbourgroup ung ON ung.group_id = ing.group_id
            WHERE ung.user_id = :id";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
			return [];
        }
    }
}
?>
