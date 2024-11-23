<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123'; 
$dbname = 'world';

try {
   
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", 'lab5_user', 'password123');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $country = isset($_GET['country']) ? $_GET['country'] : '';

    if ($country) {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
    } else {
        $stmt = $conn->query("SELECT * FROM countries");
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<ul>
<?php foreach ($results as $row): ?>
  <li><?= htmlspecialchars($row['name']) . ' is ruled by ' . htmlspecialchars($row['head_of_state']); ?></li>
<?php endforeach; ?>
</ul>
