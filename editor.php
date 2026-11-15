<?php
require "config.php";
requireLogin();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $slug = strtolower(trim($_POST["slug"] ?? ""));
    $html = $_POST["html"] ?? "";

    if (
        $name === "" ||
        !preg_match('/^[a-z0-9-]{3,50}$/', $slug)
    ) {
        $message = "نام سایت یا آدرس معتبر نیست.";
    } elseif (strlen($html) > 500000) {
        $message = "حجم کد بیش از حد مجاز است.";
    } else {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO sites(user_id,site_name,slug,html_code)
                 VALUES(?,?,?,?)"
            );

            $stmt->execute([
                $_SESSION["user_id"],
                $name,
                $slug,
                $html
            ]);

            header("Location: dashboard.php");
            exit;
        } catch (PDOException $e) {
            $message = "این آدرس قبلاً استفاده شده است.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>ساخت سایت</title>
<style>
body{background:#0b1020;color:white;font-family:Tahoma;padding:20px}
input,textarea{width:100%;padding:12px;margin:10px 0;box-sizing:border-box;background:#192443;color:white;border:1px solid #555;border-radius:8px}
textarea{height:350px;direction:ltr;text-align:left;font-family:monospace}
button{padding:13px;background:#805cff;color:white;border:0;border-radius:8px}
</style>
</head>
<body>
<h2>ساخت سایت جدید</h2>

<form method="post">
<input name="name" placeholder="نام سایت" required>
<input name="slug" placeholder="آدرس انگلیسی، مثل ali" required>

<textarea name="html" placeholder="کد HTML سایت خود را اینجا وارد کن..." required></textarea>

<button>ذخیره سایت</button>
</form>

<p><?= htmlspecialchars($message) ?></p>
</body>
</html>
