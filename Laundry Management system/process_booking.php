<?php
include 'db.php';

// Get form data
$customer_name = $_POST['customer_name'];
$customer_id = $_POST['customer_id'];
$machine_id = $_POST['machine_id'];
$service_id = $_POST['service_id'];
$cloth_type = $_POST['cloth_type'];
$quantity = $_POST['quantity'];

// Verify customer exists
$verify_sql = "SELECT * FROM customers WHERE customer_id = $customer_id AND name = '$customer_name'";
$verify_result = $conn->query($verify_sql);

if($verify_result->num_rows == 0) {
    echo "<script>
        alert('❌ Customer not found! Please add customer first.');
        window.location.href = 'booking.php';
    </script>";
    exit();
}

// Get service details
$service_sql = "SELECT * FROM services WHERE service_id = $service_id";
$service_result = $conn->query($service_sql);
$service_row = $service_result->fetch_assoc();

$price = $service_row['price'];
$duration = $service_row['duration_minutes'];
$total_cost = $quantity * $price;
$service_name = $service_row['service_name'];

// Insert booking
$insert_sql = "INSERT INTO bookings (customer_id, machine_id, service_id, cloth_type, quantity, total_cost, status) 
               VALUES ($customer_id, $machine_id, $service_id, '$cloth_type', $quantity, $total_cost, 'pending')";

if ($conn->query($insert_sql) === TRUE) {
    $booking_id = $conn->insert_id;
    
    // Update machine status to busy
    $update_sql = "UPDATE machines SET status = 'busy', current_mode = '$service_name', time_remaining = $duration 
                   WHERE machine_id = $machine_id";
    $conn->query($update_sql);
    
    // Get customer details
    $customer_sql = "SELECT * FROM customers WHERE customer_id = $customer_id";
    $customer_result = $conn->query($customer_sql);
    $customer_row = $customer_result->fetch_assoc();
    
    // Show success message
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    
    <div class="booking-confirm">
        <h2>✅ Booking Confirmed!</h2>
        
        <div class="receipt">
            <h3>🧾 Booking Receipt</h3>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <td><b>Booking ID</b></td>
                    <td>#<?php echo $booking_id; ?></td>
                </tr>
                <tr>
                    <td><b>Customer</b></td>
                    <td><?php echo $customer_row['name']; ?></td>
                </tr>
                <tr>
                    <td><b>Phone</b></td>
                    <td><?php echo $customer_row['phone']; ?></td>
                </tr>
                <tr>
                    <td><b>Machine</b></td>
                    <td>Machine <?php echo $machine_id; ?></td>
                </tr>
                <tr>
                    <td><b>Mode</b></td>
                    <td><?php echo $service_name; ?></td>
                </tr>
                <tr>
                    <td><b>Cloth Type</b></td>
                    <td><?php echo $cloth_type; ?></td>
                </tr>
                <tr>
                    <td><b>Quantity</b></td>
                    <td><?php echo $quantity; ?></td>
                </tr>
                <tr>
                    <td><b>Duration</b></td>
                    <td><?php echo $duration; ?> minutes</td>
                </tr>
                <tr>
                    <td><b>Total Cost</b></td>
                    <td>₹<?php echo $total_cost; ?></td>
                </tr>
                <tr>
                    <td><b>Status</b></td>
                    <td class="free">🟢 Booked Successfully</td>
                </tr>
            </table>
            
            <br>
            <a href="dashboard.php" target="main">← Back to Dashboard</a>
            <a href="booking.php" target="main">📋 New Booking</a>
        </div>
    </div>
    
    </body>
    </html>
    <?php
} else {
    echo "Error: " . $insert_sql . "<br>" . $conn->error;
}

$conn->close();
?>