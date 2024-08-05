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

$sql = "SELECT invoice_number, nama, nominal, keterangan, total FROM kwitansi ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='kwitansi-list-container'>";
    while ($row = $result->fetch_assoc()) {
        $formattedInvoiceNumber = str_pad($row["invoice_number"], 5, '0', STR_PAD_LEFT);
        echo "<div class='kwitansi-item-container' data-invoice-number='" . $row["invoice_number"] . "'>
                <p class='kwitansi-item'>Invoice No: " . $formattedInvoiceNumber . "</p>
                <p class='kwitansi-item'>Nama: " . $row["nama"] . "</p>
                <p class='kwitansi-item'>Nominal: " . $row["nominal"] . "</p>
                <p class='kwitansi-item'>Keterangan: " . $row["keterangan"] . "</p>
                <p class='kwitansi-item'>Total: Rp." . $row["total"] . "</p>
              </div>";
    }
    echo "</div>";
} else {
    echo "<p>Tidak ada kwitansi.</p>";
}

$conn->close();