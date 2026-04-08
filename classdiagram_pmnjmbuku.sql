CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(255),
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin', 'user') DEFAULT 'user'
);

CREATE TABLE kelas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_kelas VARCHAR(255)
);

CREATE TABLE anggota (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  kelas_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE buku (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(255),
  penulis VARCHAR(255),
  penerbit VARCHAR(255),
  tahun INT,
  stok INT
);

CREATE TABLE transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  tanggal_pinjam DATE,
  tanggal_kembali DATE,
  status ENUM('dipinjam', 'dikembalikan'),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE detail_transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  transaksi_id INT,
  buku_id INT,
  jumlah INT,
  FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (buku_id) REFERENCES buku(id) ON DELETE CASCADE ON UPDATE CASCADE
);