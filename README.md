# uas-bagus-setya-putra
repository untuk uas web service
1. Nama: Bagus Setya Putra
2. NIM: 21 01 65 0002
3. Deskripsi: Saya membuat front end rest api web service dengan studi kasus manajemen video game Playstation

***Implementasi CRUD***
```
<?php
header("Content-Type: application/json");
$method = $_SERVER['REQUEST_METHOD'];
$dsn = 'mysql:host=localhost;dbname=playstation';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    switch ($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                $stmt = $pdo->prepare("SELECT * FROM units WHERE id = :id");
                $stmt->execute(['id' => $_GET['id']]);
                $unit = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($unit);
            } else {
                $stmt = $pdo->query("SELECT * FROM units");
                $units = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($units);
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO units (unit_number, type, status, hourly_rate) VALUES (:unit_number, :type, :status, :hourly_rate)");
            $stmt->execute([
                'unit_number' => $data['unit_number'],
                'type' => $data['type'],
                'status' => $data['status'],
                'hourly_rate' => $data['hourly_rate']
            ]);
            echo json_encode(['id' => $pdo->lastInsertId()]);
            break;

        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("UPDATE units SET unit_number = :unit_number, type = :type, status = :status, hourly_rate = :hourly_rate WHERE id = :id");
            $stmt->execute([
                'unit_number' => $data['unit_number'],
                'type' => $data['type'],
                'status' => $data['status'],
                'hourly_rate' => $data['hourly_rate'],
                'id' => $data['id']
            ]);
            echo json_encode(['status' => 'success']);
            break;

        case 'DELETE':
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("DELETE FROM units WHERE id = :id");
            $stmt->execute(['id' => $data['id']]);
            echo json_encode(['status' => 'success']);
            break;

        default:
            echo json_encode(['status' => 'method not allowed']);
            break;
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
```
