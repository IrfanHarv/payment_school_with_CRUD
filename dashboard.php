<?php
session_start();
require 'includes/db.php';
require 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$balance = getBalance($pdo, $user_id);
$history = getPaymentHistory($pdo, $user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - E-Wallet Kuliah</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container">
        <h1 class="text-center mt-5">Dashboard</h1>
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Saldo: Rp<?= number_format($balance, 2) ?></h2>
                        <a href="topup.php" class="btn btn-success">Top Up Saldo</a>
                        <a href="payment.php" class="btn btn-primary">Bayar Kuliah</a>
                        <h3 class="mt-4">Riwayat Pembayaran</h3>
                        <?php if (empty($history)): ?>
                            <p>Tidak ada riwayat pembayaran.</p>
                        <?php else: ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($history as $index => $payment): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= htmlspecialchars($payment['description']) ?></td>
                                            <td>Rp<?= number_format($payment['amount'], 2) ?></td>
                                            <td><?= date('d F Y H:i:s', strtotime($payment['payment_date'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
