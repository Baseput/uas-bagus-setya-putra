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
