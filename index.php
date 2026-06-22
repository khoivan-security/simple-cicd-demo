<?php
echo "<h1>Version 2</h1>";
$conn = new mysqli(
    getenv("DB_HOST"),
    getenv("DB_USER"),
    getenv("DB_PASS"),
    getenv("DB_NAME")
);

if ($conn->connect_error) {
    die("Database connection failed");
}

echo "<h1>User List</h1>";

$result = $conn->query("SELECT * FROM users");

while ($row = $result->fetch_assoc()) {
    echo $row["id"] . " - " . $row["name"] . "<br>";
}
