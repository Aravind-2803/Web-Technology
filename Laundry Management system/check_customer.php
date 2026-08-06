<?php
include 'db.php';

if(isset($_GET['name'])) {
    $customer_name = $_GET['name'];
    
    $sql = "SELECT customer_id, name FROM customers WHERE name = '$customer_name'";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = array(
            'exists' => true,
            'customer_id' => $row['customer_id'],
            'name' => $row['name']
        );
    } else {
        $response = array(
            'exists' => false,
            'customer_id' => null
        );
    }
    
    echo json_encode($response);
}

$conn->close();
?>