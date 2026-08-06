<?php
include 'db.php';

if(isset($_GET['id'])) {
    $customer_id = $_GET['id'];
    
    // Step 1: Get customer name for confirmation message
    $get_customer = "SELECT name FROM customers WHERE customer_id = $customer_id";
    $customer_result = $conn->query($get_customer);
    $customer_row = $customer_result->fetch_assoc();
    $customer_name = $customer_row['name'];
    
    // Step 2: Delete all bookings for this customer
    $delete_bookings = "DELETE FROM bookings WHERE customer_id = $customer_id";
    
    if ($conn->query($delete_bookings) === TRUE) {
        // Step 3: Now delete the customer
        $delete_customer = "DELETE FROM customers WHERE customer_id = $customer_id";
        
        if ($conn->query($delete_customer) === TRUE) {
            echo "<script>
                alert('✅ Customer \"$customer_name\" and all their bookings deleted successfully!');
                window.location.href = 'customers.php';
            </script>";
        } else {
            echo "Error deleting customer: " . $conn->error;
        }
    } else {
        echo "Error deleting bookings: " . $conn->error;
    }
} else {
    header("Location: customers.php");
}

$conn->close();
?>