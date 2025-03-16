<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

try {
    // Sesuaikan dengan konfigurasi database Anda
    $host = "localhost";
    $user = "root";
    $password = "12345678"; // Biasanya kosong untuk XAMPP default
    $database = "demo";

    $koneksi = mysqli_connect($host, $user, $password, $database);

    if (!$koneksi) {
        throw new Exception("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Test query sederhana
    $query = "SELECT * FROM products LIMIT 5";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        throw new Exception("Query error: " . mysqli_error($koneksi));
    }

    $data = array();
    while($row = mysqli_fetch_assoc($result)) {
        // Log setiap row untuk debugging
        error_log(print_r($row, true));
        array_push($data, array(
            'id' => (int)$row['id'],
            'name' => (string)$row['name'],
            'price' => (float)$row['price']
        ));
    }

    echo json_encode([
        'success' => true,
        'data' => $data,
        'count' => count($data)
    ]);

} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}

mysqli_close($koneksi);
?> 