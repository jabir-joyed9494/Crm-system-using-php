<?php 

    require_once 'lead.php';
    require_once 'contact.php';
    class CRM {
    private $leads;
    private $contacts;

    public function __construct(){
         $this->leads=new Lead();
         $this->contacts= new Contact();
    }
    public function addLead($name , $email, $phone){
         $this->leads->addLead($name,$email,$phone);
    }
    public function searchLeadsByName($name){
      return $this->leads->searchLeadsByName($name);
    }
    public function displayLeads(){
        return $this->leads->getLeads();
    }
    public function deleteLead($delete_id){
     $this->leads->deleteLead($delete_id);
    }
    public function updateLead($id, $name, $email, $phone){
     $this->leads->updateLead($id, $name, $email, $phone);
    }

    public function searchContactByName($name){
       return $this->contacts->searchContactsByName($name);
    }

    public function addcontactbylead($name,$email,$phone,$leadid){
      $this->contacts->addcontactbylead($name,$email,$phone,$leadid);
    }
    public function SearchContactById($name){
      return $this->contacts->SearchContactById($name);
    }

    public function displayContact(){
      return $this->contacts->displayContact();
    }

   }
?>