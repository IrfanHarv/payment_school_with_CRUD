<?php
function registerUser($pdo, $username, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    return $stmt->execute([$username, $hashed_password]);
}

function loginUser($pdo, $username, $password) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

function getBalance($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    return $user['balance'];
}

function topUpBalance($pdo, $userId, $amount) {
    $stmt = $pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
    return $stmt->execute([$amount, $userId]);
}

function makePayment($pdo, $userId, $amount, $description) {
    // Check if user has sufficient balance
    $currentBalance = getBalance($pdo, $userId);

    if ($currentBalance >= $amount) {
        $stmt = $pdo->prepare("INSERT INTO payments (user_id, amount, description) VALUES (?, ?, ?)");
        $paymentSuccess = $stmt->execute([$userId, $amount, $description]);

        if ($paymentSuccess) {
            $stmt = $pdo->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
            return $stmt->execute([$amount, $userId]);
        } else {
            return false; // Payment insertion failed
        }
    } else {
        return "Insufficient balance. Please top up your account.";
    }
}

function getPaymentHistory($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT * FROM payments WHERE user_id = ? ORDER BY payment_date DESC");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}
?>
