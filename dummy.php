<?php
require_once 'includes/crm.php'; 
$crm = new CRM();

// Get all leads
$leads = $crm->displayLeads();

if (isset($_GET['confirm_delete'])) {
    $delete_id = $_GET['confirm_delete'];
    $crm->deleteLead($delete_id);
    header("Location: display_lead.php?deleted=1");
    exit();
}

// Handle update form submission
if (isset($_POST['update_lead'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $website = $_POST['website'];
    
    $crm->updateLead($id, $name, $address, $website);
    header("Location: display_lead.php?updated=1"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Leads</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/display_lead.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">All Leads</h1>

        <?php if (empty($leads)): ?>
            <h3 class="text-center">No Lead Data Available</h3>
        <?php else: ?>
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-striped">
                    <thead class="table">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Website</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leads as $lead): ?>
                            <tr>
                                <td><?= $lead['id'] ?></td>
                                <td><?= htmlspecialchars($lead['name']) ?></td>
                                <td><?= htmlspecialchars($lead['address']) ?></td>
                                <td><a href="<?= htmlspecialchars($lead['website']) ?>" target="_blank"><?= htmlspecialchars($lead['website']) ?></a></td>
                                <td>
                                    <button class="btn btn-warning btn-sm update-btn" data-id="<?= $lead['id'] ?>" data-name="<?= htmlspecialchars($lead['name']) ?>" data-address="<?= htmlspecialchars($lead['address']) ?>" data-website="<?= htmlspecialchars($lead['website']) ?>" data-bs-toggle="modal" data-bs-target="#updateModal">Update</button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $lead['id'] ?>" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Update Lead Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header mdel-header-update">
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
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="updateAddress" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" class="form-control" id="updateWebsite" name="website" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-update" name="update_lead">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header model-header-delete">
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

    <!-- Success Modal (Auto-Close After 1s) -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-modal-header custom-modal-header-update">
                    <h5 class="modal-title" id="successModalLabel">Action Successful</h5>
                </div>
                <div class="modal-body text-center">
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

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- JavaScript for Handling Update and Delete -->
    <script>
        document.querySelectorAll('.update-btn').forEach(button => {
            button.addEventListener('click', function() {
                document.getElementById('updateId').value = this.getAttribute('data-id');
                document.getElementById('updateName').value = this.getAttribute('data-name');
                document.getElementById('updateAddress').value = this.getAttribute('data-address');
                document.getElementById('updateWebsite').value = this.getAttribute('data-website');
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                let deleteId = this.getAttribute('data-id');
                document.getElementById('confirmDeleteBtn').href = "display_lead.php?confirm_delete=" + deleteId;
            });
        });

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('updated')) {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();

            setTimeout(function() {
                successModal.hide();
            }, 1000);
        }

        if (urlParams.has('deleted')) {
            var deleteSuccessModal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
            deleteSuccessModal.show();

            setTimeout(function() {
                deleteSuccessModal.hide();
            }, 1000);
        }

        // Remove URL parameters after showing modal
        window.history.replaceState(null, "", window.location.pathname);
    </script>
</body>
</html>