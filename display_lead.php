<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
  include 'includes/crm.php';
  
   $crm = new CRM();
   $leads = [];
   $leads = $crm->displayLeads();

   if (isset($_GET['confirm_delete'])) {
    $delete_id = $_GET['confirm_delete'];
    echo $delete_id;
    $crm->deleteLead($delete_id);
    header("Location: display_lead.php?deleted=1");
    exit();
    }

    if (isset($_POST['update_lead'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $address = $_POST['email'];
        $website = $_POST['phone'];
        
        $crm->updateLead($id, $name, $address, $website);
        header("Location: display_lead.php?updated=1"); 
        exit();
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
    <link href="for-css/display-lead.css" rel="stylesheet">
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
                

                <?php if (isset($leads) && count($leads) > 0): ?>
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
                                <td><?= $lead['id'] ?></td>
                                <td><?= htmlspecialchars($lead['name']) ?></td>
                                <td><?= htmlspecialchars($lead['email']) ?></td>
                                <td><a href="<?= htmlspecialchars($lead['name']) ?>" target="_blank"><?= htmlspecialchars($lead['phone']) ?></a></td>
                                <td>

                                <button class="btn btn-warning btn-sm update-btn" data-id="<?= $lead['id'] ?>" 
                                data-name="<?= htmlspecialchars($lead['name']) ?>" data-email="<?= htmlspecialchars($lead['email']) 
                                ?>" data-phone="<?= htmlspecialchars($lead['phone']) ?>" data-bs-toggle="modal" 
                                data-bs-target="#updateModal">Update</button>

                                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $lead['id'] ?>"
                                     data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Delete</button>
                                </td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif (isset($leads)): ?>
            <p class="mt-4 text-danger">No leads found "<?= htmlspecialchars($name) ?>". Please try a different name.</p>
        <?php endif; ?>
          </div>



           <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this lead?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>

        <!-- Update Lead Modal -->
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Lead</h5>
                </div>
                <form method="POST" action="display_lead.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="updateId">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="updateName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="updateEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="updatePhone" name="phone" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="update_lead">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


      <!-- Success Modal (Auto-Close After 1s) -->
      <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" 
      aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="modal-title" id="successModalLabel">Action Successful</h5>
                    <p>The lead has been successfully updated.</p>
                </div>
            </div>
        </div>
    </div>

       <!-- Success Modal for Deletion (Auto-Close After 1s) -->
       <div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-labelledby="deleteSuccessModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-modal-header custom-modal-header-delete">
                    <h5 class="modal-title" id="deleteSuccessModalLabel">Action Successful</h5>
                </div>
                <div class="modal-body text-center">
                    <p>The lead has been successfully deleted.</p>
                </div>
            </div>
        </div>
    </div>

    </section>


    <!-- Bootstrap JavaScript and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
        //for fill up pop-up auto 
        document.querySelectorAll('.update-btn').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('updateId').value = this.getAttribute('data-id');
        document.getElementById('updateName').value = this.getAttribute('data-name');
        document.getElementById('updateEmail').value = this.getAttribute('data-email');
        document.getElementById('updatePhone').value = this.getAttribute('data-phone');
    });
});


        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                let deleteId = this.getAttribute('data-id');
                document.getElementById('confirmDeleteBtn').href = "display_lead.php?confirm_delete=" + deleteId;
            });
        });

              // Show success modal if lead was updated or deleted
              const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('updated') || urlParams.has('deleted')) {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();

            // Auto-close after 1 second (1000ms)
            setTimeout(function() {
                successModal.hide();
            }, 1000); 

            // Remove 'updated' or 'deleted' from the URL after showing the modal
            window.history.replaceState(null, "", window.location.pathname);
        }
    </script>
</body>
</html>
