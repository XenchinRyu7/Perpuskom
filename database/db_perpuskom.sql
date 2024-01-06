-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jan 2024 pada 20.28
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpuskom`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `ID_Admin` int(11) NOT NULL,
  `Nama` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`ID_Admin`, `Nama`, `username`, `password`) VALUES
(1, 'admin gamteng', 'admin@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `ID_Buku` int(11) NOT NULL,
  `Judul` varchar(255) DEFAULT NULL,
  `Penulis` varchar(100) DEFAULT NULL,
  `genre` enum('Romansa','Misteri','Sains Fiksi','Sejarah','Biografi','Puisi','Drama','Horor','Anak-anak','Remaja','Fiksi Sejarah','Fiksi Ilmiah') NOT NULL,
  `TahunTerbit` year(4) DEFAULT NULL,
  `Ketersediaan` enum('Tersedia','Dipinjam') DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `JumlahBuku` int(11) DEFAULT 0,
  `is_favorite` enum('ya','tidak') NOT NULL DEFAULT 'tidak'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`ID_Buku`, `Judul`, `Penulis`, `genre`, `TahunTerbit`, `Ketersediaan`, `gambar`, `JumlahBuku`, `is_favorite`) VALUES
(1, 'The Silent Revolution', 'John Smith', 'Sains Fiksi', 2015, 'Tersedia', '../assets/images/cewe.jpg', 4, 'tidak'),
(2, 'Lost in Translation', 'Maria Rodriguez', 'Romansa', 2018, 'Tersedia', '', 0, 'tidak'),
(3, 'Beyond the Horizon', 'Emily Johnson', 'Fiksi Ilmiah', 2020, 'Tersedia', '', 0, 'tidak'),
(4, 'The Art of Living', 'David Brown', 'Biografi', 2017, 'Tersedia', '', 0, 'tidak'),
(5, 'Whispers in the Dark', 'Isabella Martinez', 'Horor', 2019, 'Tersedia', '', 0, 'tidak'),
(6, 'Echoes of Eternity', 'Michael White', 'Sejarah', 2016, 'Tersedia', '', 0, 'tidak'),
(7, 'The Enchanted Garden', 'Sophia Lee', 'Puisi', 2021, 'Tersedia', '', 0, 'tidak'),
(8, 'Shadows of Destiny', 'Daniel Black', 'Misteri', 2014, 'Tersedia', '', 0, 'tidak'),
(9, 'The Lost World', 'Alice Green', 'Sains Fiksi', 2013, 'Tersedia', '', 0, 'tidak'),
(10, 'A Tale of Two Cities', 'Charles Dickens', 'Sejarah', 0000, 'Tersedia', '', 0, 'tidak'),
(11, 'Infinite Possibilities', 'Jessica Adams', 'Fiksi Ilmiah', 2019, 'Tersedia', '', 0, 'tidak'),
(12, 'The Moonlit Serenade', 'Gabriel Taylor', 'Romansa', 2016, 'Tersedia', '', 0, 'tidak'),
(13, 'Beyond the Stars', 'Olivia Roberts', 'Sains Fiksi', 2022, 'Tersedia', '', 0, 'tidak'),
(14, 'City of Dreams', 'Christopher Walker', 'Misteri', 2015, 'Tersedia', '', 0, 'tidak'),
(15, 'Eternal Love', 'Sophie Anderson', 'Romansa', 2017, 'Tersedia', '', 0, 'tidak'),
(16, 'The Quantum Paradox', 'Andrew Lewis', 'Fiksi Ilmiah', 2021, 'Tersedia', '', 0, 'tidak'),
(17, 'Chronicles of Destiny', 'Natalie Carter', '', 2018, 'Tersedia', '', 0, 'tidak'),
(18, 'Songs of the Soul', 'Matthew Davis', 'Puisi', 2014, 'Tersedia', '', 0, 'tidak'),
(19, 'Under the Moonlight', 'Emma Thompson', 'Horor', 2016, 'Tersedia', '', 0, 'tidak'),
(20, 'Lost and Found', 'Sophie Miller', 'Misteri', 2020, 'Tersedia', '', 0, 'tidak'),
(21, 'A Journey to Remember', 'Richard Wilson', 'Sejarah', 2013, 'Tersedia', '', 0, 'tidak'),
(22, 'The Celestial Odyssey', 'Alexandra Wright', '', 2019, 'Tersedia', '', 0, 'tidak'),
(23, 'Silent Whispers', 'Benjamin Turner', 'Horor', 2017, 'Tersedia', '', 0, 'tidak'),
(24, 'The Last Crusade', 'Jennifer Mitchell', 'Sejarah', 2015, 'Tersedia', '', 0, 'tidak'),
(25, 'Love Beyond Time', 'Lucas Baker', 'Romansa', 2018, 'Tersedia', '', 0, 'tidak'),
(26, 'Galactic Explorers', 'Eva Foster', 'Sains Fiksi', 2022, 'Tersedia', '', 0, 'tidak'),
(27, 'Whispers of the Wind', 'Sophie Turner', 'Puisi', 2016, 'Tersedia', '', 0, 'tidak'),
(28, 'Secrets of the Shadows', 'Daniel Moore', 'Misteri', 2014, 'Tersedia', '', 0, 'tidak'),
(29, 'The Mystic Journey', 'Ava Adams', '', 2020, 'Tersedia', '', 0, 'tidak'),
(30, 'Underneath the Surface', 'Oliver Clark', 'Misteri', 2013, 'Tersedia', '', 0, 'tidak'),
(31, 'Love in Bloom', 'Grace Walker', 'Romansa', 2017, 'Tersedia', '', 0, 'tidak'),
(32, 'Whispers of Destiny', 'Victor Roberts', '', 2021, 'Tersedia', '', 0, 'tidak'),
(33, 'Eternal Nightfall', 'Sophie Turner', 'Horor', 2015, 'Tersedia', '', 0, 'tidak'),
(34, 'The Alchemists Secret', 'Daniel Johnson', 'Misteri', 2018, 'Tersedia', '', 0, 'tidak'),
(35, 'Beyond the Clouds', 'Emma White', 'Fiksi Ilmiah', 2016, 'Tersedia', '', 0, 'tidak'),
(36, 'A Symphony of Stars', 'Natalie Davis', 'Sains Fiksi', 2022, 'Tersedia', '', 0, 'tidak'),
(37, 'Echoes of the Past', 'Michael Turner', 'Sejarah', 2014, 'Tersedia', '', 0, 'tidak'),
(38, 'The Whispering Shadows', 'Sophia Baker', 'Horor', 2019, 'Tersedia', '', 0, 'tidak'),
(39, 'Loves Journey', 'David Foster', 'Romansa', 2013, 'Tersedia', '', 0, 'tidak'),
(40, 'The Enchanted Forest', 'Eva Turner', 'Puisi', 2017, 'Tersedia', '', 0, 'tidak'),
(41, 'Whispers of the Moon', 'John Turner', 'Horor', 2019, 'Tersedia', '', 0, 'tidak'),
(42, 'A Dance with Shadows', 'Sophia Davis', 'Misteri', 2015, 'Tersedia', '', 0, 'tidak'),
(43, 'The Starlight Sonata', 'Benjamin White', 'Fiksi Ilmiah', 2018, 'Tersedia', '', 0, 'tidak'),
(44, 'Loves Eternal Flame', 'Emily Turner', 'Romansa', 2016, 'Tersedia', '', 0, 'tidak'),
(45, 'Beyond the Rainbow', 'Christopher Foster', '', 2021, 'Tersedia', '', 0, 'tidak'),
(46, 'The Haunting Melody', 'Isaac Baker', 'Horor', 2014, 'Tersedia', '', 0, 'tidak'),
(47, 'Whispers of Love', 'Sophie Davis', 'Romansa', 2020, 'Tersedia', '', 0, 'tidak'),
(48, 'Eternal Shadows', 'David Turner', 'Misteri', 2013, 'Tersedia', '', 0, 'tidak'),
(49, 'The Celestial Garden', 'Eva Foster', 'Puisi', 2017, 'Tersedia', '', 0, 'tidak'),
(50, 'Journey to the Stars', 'Daniel White', 'Sains Fiksi', 2019, 'Tersedia', '', 0, 'tidak'),
(51, 'Lost and Found', 'Sophia Baker', '', 2015, 'Tersedia', '', 0, 'tidak'),
(52, 'Whispers in the Mist', 'Michael Foster', 'Horor', 2018, 'Tersedia', '', 0, 'tidak'),
(53, 'The Forgotten Realm', 'Natalie Turner', 'Misteri', 2016, 'Tersedia', '', 0, 'tidak'),
(54, 'Eternal Echoes', 'Benjamin Foster', 'Romansa', 2022, 'Tersedia', '', 0, 'tidak'),
(55, 'Echoes of Love', 'Sophie Baker', 'Puisi', 2014, 'Tersedia', '', 0, 'tidak'),
(56, 'The Whispering Wind', 'Eva Turner', 'Romansa', 2020, 'Tersedia', '', 0, 'tidak'),
(57, 'Mysteries of the Night', 'David Foster', 'Misteri', 2013, 'Tersedia', '', 0, 'tidak'),
(58, 'Beyond the Veil', 'Sophia White', '', 2017, 'Tersedia', '', 0, 'tidak'),
(59, 'The Lost Symphony', 'Christopher Turner', 'Fiksi Ilmiah', 2019, 'Tersedia', '', 0, 'tidak'),
(60, 'Loves Embrace', 'Emma Baker', 'Romansa', 2015, 'Tersedia', '', 0, 'tidak'),
(61, 'Whispers of the Soul', 'Daniel Foster', 'Puisi', 2018, 'Tersedia', '', 0, 'tidak'),
(62, 'Eternal Twilight', 'Sophie Turner', 'Horor', 2016, 'Tersedia', '', 0, 'tidak'),
(63, 'The Enchanted River', 'Benjamin Baker', '', 2021, 'Tersedia', '', 0, 'tidak'),
(64, 'Senja di Pelabuhan Kecil', 'Putri Anindya', 'Romansa', 2016, 'Tersedia', '', 0, 'tidak'),
(65, 'Misteri Gunung Merapi', 'Budi Santoso', 'Misteri', 2018, 'Tersedia', '', 0, 'tidak'),
(66, 'Catatan Seorang Backpacker', 'Dian Permata', 'Biografi', 2019, 'Tersedia', '', 0, 'tidak'),
(67, 'Pesona Pulau Bali', 'I Made Subrata', '', 2017, 'Tersedia', '', 0, 'tidak'),
(68, 'Sang Pemimpi Jomblo', 'Rizki Pratama', '', 2020, 'Tersedia', '', 0, 'tidak'),
(69, 'Jejak Langkah Sang Petualang', 'Aditya Nugraha', '', 2015, 'Tersedia', '', 0, 'tidak'),
(70, 'Kisah Cinta di Pantai Pasir Putih', 'Citra Puspita', 'Romansa', 2021, 'Tersedia', '', 0, 'tidak'),
(71, 'Gelombang Kehidupan', 'Bambang Surya', '', 2014, 'Tersedia', '', 0, 'tidak'),
(72, 'Perjalanan Sejuta Impian', 'Dewi Lestari', 'Biografi', 2013, 'Tersedia', '', 0, 'tidak'),
(73, 'Langit Petang di Jakarta', 'Eka Kurniawan', '', 2016, 'Tersedia', '', 0, 'tidak'),
(74, 'Bunga di Tepi Jalan', 'Niken Larasati', 'Puisi', 2019, 'Tersedia', '', 0, 'tidak'),
(75, 'Rahasia Pulau Seribu', 'Ahmad Rifai', 'Misteri', 2015, 'Tersedia', '', 0, 'tidak'),
(76, 'Indahnya Desaku', 'Dewi Nur Aisyah', '', 2018, 'Tersedia', '', 0, 'tidak'),
(77, 'Si Anak Desa di Kota Besar', 'Teguh Santoso', 'Biografi', 2017, 'Tersedia', '', 0, 'tidak'),
(78, 'Cerita dari Negeri Poci', 'Lia Kartika', 'Sejarah', 2020, 'Tersedia', '', 0, 'tidak'),
(79, 'Harmoni Alam Nusantara', 'Anto Susanto', '', 2016, 'Tersedia', '', 0, 'tidak'),
(80, 'Sewindu di Tanah Air', 'Rani Maharani', 'Biografi', 2021, 'Tersedia', '', 0, 'tidak'),
(81, 'Mimpi di Puncak Rinjani', 'Ade Firmansyah', '', 2014, 'Tersedia', '', 0, 'tidak'),
(82, 'Jalan-jalan ke Yogyakarta', 'Wahyu Setiawan', '', 2013, 'Tersedia', '', 0, 'tidak'),
(83, 'Pelukis Langit Senja', 'Rosa Putri', 'Romansa', 2018, 'Tersedia', '', 0, 'tidak'),
(84, 'Filosofi Teras', 'Ihwan Santosa', '', 2017, 'Tersedia', '', 0, 'tidak'),
(85, 'The Psychology of Money', 'Morgan Housel', '', 2018, 'Tersedia', '', 0, 'tidak'),
(86, 'Atomic Habits', 'James Clear', 'Sains Fiksi', 2018, 'Tersedia', NULL, 3, 'tidak'),
(87, 'Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'Sejarah', 2014, 'Tersedia', '', 0, 'tidak'),
(88, 'Educated', 'Tara Westover', 'Biografi', 2018, 'Tersedia', '', 0, 'tidak'),
(89, 'The Silent Patient', 'Alex Michaelides', 'Misteri', 2019, 'Tersedia', '', 0, 'tidak'),
(90, 'Where the Crawdads Sing', 'Delia Owens', '', 2018, 'Tersedia', '', 0, 'tidak'),
(91, 'The Subtle Art of Not Giving a F*ck', 'Mark Manson', '', 2016, 'Tersedia', '', 0, 'tidak'),
(92, 'Becoming', 'Michelle Obama', 'Biografi', 2018, 'Tersedia', '', 0, 'tidak'),
(93, 'The Power of Habit', 'Charles Duhigg', '', 2012, 'Tersedia', '', 0, 'tidak'),
(94, 'Thinking, Fast and Slow', 'Daniel Kahneman', '', 2011, 'Tersedia', '', 0, 'tidak'),
(95, 'The Alchemist', 'Paulo Coelho', '', 1988, 'Tersedia', '', 0, 'tidak'),
(96, 'Mindset: The New Psychology of Success', 'Carol S. Dweck', '', 2006, 'Tersedia', '', 0, 'tidak'),
(97, 'The 7 Habits of Highly Effective People', 'Stephen R. Covey', '', 1989, 'Tersedia', '', 0, 'tidak'),
(98, 'Mans Search for Meaning', 'Viktor E. Frankl', '', 1946, 'Tersedia', '', 0, 'tidak'),
(99, 'The Great Gatsby', 'F. Scott Fitzgerald', '', 1925, 'Tersedia', '', 0, 'tidak'),
(100, 'To Kill a Mockingbird', 'Harper Lee', '', 1960, 'Tersedia', '', 0, 'tidak'),
(101, '1984', 'George Orwell', 'Fiksi Ilmiah', 1949, 'Tersedia', NULL, 2, 'tidak'),
(102, 'The Hobbit', 'J.R.R. Tolkien', '', 1937, 'Tersedia', '', 0, 'tidak'),
(103, 'The Hobbit', 'J.R.R. Tolkien', '', 1937, 'Tersedia', '', 0, 'tidak'),
(104, 'Introduction to Algorithms', 'Thomas H. Cormen, Charles E. Leiserson, Ronald L. Rivest, Clifford Stein', '', 2009, 'Tersedia', '', 0, 'tidak'),
(105, 'Computer Networks: A Top-Down Approach', 'James F. Kurose, Keith W. Ross', '', 2016, 'Tersedia', '', 0, 'tidak'),
(106, 'Artificial Intelligence: A Modern Approach', 'Stuart Russell, Peter Norvig', 'Sains Fiksi', 2020, 'Tersedia', '../assets/images/artificial_intelligence.jpg', 3, 'tidak'),
(107, 'Database Management Systems', 'Raghu Ramakrishnan, Johannes Gehrke', '', 2002, 'Tersedia', '', 0, 'tidak'),
(108, 'Operating System Concepts', 'Abraham Silberschatz, Peter B. Galvin, Greg Gagne', '', 2012, 'Tersedia', '', 0, 'tidak'),
(109, 'Computer Organization and Design: The Hardware/Software Interface', 'David A. Patterson, John L. Hennessy', '', 2019, 'Tersedia', '', 0, 'tidak'),
(110, 'Machine Learning: A Probabilistic Perspective', 'Kevin P. Murphy', '', 2012, 'Tersedia', '', 0, 'tidak'),
(111, 'Pattern Recognition and Machine Learning', 'Christopher M. Bishop', '', 2006, 'Tersedia', '', 0, 'tidak'),
(112, 'Computer Vision: Algorithms and Applications', 'Richard Szeliski', '', 2010, 'Tersedia', '', 0, 'tidak'),
(113, 'Software Engineering: A Practitioners Approach', 'Roger S. Pressman', '', 2014, 'Tersedia', '', 0, 'tidak'),
(114, 'Deep Learning', 'Ian Goodfellow, Yoshua Bengio, Aaron Courville', '', 2016, 'Tersedia', '', 0, 'tidak'),
(115, 'Computer Graphics: Principles and Practice', 'John F. Hughes, Andries van Dam, Morgan McGuire, David F. Sklar, James D. Foley, Steven K. Feiner, K', '', 2013, 'Tersedia', '', 0, 'tidak'),
(116, 'Web Development with Node.js, Express, and MongoDB', 'Brad Dayley', '', 2014, 'Tersedia', '', 0, 'tidak'),
(117, 'Introduction to the Theory of Computation', 'Michael Sipser', '', 2012, 'Tersedia', '', 0, 'tidak'),
(118, 'Computer Security: Principles and Practice', 'William Stallings, Lawrie Brown', '', 2017, 'Tersedia', '', 0, 'tidak'),
(119, 'Information Retrieval: Implementing and Evaluating Search Engines', 'Stefan Büttcher, Charles L. A. Clarke, Gordon V. Cormack', '', 2016, 'Tersedia', '', 0, 'tidak'),
(120, 'Human-Computer Interaction', 'Alan Dix, Janet E. Finlay, Gregory D. Abowd, Russell Beale', '', 2004, 'Tersedia', '', 0, 'tidak'),
(121, 'Cryptography and Network Security: Principles and Practice', 'William Stallings', '', 2016, 'Tersedia', '', 0, 'tidak'),
(123, 'The Mythical Man-Month: Essays on Software Engineering', 'Frederick P. Brooks Jr.', '', 1995, 'Tersedia', '', 0, 'tidak'),
(124, 'Computer Networking: Principles, Protocols and Practice', 'Olivier Bonaventure', '', 2013, 'Tersedia', '', 0, 'tidak'),
(128, 'The Time Keeper', 'mitch ALbom', 'Romansa', 0000, 'Tersedia', '../assets/images/the_time_keeper.jpg', 3, 'tidak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `favorite_books`
--

CREATE TABLE `favorite_books` (
  `ID_Mahasiswa` int(11) NOT NULL,
  `ID_Buku` int(11) NOT NULL,
  `Tanggal_Penambahan` timestamp NOT NULL DEFAULT current_timestamp(),
  `isfavorite` enum('ya','tidak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `favorite_books`
--

INSERT INTO `favorite_books` (`ID_Mahasiswa`, `ID_Buku`, `Tanggal_Penambahan`, `isfavorite`) VALUES
(7, 1, '2024-01-06 17:19:51', 'tidak'),
(7, 2, '2024-01-06 17:06:51', 'tidak'),
(7, 3, '2024-01-04 03:31:37', 'tidak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `ID_Mahasiswa` int(11) NOT NULL,
  `Nama` varchar(255) NOT NULL,
  `NIM` varchar(15) DEFAULT NULL,
  `Kelas` enum('01','02','03','04','05') DEFAULT NULL,
  `Jurusan` enum('SI','TI','MI','DKV') DEFAULT NULL,
  `TahunAngkatan` year(4) DEFAULT NULL,
  `NoTelp` varchar(20) DEFAULT NULL,
  `email` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`ID_Mahasiswa`, `Nama`, `NIM`, `Kelas`, `Jurusan`, `TahunAngkatan`, `NoTelp`, `email`, `password`, `Alamat`) VALUES
(5, 'Azzahra Putri', '2023423434', '02', 'TI', 0000, '', 'azzahrap@gmail.com', '$2y$10$rHSQIL6tTuqKyVvu43cE3.kHVc3lHSr0J9Uwth1gQXCnuGTs2vJdW', ''),
(6, 'Saeful Rohman', NULL, NULL, NULL, NULL, NULL, 'xenchin@gmail.com', '$2y$10$LEnINh2ZDdinkpaWjDUJd..h63Wo5h28XW0PCR7AOsrZC0f2rirVu', NULL),
(7, 'Saeful Ganteng', '20220810038', '01', 'SI', 2022, '0838699470', 'saeful@gmail.com', '$2y$10$Y5y7ojFqsC2TeVIyCvIYiuqIIUxP/IPKC7b6ZB7hJkiyUAyeriH7i', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `ID_Notifikasi` int(15) NOT NULL,
  `ID_Mahasiswa` int(11) DEFAULT NULL,
  `ID_Buku` int(11) DEFAULT NULL,
  `TanggalNotifikasi` timestamp NOT NULL DEFAULT current_timestamp(),
  `StatusNotifikasi` enum('Belum Dilihat','Diterima','Ditolak') NOT NULL DEFAULT 'Belum Dilihat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`ID_Notifikasi`, `ID_Mahasiswa`, `ID_Buku`, `TanggalNotifikasi`, `StatusNotifikasi`) VALUES
(12, 5, 1, '2024-01-01 15:22:31', 'Diterima'),
(13, 7, 1, '2024-01-06 16:38:48', 'Diterima'),
(14, 7, 128, '2024-01-06 16:44:15', 'Diterima');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `ID_Peminjaman` int(11) NOT NULL,
  `ID_Mahasiswa` int(11) DEFAULT NULL,
  `Nama_mhs` varchar(255) NOT NULL,
  `ID_Buku` int(11) DEFAULT NULL,
  `Judul_buku` varchar(255) NOT NULL,
  `TanggalPinjam` datetime DEFAULT NULL,
  `TanggalKembali` timestamp NULL DEFAULT NULL,
  `StatusPeminjaman` enum('Dipinjam','Dikembalikan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`ID_Peminjaman`, `ID_Mahasiswa`, `Nama_mhs`, `ID_Buku`, `Judul_buku`, `TanggalPinjam`, `TanggalKembali`, `StatusPeminjaman`) VALUES
(11, 5, 'Azzahra Putri', 1, 'The Silent Revolution', '2024-01-01 22:22:44', '2024-01-01 15:26:30', 'Dikembalikan'),
(12, 7, 'Saeful Ganteng', 1, 'The Silent Revolution', '2024-01-07 01:07:02', NULL, 'Dipinjam'),
(13, 7, 'Saeful Ganteng', 128, 'The Time Keeper', '2024-01-07 01:54:07', '2024-01-06 18:54:24', 'Dikembalikan');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID_Admin`),
  ADD UNIQUE KEY `Username` (`username`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`ID_Buku`);

--
-- Indeks untuk tabel `favorite_books`
--
ALTER TABLE `favorite_books`
  ADD PRIMARY KEY (`ID_Mahasiswa`,`ID_Buku`),
  ADD KEY `ID_Buku` (`ID_Buku`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`ID_Mahasiswa`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`ID_Notifikasi`),
  ADD KEY `ID_Mahasiswa` (`ID_Mahasiswa`),
  ADD KEY `ID_Buku` (`ID_Buku`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`ID_Peminjaman`),
  ADD KEY `ID_Mahasiswa` (`ID_Mahasiswa`),
  ADD KEY `ID_Buku` (`ID_Buku`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `ID_Admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `ID_Buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `ID_Mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `ID_Notifikasi` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `ID_Peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `favorite_books`
--
ALTER TABLE `favorite_books`
  ADD CONSTRAINT `favorite_books_ibfk_1` FOREIGN KEY (`ID_Mahasiswa`) REFERENCES `mahasiswa` (`ID_Mahasiswa`),
  ADD CONSTRAINT `favorite_books_ibfk_2` FOREIGN KEY (`ID_Buku`) REFERENCES `buku` (`ID_Buku`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`ID_Mahasiswa`) REFERENCES `mahasiswa` (`ID_Mahasiswa`),
  ADD CONSTRAINT `notifikasi_ibfk_2` FOREIGN KEY (`ID_Buku`) REFERENCES `buku` (`ID_Buku`);

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`ID_Mahasiswa`) REFERENCES `mahasiswa` (`ID_Mahasiswa`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`ID_Buku`) REFERENCES `buku` (`ID_Buku`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
