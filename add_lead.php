<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/crm.php';
    $crm = new CRM();

             $name = $email = $phone="";
               $nameErr = $emailErr = $phoneErr = "";
               $submitted = false;
               $result = "";

               if($_SERVER["REQUEST_METHOD"]=="POST"){
                if(empty($_POST["name"])) {
                    $nameErr="Name is required";
                 }
                 else {
                   $name =($_POST["name"]);
                   if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                       $nameErr = "Only letters and white space allowed";
                     }
                 }

                 if(empty($_POST["email"])){
                    $emailErr = "Email is required";
                 }
                 else{
                    $email = ($_POST["email"]);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $emailErr = "Invalid email format";
                      }
                 }

                 if(empty($_POST["phone"])){
                    $phoneErr = "phone is required";
                 }
                 else{
                    $phone = ($_POST["phone"]);
                    if (!preg_match("/^\+?[0-9\s\-\(\)]{7,15}$/", $phone)) {
                        $phoneErr = "Invalid phone number format";
                    }
                 }

                }

                 if($nameErr === "" && $emailErr === "" && $phoneErr === "" && ($name !== "")){
                    $crm->addLead($name,$email,$phone);
                    $submitted = true;
                    $result = "Successfully Added!";
                 } 
             ?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link href="navbar.css" rel="stylesheet">
    <link href="for-css/add-lead.css" rel="stylesheet">
</head>
<body>
     <?php
      
     ?>
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
           <div class="hero-section-container-1">
                
             <div> 


               <div class="hero-section-heading">
               <h4>Leads Information : </h4>
               <h4>Your OutPut :</h4>
               </div>
                <div class="hero-section-input-output">
                    <div>
                        <form method="post" action="add_lead.php">

                       <label> Name :</label> <input type="text" name="name" <?php if ($submitted) echo 'disabled'; ?>>
                        <span class="error">* <?php echo $nameErr;?>  </span><br>

                        <label>Email:</label> <input type="text" name="email" <?php if ($submitted) echo 'disabled'; ?>>
                         <span class="error">* <?php echo $emailErr; ?> </span><br>

                        <label>Phone:</label> <input type="text" name="phone" <?php if ($submitted) echo 'disabled'; ?>>
                        <span class="error">*<?php echo $phoneErr; ?> </span><br><br>

                         <input type="submit" name="submit">
                         
                        </form>

                    </div>
                    <div class="hero-section-output">
                    <?php
                       if($nameErr==="" && $emailErr==="" && $phoneErr==""){

                           if($submitted){
                            echo '<p style="color: green; font-weight: bold; font-size: 18px; text-align: center;">' . $result . '</p>';
                           }
                       }
                    ?>
                    </div>
                </div>
             </div>

           </div>
    </section>



    <!-- Bootstrap JavaScript and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>
</body>
</html>
