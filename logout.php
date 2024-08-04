<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // Handle logout confirmation and redirection
    session_destroy();
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout | Trains Booking</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Logout Confirmation</h2>
    <p>Are you sure you want to logout?</p>
    <form method="post" id="logoutForm">
        <button type="submit" name="logout" class="btn btn-danger">Logout</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Modal -->
<!-- <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmLogoutBtn">Logout</button>
            </div>
        </div>
    </div>
</div> -->

<script src="js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var logoutForm = document.getElementById('logoutForm');
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));

        logoutForm.addEventListener('submit', function(event) {
            event.preventDefault();
            confirmModal.show();
        });

        var confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
        confirmLogoutBtn.addEventListener('click', function() {
            document.getElementById('logoutForm').submit();
        });
    });
</script>
</body>
</html>
