<?php 

    require_once 'lead.php';
    class CRM {
    private $leads;

    public function __construct(){
         $this->leads=new Lead();
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

   }
?>