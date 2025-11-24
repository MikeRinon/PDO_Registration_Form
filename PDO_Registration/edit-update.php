<?php
require_once __DIR__ . '/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM applicants WHERE id = :id');
$stmt->execute([':id' => $id]);
$record = $stmt->fetch();
if (!$record) {
    header('Location: index.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name'] ?? '');
    $last = trim($_POST['last_name'] ?? '');
    $profession = trim($_POST['profession'] ?? '');
    $specialization = trim($_POST['specialization'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $city = trim($_POST['city'] ?? '');

    if ($first === '') $errors[] = 'First name is required.';
    if ($last === '') $errors[] = 'Last name is required.';
    if ($profession === '') $errors[] = 'Profession is required.';

    if (empty($errors)) {
        $sql = "UPDATE applicants SET first_name = :first, last_name = :last, profession = :profession, 
                specialization = :specialization, email = :email, phone = :phone, city = :city WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':first' => $first,
            ':last' => $last,
            ':profession' => $profession,
            ':specialization' => $specialization,
            ':email' => $email,
            ':phone' => $phone,
            ':city' => $city,
            ':id' => $id,
        ]);
        header('Location: index.php');
        exit;
    }
} else {
    $first = $record['first_name'];
    $last = $record['last_name'];
    $profession = $record['profession'];
    $specialization = $record['specialization'];
    $email = $record['email'];
    $phone = $record['phone'];
    $city = $record['city'];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Applicant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Edit Applicant</h1>
    <?php if ($errors): ?>
        <div class="errors"><ul><?php foreach($errors as $e){ echo '<li>'.htmlspecialchars($e).'</li>'; } ?></ul></div>
    <?php endif; ?>

    <form method="post">
        <label>First Name<br><input name="first_name" value="<?= htmlspecialchars($first) ?>"></label>
        <label>Last Name<br><input name="last_name" value="<?= htmlspecialchars($last) ?>"></label>
        <label>Profession<br><input name="profession" value="<?= htmlspecialchars($profession) ?>"></label>
        <label>Specialization / Focus<br><input name="specialization" value="<?= htmlspecialchars($specialization) ?>"></label>
        <label>Email<br><input name="email" value="<?= htmlspecialchars($email) ?>"></label>
        <label>Phone<br><input name="phone" value="<?= htmlspecialchars($phone) ?>"></label>
        <label>City<br><input name="city" value="<?= htmlspecialchars($city) ?>"></label>
        <div class="form-actions">
            <button type="submit" class="btn">Save</button>
            <a href="index.php" class="btn muted">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
