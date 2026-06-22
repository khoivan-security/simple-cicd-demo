<?php

$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8",
        $user,
        $pass
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);

    if (!empty($name)) {

        $stmt = $pdo->prepare(
            "INSERT INTO users(name) VALUES (?)"
        );

        $stmt->execute([$name]);
    }

    header("Location: /");
    exit;
}

$users = $pdo->query(
    "SELECT * FROM users ORDER BY id ASC"
)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple CI/CD Demo V3</title>
</head>
<body>

<h1>Simple CI/CD Demo V3</h1>

<h2>Add User</h2>

<form method="POST">
    <input
        type="text"
        name="name"
        placeholder="Enter name"
        required
    >

    <button type="submit">
        Add User
    </button>
</form>

<hr>

<h2>User List</h2>

<ul>
<?php foreach ($users as $user): ?>
    <li>
        <?= htmlspecialchars($user['name']) ?>
    </li>
<?php endforeach; ?>
</ul>

</body>
</html>
