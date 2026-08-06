<?php
include 'db.php';

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];

$sql = "INSERT INTO customers (name, phone, email, address) 
        VALUES ('$name', '$phone', '$email', '$address')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
        alert('Customer added successfully!');
        window.location.href = 'customers.php';
    </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>