<?php
// Debug file untuk mengecek status hosting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Information</h1>";

// Check PHP version
echo "<h2>PHP Version</h2>";
echo "PHP Version: " . phpversion() . "<br>";

// Check session status
echo "<h2>Session Status</h2>";
session_start();
echo "Session ID: " . session_id() . "<br>";
echo "Session Data: <pre>" . print_r($_SESSION, true) . "</pre>";

// Check database connection
echo "<h2>Database Connection</h2>";
try {
    require_once 'config/database.php';
    echo "Database connection: OK<br>";
    
    // Check tables
    $tables = ['users', 'makanan', 'log_makanan'];
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
            $count = $stmt->fetchColumn();
            echo "Table $table: $count rows<br>";
        } catch (Exception $e) {
            echo "Table $table: ERROR - " . $e->getMessage() . "<br>";
        }
    }
} catch (Exception $e) {
    echo "Database connection: ERROR - " . $e->getMessage() . "<br>";
}

// Check file permissions
echo "<h2>File Permissions</h2>";
$files = ['config/database.php', 'actions/add_food.php', 'actions/get_foods.php', 'actions/get_food_logs.php'];
foreach ($files as $file) {
    if (file_exists($file)) {
        echo "$file: EXISTS (readable: " . (is_readable($file) ? 'YES' : 'NO') . ")<br>";
    } else {
        echo "$file: NOT FOUND<br>";
    }
}

// Check POST data
echo "<h2>POST Data</h2>";
echo "<pre>" . print_r($_POST, true) . "</pre>";

// Check GET data
echo "<h2>GET Data</h2>";
echo "<pre>" . print_r($_GET, true) . "</pre>";

// Check server info
echo "<h2>Server Information</h2>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";

// Test AJAX endpoints
echo "<h2>AJAX Endpoint Test</h2>";
echo "<button onclick='testEndpoint(\"actions/get_foods.php\")'>Test get_foods.php</button><br>";
echo "<button onclick='testEndpoint(\"actions/get_food_logs.php\")'>Test get_food_logs.php</button><br>";
echo "<div id='test-results'></div>";

?>

<script>
function testEndpoint(url) {
    fetch(url)
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            document.getElementById('test-results').innerHTML = 
                '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('test-results').innerHTML = 
                '<div style="color: red;">Error: ' + error.message + '</div>';
        });
}
</script> 