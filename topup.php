<?php
session_start();
require 'includes/db.php';
require 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $user_id = $_SESSION['user_id'];

    if (topUpBalance($pdo, $user_id, $amount)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Gagal menambah saldo.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up Saldo - E-Wallet Kuliah</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <h1 class="text-center mt-5">Top Up Saldo</h1>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        <form action="topup.php" method="post">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Jumlah Top Up</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Top Up</button>
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
