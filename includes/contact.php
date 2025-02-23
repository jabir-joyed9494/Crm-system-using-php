<?php 
  require_once 'db.php';
   
   class Contact{
      public function searchContactsByName($name){
        global $conn;
        $temp = $conn->prepare("SELECT * FROM Leads WHERE name LIKE ?");
        $temp->execute(['%' . $name . '%']);
        return  $temp->fetchAll();
      }

      public function addcontactbylead($name,$email,$phone,$leadid){
        global $conn;
        $temp = $conn->prepare("INSERT INTO contacts (name, email, phone, leadid) VALUES (?, ?, ?, ?)");
        $temp->execute([$name, $email, $phone, $leadid]);
      }

      public function SearchContactById($name){
        global $conn;
        $temp = $conn->prepare("SELECT * FROM contacts WHERE name LIKE ?");
        $temp->execute(['%' . $name . '%']);
        return  $temp->fetchAll();
      }

      public function displayContact(){
        global $conn;
        $temp = $conn->query("SELECT * FROM contacts");
        return  $temp->fetchAll(PDO::FETCH_ASSOC);
      }
   }
?>