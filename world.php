<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123'; 
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", 'lab5_user', 'password123');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $country = isset($_GET['country']) ? $_GET['country'] : '';
    $lookup = isset($_GET['lookup']) ? $_GET['lookup'] : '';

    if ($lookup === 'cities') {
        //SQL query to get cities in the specified country
        $stmt = $conn->prepare("
            SELECT c.name AS city_name, c.district, c.population 
            FROM cities c 
            JOIN countries co ON c.country_code = co.code 
            WHERE co.name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
        
        //fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //start outputting the HTML table for cities
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>City Name</th>';
        echo '<th>District</th>';
        echo '<th>Population</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['city_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['district']) . '</td>';
            echo '<td>' . htmlspecialchars($row['population']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

    } else {
        
        if ($country) {
            $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
            $stmt->execute(['country' => "%$country%"]);
        } else {
            $stmt = $conn->query("SELECT * FROM countries");
        }

        //fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //start outputting the HTML table for countries
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Country Name</th>';
        echo '<th>Continent</th>';
        echo '<th>Independence Year</th>';
        echo '<th>Head of State</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['continent']) . '</td>'; 
            echo '<td>' . htmlspecialchars($row['independence_year']) . '</td>'; 
            echo '<td>' . htmlspecialchars($row['head_of_state']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>