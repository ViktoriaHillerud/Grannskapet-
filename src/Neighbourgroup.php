<?php
class Neighbourgroup {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function createNeighbourgroup($NName, $place, $descr) {
        try {
            $query = "INSERT INTO neighbourgroups (NName, place, descr) VALUES (:NName, :place, :descr)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":NName", $NName);
            $stmt->bindParam(":place", $place);
            $stmt->bindParam(":descr", $descr);
            $stmt->execute();
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
        }
    }

    public function getGroupsForUser($id) {
        $query = "
            SELECT ng.*
            FROM neighbourgroups ng
            JOIN user_neighbourgroup ung ON ng.id = ung.group_id
            WHERE ung.user_id = :id";
        
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
        }
    }

    // Hämta alla meddelanden kopplade till grannskapsgrupper som användaren är medlem i
    public function getMessagesForUserNeighbourGroups($id) {
        $query = "
            SELECT m.*
            FROM messages m
            JOIN message_neighbourgroup mng ON m.id = mng.message_id
            JOIN user_neighbourgroup ung ON ung.group_id = mng.group_id
            WHERE ung.user_id = :id;
        ";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
            return [];
        }
    }
}
?>
