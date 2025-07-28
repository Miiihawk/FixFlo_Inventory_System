<?php
//use this to seed the database w/ users because you can't really seed it manually in sql anymore due to hashing
require_once 'db_connection.php';

$users = [
    ['admin_user', 'adminpass123', 'admin'],
    ['hat_dog', 'hat_dog_pls', 'staff'],
    ['loginpls', 'loginpls123', 'staff'],
    ['kurwa', 'okurwa111', 'staff'],
    ['bob', 'bob_knob', 'staff'],
];

foreach ($users as $user) {
    [$username, $password, $role] = $user;
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, role) VALUES (:u, :p, :r)");
    $stmt->execute([
        ':u' => $username,
        ':p' => $hashed,
        ':r' => $role
    ]);
}

echo "Users inserted successfully.";
?>

