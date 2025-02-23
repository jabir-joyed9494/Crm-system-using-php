

<?php 
require_once 'db.php';

class Lead {

    public function addLead($name, $email, $phone) {
        global $conn;
        $temp = $conn->prepare("INSERT INTO Leads (name, email, phone) VALUES (?, ?, ?)");
        $temp->execute([$name, $email, $phone]);
    }

    public function searchLeadsByName($name){
        global $conn;
        $temp = $conn->prepare("SELECT * FROM Leads WHERE name LIKE ?");
        $temp->execute(['%' . $name . '%']);
        return  $temp->fetchAll();
    }

    public function getLeads() {
        global$conn;
        $temp = $conn->query("SELECT * FROM Leads");
        return  $temp->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteLead($id){
        global $conn;
        $temp = $conn->prepare("DELETE FROM Leads WHERE id = ?");
        return  $temp->execute([$id]);
    }

    public function updateLead($id, $name, $email, $phone) {
        global $conn;
        $temp =$conn->prepare("UPDATE Leads SET name = ?, email = ?, phone = ? WHERE id = ?");
        $temp->execute([$name, $email, $phone, $id]); 
    }   
    
}
