<?php 
    include 'includes/crm.php';
     $crm = new CRM();
       $contacts = [];
       $nameErr = "";
       $name = "";
       if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(empty($_POST["name"])) {
            $nameErr = "Name is Requered";
        }
        else {
            $name = $_POST["name"];
        }

        if($nameErr === ""){
           $contacts = $crm->SearchContactById($name);
        }
       }
?>


<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

                <h4>SEARCH Contact</h4>
                 <div class="hero-section-lead-search">
                    <form action="" method="POST">
                     <label style="margin-bottom: 10px;">Search Contact By Name :</label>
                     <input type="text"  name="name"><br>
                     <span ><?php echo $nameErr;?></span><br>
                     <input type="submit" name="submit">
                    </form>
                </div>

                

                <?php if (isset($contacts) && count($contacts) > 0): ?>
            <div class="table-responsive mt-4">
                <h2 class="mb-4">Matching Contacts</h2>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>email</th>
                            <th>phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                            <tr>
                                <td><?php echo $contact['id'] ?></td>
                                <td><?php echo $contact['name']; ?></td>
                                <td><?php echo $contact['email'] ?></td>
                                <td><?php echo $contact['phone'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif (isset($contacts)): ?>
            <p class="mt-4 text-danger">No Contacts found with the name "<?php echo ($name) ?>". Please try a different name.</p>
        <?php endif; ?>
             
         
          </div>


    </section>
 </body>
</html>