<?php
require "config.php";
requireLogin();

$id = (int)($_GET["id"] ?? 0);

$stmt = $pdo->prepare(
    "SELECT html_code FROM sites WHERE id=? AND user_id=?"
);

$stmt->execute([$id, $_SESSION["user_id"]]);
$site = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$site) {
    http_response_code(404);
    exit("سایت پیدا نشد.");
}

header("Content-Type: text/html; charset=utf-8");
echo $site["html_code"];
