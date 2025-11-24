<?php
require_once __DIR__ . '/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        $stmt = $pdo->prepare('DELETE FROM applicants WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
    header('Location: index.php');
    exit;
}

// fetch record for display
$stmt = $pdo->prepare('SELECT * FROM applicants WHERE id = :id');
$stmt->execute([':id' => $id]);
$record = $stmt->fetch();
if (!$record) {
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Delete Applicant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Delete Applicant</h1>
    <p>Are you sure you want to delete <strong><?= htmlspecialchars($record['first_name'] . ' ' . $record['last_name']) ?></strong> (<?= htmlspecialchars($record['profession']) ?>)?</p>
    <form method="post">
        <button type="submit" name="confirm" value="yes" class="btn danger">Yes, delete</button>
        <a href="index.php" class="btn muted">Cancel</a>
    </form>
</div>
</body>
</html>
