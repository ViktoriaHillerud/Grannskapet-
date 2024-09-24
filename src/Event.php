<?php
class Event {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function createEvent($eventName, $time, $place, $id) {
        try {
            $query = "INSERT INTO events (EventName, time, place, user_id) 
                      VALUES (:eventName, :time, :place, :id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":eventName", $eventName);
            $stmt->bindParam(":time", $time);
            $stmt->bindParam(":place", $place);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
        }
    }

    public function getEventsForUserNeighbourGroups($id) {
        $query = "
            SELECT e.*
            FROM events e
            JOIN event_neighbourgroup eng ON e.id = eng.event_id
            JOIN user_neighbourgroup ung ON ung.group_id = eng.group_id
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
