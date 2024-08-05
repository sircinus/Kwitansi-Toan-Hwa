<?php
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = ""; // default password for XAMPP
$dbname = "kwitansi_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nominal = $_POST['nominal'];
    $keterangan = $_POST['keterangan'];
    $total = $_POST['total'];

    // Retrieve the last invoice number
    $sql = "SELECT invoice_number FROM kwitansi ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastInvoiceNumber = $row['invoice_number'];
        $newInvoiceNumber = str_pad(intval($lastInvoiceNumber) + 1, 5, '0', STR_PAD_LEFT);
    } else {
        $newInvoiceNumber = '00001';
    }

    $sql = "INSERT INTO kwitansi (nama, nominal, keterangan, total, invoice_number) VALUES ('$nama', '$nominal', '$keterangan', '$total', '$newInvoiceNumber')";

    if ($conn->query($sql) === TRUE) {
        $response = 'success';
    } else {
        $response = 'error';
    }

    $conn->close();
}

echo $response;