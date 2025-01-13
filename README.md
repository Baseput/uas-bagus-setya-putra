# uas-bagus-setya-putra
repository untuk uas web service
1. Nama: Bagus Setya Putra
2. NIM: 21 01 65 0002
3. Deskripsi: Saya membuat front end rest api web service dengan studi kasus manajemen video game Playstation

***File SQL***
```
CREATE TABLE playstation_units (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unit_number VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    status VARCHAR(255) NOT NULL,
    hourly_rate DECIMAL(10, 2) NOT NULL
);

INSERT INTO playstation_units (unit_number, type, status, hourly_rate) VALUES
('PS001', 'PS4', 'Available', 5000.00),
('PS002', 'PS4', 'In Use', 5000.00),
('PS003', 'PS4', 'Maintenance', 5000.00),
('PS004', 'PS5', 'Available', 7000.00),
('PS005', 'PS5', 'In Use', 7000.00);
```
***file Index.php untuk koneksi database***
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Unit PlayStation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Daftar Unit PlayStation</h2>
        
        <!-- Form Pencarian -->
        <div class="row mb-4">
            <div class="col-md-6">
                <form action="" method="GET" class="d-flex gap-2">
                    <input type="number" name="search_id" class="form-control" 
                           placeholder="Cari berdasarkan ID">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Unit Number</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Hourly Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        // Set URL API
                        $api_url = 'http://localhost/rest_client/ps_api.php';
                        
                        // Cek jika ada pencarian
                        if(isset($_GET['search_id']) && !empty($_GET['search_id'])) {
                            $api_url .= '/' . $_GET['search_id'];
                        }
                        
                        // Konfigurasi timeout
                        $ctx = stream_context_create([
                            'http' => ['timeout' => 5]
                        ]);
                        
                        // Ambil data dari API
                        $response = file_get_contents($api_url, false, $ctx);
                        
                        // Konversi JSON ke Array
                        $units = json_decode($response, true);

                        // Validasi response
                        if ($response === false) {
                            throw new Exception('Gagal mengambil data dari API');
                        }

                        // Validasi JSON
                        if (json_last_error() !== JSON_ERROR_NONE) {
                            throw new Exception('Invalid JSON response');
                        }

                        // Cek apakah ada data
                        if(!empty($units)) {
                            // Loop untuk setiap unit
                            foreach($units as $unit) {
                                echo "<tr>";
                                echo "<td>{$unit['id']}</td>";
                                echo "<td>{$unit['unit_number']}</td>";
                                echo "<td>{$unit['type']}</td>";
                                echo "<td>{$unit['status']}</td>";
                                echo "<td>{$unit['hourly_rate']}</td>";
                                echo "</tr>";
                            }
                        } else {
                            // Tampilkan pesan jika tidak ada data
                            echo "<tr><td colspan='5' class='text-center'>";
                            echo "Tidak ada data unit PlayStation";
                            echo "</td></tr>";
                        }

                        // Penanganan kasus pencarian
                        if(isset($_GET['search_id'])) {
                            if($units && !isset($units['message'])) {
                                // Tampilkan satu unit
                                echo "<tr>";
                                echo "<td>{$units['id']}</td>";
                                echo "<td>{$units['unit_number']}</td>";
                                echo "<td>{$units['type']}</td>";
                                echo "<td>{$units['status']}</td>";
                                echo "<td>{$units['hourly_rate']}</td>";
                                echo "</tr>";
                            } else {
                                // Tampilkan pesan tidak ditemukan
                                echo "<tr><td colspan='5' class='text-center'>";
                                echo "Unit PlayStation dengan ID tersebut tidak ditemukan";
                                echo "</td></tr>";
                            }
                        }
                    } catch (Exception $e) {
                        echo "<tr><td colspan='5' class='text-center text-danger'>";
                        echo "Error: " . $e->getMessage();
                        echo "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

```
