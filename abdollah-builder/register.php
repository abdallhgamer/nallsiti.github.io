<?php
require "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username)) {
        $message = "نام کاربری باید ۳ تا ۳۰ حرف انگلیسی باشد.";
    } elseif (strlen($password) < 8) {
        $message = "رمز عبور باید حداقل ۸ کاراکتر باشد.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO users(username,password) VALUES(?,?)"
            );
            $stmt->execute([$username, $hash]);

            $message = "ثبت نام موفق بود. وارد حساب شو.";
        } catch (PDOException $e) {
            $message = "این نام کاربری قبلاً استفاده شده است.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>ثبت نام</title>
<style>
body{background:#10152b;color:white;font-family:Tahoma;text-align:center;padding:30px}
.box{max-width:400px;margin:50px auto;background:#202b49;padding:25px;border-radius:15px}
input{width:90%;padding:12px;margin:10px;border-radius:8px;border:0}
button{padding:12px 25px;background:#805cff;color:white;border:0;border-radius:8px}
</style>
</head>
<body>
<div class="box">
<h2>👑 ساخت حساب کاربری</h2>
<form method="post">
<input name="username" placeholder="نام کاربری" required>
<input name="password" type="password" placeholder="رمز عبور" required>
<button>ثبت نام</button>
</form>
<p><?= htmlspecialchars($message) ?></p>
<a href="login.php">ورود به حساب</a>
</div>
</body>
</html>
