

<?php 
require_once 'db.php';

class Lead {

    public function addLead($name, $email, $phone) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO Leads (name, email, phone) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $phone]);
    }

    public function searchLeadsByName($name){
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM Leads WHERE name LIKE ?");
        $stmt->execute(['%' . $name . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLeads() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM Leads");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteLead($id){
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM Leads WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateLead($id, $name, $email, $phone) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE Leads SET name = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->execute([$name, $email, $phone, $id]); 
    }   
    
}
