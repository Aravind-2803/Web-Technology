<?php
include 'db.php';

if(isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];
    
    $sql = "SELECT * FROM services WHERE service_id = $service_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
    $response = array(
        'duration' => $row['duration_minutes'],
        'price' => $row['price']
    );
    
    echo json_encode($response);
}
?>