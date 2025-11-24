<?php
require_once __DIR__ . '/db.php';

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
        $sql = "INSERT INTO applicants (first_name, last_name, profession, specialization, email, phone, city) 
                VALUES (:first, :last, :profession, :specialization, :email, :phone, :city)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':first' => $first,
            ':last' => $last,
            ':profession' => $profession,
            ':specialization' => $specialization,
            ':email' => $email,
            ':phone' => $phone,
            ':city' => $city,
        ]);
        header('Location: index.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Applicant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Add Applicant</h1>
    <?php if ($errors): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post">
        <label>First Name<br><input name="first_name" value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>"></label>
        <label>Last Name<br><input name="last_name" value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>"></label>
        <label>Profession (dream job)<br><input name="profession" value="<?= htmlspecialchars($_POST['profession'] ?? '') ?>"></label>
        <label>Specialization / Focus<br><input name="specialization" value="<?= htmlspecialchars($_POST['specialization'] ?? '') ?>"></label>
        <label>Email<br><input name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"></label>
        <label>Phone<br><input name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"></label>
        <label>City<br><input name="city" value="<?= htmlspecialchars($_POST['city'] ?? '') ?>"></label>
        <div class="form-actions">
            <button type="submit" class="btn">Save</button>
            <a href="index.php" class="btn muted">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
