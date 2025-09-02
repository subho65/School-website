<?php
// Installer: creates DB, tables, folders, default admin, protections
mysqli_report(MYSQLI_REPORT_OFF);
$rootConn = @new mysqli('127.0.0.1','root','root');
if ($rootConn->connect_errno) { exit('DB connection failed.'); }
$rootConn->query("CREATE DATABASE IF NOT EXISTS `school_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

$mysqli = @new mysqli('127.0.0.1','root','root','school_db');
if ($mysqli->connect_errno) { exit('DB select failed.'); }
$mysqli->set_charset('utf8mb4');

// Tables
$queries = [
  "CREATE TABLE IF NOT EXISTS admin (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(100) UNIQUE, password VARCHAR(255))",
  "CREATE TABLE IF NOT EXISTS students (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200), class VARCHAR(50), roll_no VARCHAR(50) UNIQUE, dob DATE, email VARCHAR(200), phone VARCHAR(50), address TEXT, created_at DATETIME)",
  "CREATE TABLE IF NOT EXISTS teachers (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200), subject VARCHAR(200), qualification VARCHAR(200), photo VARCHAR(255), created_at DATETIME)",
  "CREATE TABLE IF NOT EXISTS admissions (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200), class_applied VARCHAR(50), dob DATE, parent_name VARCHAR(200), email VARCHAR(200), phone VARCHAR(50), docs VARCHAR(255), status VARCHAR(50), created_at DATETIME)",
  "CREATE TABLE IF NOT EXISTS results (id INT AUTO_INCREMENT PRIMARY KEY, student_id INT, class VARCHAR(50), subject VARCHAR(200), marks VARCHAR(50), created_at DATETIME, INDEX(student_id))",
  "CREATE TABLE IF NOT EXISTS banners (id INT AUTO_INCREMENT PRIMARY KEY, image VARCHAR(255), link VARCHAR(255))",
  "CREATE TABLE IF NOT EXISTS notices (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255), description TEXT, file VARCHAR(255), created_at DATETIME)",
  "CREATE TABLE IF NOT EXISTS gallery (id INT AUTO_INCREMENT PRIMARY KEY, image VARCHAR(255), type ENUM('image','video') DEFAULT 'image', created_at DATETIME)",
  "CREATE TABLE IF NOT EXISTS events (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255), date DATE, description TEXT, created_at DATETIME)",
  "CREATE TABLE IF NOT EXISTS settings (id INT AUTO_INCREMENT PRIMARY KEY, school_name VARCHAR(255), logo VARCHAR(255), email VARCHAR(200), phone VARCHAR(50), address TEXT, map_embed TEXT)",
  "CREATE TABLE IF NOT EXISTS contact_messages (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200), email VARCHAR(200), phone VARCHAR(50), message TEXT, ip VARCHAR(64), created_at DATETIME)"
];

foreach ($queries as $q) { $mysqli->query($q); }

// Default admin
$defaultPass = password_hash('123456', PASSWORD_DEFAULT);
$mysqli->query("INSERT IGNORE INTO admin (id, username, password) VALUES (1, 'admin', '".$mysqli->real_escape_string($defaultPass)."')");

// Default settings row if not exists
$exists = $mysqli->query("SELECT id FROM settings LIMIT 1");
if (!$exists || !$exists->num_rows) {
  $mysqli->query("INSERT INTO settings (school_name, logo, email, phone, address, map_embed) VALUES ('Saraswati Shishu Mandir, Kaligram', '', '', '', 'Kaligram, India', '')");
}

// Folders
$dirs = ['uploads','uploads/banners','uploads/notices','uploads/gallery','uploads/docs'];
foreach ($dirs as $d) { if (!is_dir($d)) @mkdir($d, 0775, true); }
// Protect docs
file_put_contents('uploads/docs/.htaccess', "Deny from all\n");
// Prevent listing
file_put_contents('uploads/index.html', '');
file_put_contents('uploads/banners/index.html', '');
file_put_contents('uploads/notices/index.html', '');
file_put_contents('uploads/gallery/index.html', '');
file_put_contents('uploads/docs/index.html', '');

// Redirect to admin
header('Location: admin/login.php');
exit;
