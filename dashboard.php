<?php
require "config.php";
requireLogin();

$stmt = $pdo->prepare(
    "SELECT * FROM sites WHERE user_id=? ORDER BY id DESC"
);
$stmt->execute([$_SESSION["user_id"]]);
$sites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>پنل کاربری</title>
<style>
body{background:#0b1020;color:white;font-family:Tahoma;padding:20px}
.box{background:#192443;padding:20px;border-radius:12px;margin:15px 0}
button{padding:12px;background:#805cff;color:white;border:0;border-radius:8px}
a{color:#b5a0ff}
</style>
</head>
<body>
<h2>👑 پنل کاربری</h2>
<a href="editor.php"><button>ساخت سایت جدید</button></a>
<a href="logout.php">خروج</a>

<h3>سایت‌های من</h3>

<?php foreach ($sites as $site): ?>
<div class="box">
<h3><?= htmlspecialchars($site["site_name"]) ?></h3>
<p>آدرس: <?= htmlspecialchars($site["slug"]) ?>.html</p>
<a href="publish.php?id=<?= (int)$site["id"] ?>">مشاهده سایت</a>
</div>
<?php endforeach; ?>

</body>
</html>
