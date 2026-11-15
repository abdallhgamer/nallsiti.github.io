<?php
require "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$username]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($account && password_verify($password, $account["password"])) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = $account["id"];
        header("Location: dashboard.php");
        exit;
    }

    $message = "نام کاربری یا رمز عبور اشتباه است.";
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>ورود</title>
<style>
body{background:#10152b;color:white;font-family:Tahoma;text-align:center;padding:30px}
.box{max-width:400px;margin:50px auto;background:#202b49;padding:25px;border-radius:15px}
input{width:90%;padding:12px;margin:10px;border-radius:8px;border:0}
button{padding:12px 25px;background:#805cff;color:white;border:0;border-radius:8px}
</style>
</head>
<body>
<div class="box">
<h2>ورود به حساب</h2>
<form method="post">
<input name="username" placeholder="نام کاربری" required>
<input name="password" type="password" placeholder="رمز عبور" required>
<button>ورود</button>
</form>
<p><?= htmlspecialchars($message) ?></p>
</div>
</body>
</html>
