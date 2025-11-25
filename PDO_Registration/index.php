<?php
require_once __DIR__ . '/db.php';

$search = '';
if (isset($_GET['search'])) {
    $search = trim((string) $_GET['search']);
}

try {
    if ($search !== '') {
        $stmt = $pdo->prepare("SELECT * FROM applicants WHERE first_name LIKE ? OR last_name LIKE ? OR profession LIKE ? ORDER BY date_added DESC");
        $like = "%{$search}%";
        $stmt->execute([$like, $like, $like]);
    } else {
        $stmt = $pdo->query("SELECT * FROM applicants ORDER BY date_added DESC");
    }
    $rows = $stmt->fetchAll();
} catch (PDOException $e) {
    echo '<div style="color:#900;background:#fee;padding:10px;border:1px solid #900">Database error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    $rows = [];
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dream Profession Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Dream Profession Registration</h1>
    <div class="actions">
        <a class="btn" href="create.php">+ Add Applicant</a>
        <form method="get" class="search-form">
            <input type="text" name="search" placeholder="Search name or profession" value="<?= htmlspecialchars($search) ?>">
            <div class="search-buttons">
                <button type="submit" class="btn search-btn">Search</button>
                <a href="index.php" class="btn muted">Reset</a>
            </div>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Profession</th>
                <th>Specialization</th>
                <th>Email</th>
                <th>Phone</th>
                <th>City</th>
                <th>Date Added</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($rows)): ?>
            <tr><td colspan="10">No records found.</td></tr>
        <?php else: ?>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['id']) ?></td>
                    <td><?= htmlspecialchars($r['first_name']) ?></td>
                    <td><?= htmlspecialchars($r['last_name']) ?></td>
                    <td><?= htmlspecialchars($r['profession']) ?></td>
                    <td><?= htmlspecialchars($r['specialization']) ?></td>
                    <td><?= htmlspecialchars($r['email']) ?></td>
                    <td><?= htmlspecialchars($r['phone']) ?></td>
                    <td><?= htmlspecialchars($r['city']) ?></td>
                    <td><?= htmlspecialchars($r['date_added']) ?></td>
                    <td>
                        <a class="btn small" href="edit-update.php?id=<?= $r['id'] ?>">Edit</a>
                        <a class="btn danger small" href="delete.php?id=<?= $r['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
