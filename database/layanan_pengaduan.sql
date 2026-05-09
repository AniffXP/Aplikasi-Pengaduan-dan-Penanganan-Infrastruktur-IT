-- ============================================
-- Database: layanan_pengaduan
-- Aplikasi Pengaduan dan Penanganan Infrastruktur IT
-- PT. Pupuk Sriwidjaja Palembang
-- ============================================

CREATE DATABASE IF NOT EXISTS `layanan_pengaduan`;
USE `layanan_pengaduan`;

-- Tabel Login (User & Admin)
CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `user_login` varchar(100) NOT NULL,
  `pass_login` varchar(100) NOT NULL,
  `level` varchar(20) NOT NULL DEFAULT 'User',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `login` (`nama`, `user_login`, `pass_login`, `level`) VALUES
('Administrator', 'admin', 'admin', 'Admin'),
('Departemen Akuntansi', 'departemenakuntansi', 'user', 'User'),
('Departemen Hukum', 'departemenhukum', 'user', 'User'),
('Departemen Keuangan', 'departemenkeuangan', 'user', 'User'),
('Departemen Produksi', 'departemenproduksi', 'user', 'User'),
('Departemen Riset', 'departemenriset', 'user', 'User');

-- Tabel Masalah (Tracker Kategori)
CREATE TABLE IF NOT EXISTS `masalah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tracker` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `masalah` (`tracker`) VALUES
('Absensi'),
('Data Center'),
('Data Office'),
('Domain'),
('Infrastruktur TI'),
('Jaringan Komputer'),
('Keamanan Siber'),
('Pemeliharaan Aplikasi'),
('Penambahan Jaringan LAN'),
('Perbaikan Perangkat Komputer'),
('Perbaikan Server'),
('Server & Hosting'),
('Troubleshooting'),
('Website');

-- Tabel Laporan (Pengaduan)
CREATE TABLE IF NOT EXISTS `laporan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Baru',
  `tgl_pengaduan` datetime DEFAULT NULL,
  `tgl_selesai` datetime DEFAULT NULL,
  `prioritas` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `waktu_pengerjaan` varchar(50) DEFAULT '',
  `bukti` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `login` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
