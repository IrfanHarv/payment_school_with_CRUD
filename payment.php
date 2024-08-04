<?php
session_start();
require 'includes/db.php';
require 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    $result = makePayment($pdo, $user_id, $amount, $description);

    if (is_string($result)) {
        // If makePayment returns a string, it means there was an error message
        $error = $result;
    } elseif ($result === false) {
        // If makePayment returns false, general payment failure
        $error = "Gagal melakukan pembayaran.";
    } else {
        // Payment successful, redirect to dashboard
        header("Location: dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayar Kuliah - E-Wallet Kuliah</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <h1 class="text-center mt-5">Bayar Kuliah</h1>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        <form action="payment.php" method="post">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Jumlah Pembayaran</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Pembayaran</label>
                                <input type="text" class="form-control" id="description" name="description" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Bayar</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
