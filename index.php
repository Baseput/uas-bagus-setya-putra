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
                    <input type="number" name="search_id" class="form-control" placeholder="Cari berdasarkan ID">
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $api_url = 'http://localhost/rest_playstation/ps_api.php';

                    try {
                        // Cek jika ada pencarian
                        if (isset($_GET['search_id']) && !empty($_GET['search_id'])) {
                            $api_url .= '?id=' . $_GET['search_id'];
                        }

                        // Ambil data dari API
                        $response = file_get_contents($api_url);
                        $units = json_decode($response, true);

                        // Cek apakah ada data
                        if (!empty($units)) {
                            // Loop untuk setiap unit
                            if (isset($_GET['search_id'])) {
                                // Jika pencarian, tampilkan satu unit
                                echo "<tr>";
                                echo "<td>{$units['id']}</td>";
                                echo "<td>{$units['unit_number']}</td>";
                                echo "<td>{$units['type']}</td>";
                                echo "<td>{$units['status']}</td>";
                                echo "<td>{$units['hourly_rate']}</td>";
                                echo "<td>
                                    <a href='?edit={$units['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='?delete={$units['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                </td>";
                                echo "</tr>";
                            } else {
                                // Jika tidak, tampilkan semua unit
                                foreach ($units as $unit) {
                                    echo "<tr>";
                                    echo "<td>{$unit['id']}</td>";
                                    echo "<td>{$unit['unit_number']}</td>";
                                    echo "<td>{$unit['type']}</td>";
                                    echo "<td>{$unit['status']}</td>";
                                    echo "<td>{$unit['hourly_rate']}</td>";
                                    echo "<td>
                                        <a href='?edit={$unit['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                        <a href='?delete={$unit['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                    </td>";
                                    echo "</tr>";
                                }
                            }
                        } else {
                            // Tampilkan pesan jika tidak ada data
                            echo "<tr><td colspan='6' class='text-center'>Tidak ada data unit PlayStation</td></tr>";
                        }
                    } catch (Exception $e) {
                        echo "<tr><td colspan='6' class='text-center text-danger'>Error: " . $e->getMessage() . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Tambah/Edit -->
    <div class="container mt-5">
        <h2 class="mb-4">Tambah/Edit Unit PlayStation</h2>
        <form action="" method="POST">
            <input type="hidden" name="id" id="id">
            <div class="mb-3">
                <label for="unit_number" class="form-label">Unit Number</label>
                <input type="text" class="form-control" name="unit_number" id="unit_number" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control" name="type" id="type" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" name="status" id="status" required>
            </div>
            <div class="mb-3">
                <label for="hourly_rate" class="form-label">Hourly Rate</label>
                <input type="number" step="0.01" class="form-control" name="hourly_rate" id="hourly_rate" required>
            </div>
            <button type="submit" name="save" class="btn btn-primary">Save</button>
        </form>
    </div>

    <!-- PHP Code for Handling Form Submission -->
    <?php
    if (isset($_POST['save'])) {
        $data = [
            'id' => $_POST['id'],
            'unit_number' => $_POST['unit_number'],
            'type' => $_POST['type'],
            'status' => $_POST['status'],
            'hourly_rate' => $_POST['hourly_rate']
        ];
        
        $url = 'http://localhost/rest_playstation/ps_api.php';
        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\n",
                'method'  => $data['id'] ? 'PUT' : 'POST',
                'content' => json_encode($data)
            ]
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        
        if ($result === FALSE) { 
            echo "<div class='alert alert-danger'>Error: Tidak dapat menyimpan data</div>";
        } else {
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        }
    }

    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $url = 'http://localhost/rest_playstation/ps_api.php?id=' . $id;
        $unit = json_decode(file_get_contents($url), true);

        echo "<script>
            document.getElementById('id').value = '{$unit['id']}';
            document.getElementById('unit_number').value = '{$unit['unit_number']}';
            document.getElementById('type').value = '{$unit['type']}';
            document.getElementById('status').value = '{$unit['status']}';
            document.getElementById('hourly_rate').value = '{$unit['hourly_rate']}';
        </script>";
    }

    if (isset($_GET['delete'])) {
        $data = ['id' => $_GET['delete']];
        $url = 'http://localhost/rest_playstation/ps_api.php';
        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'DELETE',
                'content' => json_encode($data)
            ]
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result === FALSE) { 
            echo "<div class='alert alert-danger'>Error: Tidak dapat menghapus data</div>";
        } else {
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        }
    }
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```
