<?php 
 error_reporting(E_ALL);
 ini_set('display_errors', 1); 
include 'includes/crm.php';
  
  $crm = new CRM();
  $nameErr="";
  $leads = [];
  $name="";

  if($_SERVER["REQUEST_METHOD"]=="POST"){
      if(empty($_POST["name"])){
        $nameErr = "Name is Required";
      }
      else{
        $name = $_POST["name"];
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $nameErr = "Only letters and white space allowed";
          }
      }

      if($nameErr === ""){
       $leads = $crm->searchContactByName($name);
      }
  }


   $contact_name = $contact_email = $contact_phone = "";
    //$lead_id;
    $contact_nameErr = $contact_emailErr = $contact_phoneErr = "";
    $crm= new CRM();

  if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(empty($_POST["contact-name"])){
       $contact_nameErr = "Name is Required"; 
    }
    else{
        $contact_name = $_POST["contact-name"];
    }

    if(empty($_POST["contact-email"])){
        $contact_emailErr = "Email is Required";
    }
    else{
        $contact_email = $_POST["contact-email"];
    }
    if(empty($_POST["contact-phone"])){
        $contact_phoneErr = "Phone is Required";
    }
    else{
        $contact_phone = $_POST["contact-phone"];
    }
    $leadId = $_POST["lead-id"] ?? '';
    if($contact_name !== "" && $contact_email !== "" && $contact_phone !== ""){
        $crm->addcontactbylead($contact_name, $contact_email, $contact_phone,$leadId);
    }
  }
?>

<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link href="navbar.css" rel="stylesheet">
    <link href="for-css/search-lead.css" rel="stylesheet">
</head>

<body>
     
       <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">CRM</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link text-white" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Leads Info
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Contact Info
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Display Leads and Contacts</a>
                </li>
            </ul>
        </div>
    </nav>


    <section class="hero-section">
    <div class="hero-section-layer-1">
            
               <h4>SEARCH LEAD</h4>
                 <div class="hero-section-lead-search">
                   <form action="" method="POST">
                    <label>Search Lead by Name :</label>
                    <input type="text" name="name"><br>
                    <!-- <span><?php echo $nameErr ?></span> -->
                    <input type="submit" name="submit">
                   </form>
                </div>

               <?php if(isset($leads) && count($leads)): ?>
                <div class="table-responsive mt-4">
                <h2 class="mb-4">Matching Leads</h2>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>email</th>
                            <th>phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php foreach ($leads as $lead): ?>
                          <tr>
                                <td><?php echo $lead['id'] ?></td>
                               <td><?php echo $lead['name'] ?></td>
                               <td><?php echo $lead['email'] ?> </td>
                               <td><?php echo $lead['phone'] ?> </td>
                               <td>

                                <button class="btn btn-warning btn-sm select-lead-btn" data-id="<?php echo $lead['id']; ?>" 
                                    data-bs-toggle="modal" data-bs-target="#addContact">Select Lead</button>


                               </td>
                          </tr>
                       <?php endforeach ?>
                    </tbody>
                </table>

                <?php elseif(isset($leads)): ?>
                    <p class="mt-4 text-danger">No leads found with the name "<?= htmlspecialchars($name) ?>". Please try a different name.</p>
                    <?php endif ?>               
            </div>  
    </div>

      <div class="modal fade" id="addContact" tabindex="-1" aria-labelledby="addContactLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                 <div class="modal-header">
                      <h5>Contact Info:</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                 </div>
                 <div class="modal-body">
                <form action="add_contact.php" method="POST">
                <div class="mb-3">

                     <input type="hidden" name="lead-id" id="lead-id">
                        <label for="contact-id" class="form-label">Contact Id</label>
                        <input type="text" class="form-control" name="contact-id" placeholder="Enter contact id">
                    </div>
                    <div class="mb-3">
                        <label for="contact-name" class="form-label">Contact Name</label>
                        <input type="text" class="form-control" name="contact-name" placeholder="Enter contact name">
                    </div>
                    <div class="mb-3">
                        <label for="contact-email" class="form-label">Contact Email</label>
                        <input type="email" class="form-control" name="contact-email" placeholder="Enter contact email">
                    </div>
                    <div class="mb-3">
                        <label for="contact-phone" class="form-label">Contact Phone</label>
                        <input type="text" class="form-control" name="contact-phone" placeholder="Enter contact phone">
                    </div>
                    <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" name="submit"> 
                </div>
                </form>
                </div>
           
              </div>
            </div>

                </div>


    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>



    <script>
document.addEventListener("DOMContentLoaded", function() {
    let buttons = document.querySelectorAll('.select-lead-btn');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            let leadId = this.getAttribute('data-id');
            document.getElementById("lead-id").value = leadId;
           
        });
    });
});
</script>

</body>
</html>