# uas-bagus-setya-putra
repository untuk uas web service
1. Nama: Bagus Setya Putra
2. NIM: 21 01 65 0002
3. Deskripsi: Saya membuat front end rest api web service dengan studi kasus manajemen video game PS
berikut source code diantaranya:

**File index.PHP**

```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Playstation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Konten akan ditambahkan di sini -->
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<div class="container mt-5">
    <h2 class="mb-4">Daftar Playstation</h2>
    
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
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>unit_number</th>
                <th>type</th>
                <th>Tahun</th>
                <th>Status</th>
                <th>hourly_rate</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data akan dimasukkan di sini menggunakan PHP -->
        </tbody>
    </table>
</div>
```
