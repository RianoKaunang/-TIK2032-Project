<?php
session_start();

// Konfigurasi koneksi database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "riano_website";

// Buat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    error_log("Koneksi database gagal: " . $conn->connect_error);
    $_SESSION['message'] = ['text' => "Terjadi kesalahan server. Silakan coba lagi nanti.", 'class' => 'error'];
    header('Location: contact.php');
    exit;
}

// Set karakter encoding ke UTF-8
$conn->set_charset("utf8mb4");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $errors = [];

    // Validation
    if (empty($name)) {
        $errors[] = 'Nama harus diisi.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email tidak valid.';
    }
    if (empty($message)) {
        $errors[] = 'Pesan harus diisi.';
    }

    // Store form data in session to repopulate form on error
    $_SESSION['form_data'] = [
        'name' => $name,
        'email' => $email,
        'message' => $message
    ];

    // If no errors, insert into database
    if (empty($errors)) {
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            error_log("Prepare statement gagal: " . $conn->error);
            $_SESSION['message'] = ['text' => "Terjadi kesalahan server. Silakan coba lagi nanti.", 'class' => 'error'];
            header('Location: contact.php');
            exit;
        }

        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            unset($_SESSION['form_data']); // Clear form data on success
        } else {
            error_log("Query execution gagal: " . $stmt->error);
            $_SESSION['message'] = ['text' => "Gagal menyimpan pesan. Silakan coba lagi.", 'class' => 'error'];
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = ['text' => implode('<br>', $errors), 'class' => 'error'];
    }

    $conn->close();
    header('Location: contact.php');
    exit;
}
?>