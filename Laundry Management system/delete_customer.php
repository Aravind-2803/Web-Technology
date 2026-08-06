<?php
include 'db.php';

if(isset($_GET['id'])) {
    $customer_id = $_GET['id'];
    
    // Check if customer has any bookings
    $check_sql = "SELECT COUNT(*) as count FROM bookings WHERE customer_id = $customer_id";
    $check_result = $conn->query($check_sql);
    $check_row = $check_result->fetch_assoc();
    $booking_count = $check_row['count'];
    
    if($booking_count > 0) {
        // Customer has bookings - Show warning page
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <link rel="stylesheet" type="text/css" href="style.css">
        </head>
        <body>
            <div class="delete-warning">
                <div class="warning-box">
                    <h2>⚠️ Cannot Delete Customer</h2>
                    <div class="warning-icon">⚠️</div>
                    <p>This customer has <strong><?php echo $booking_count; ?></strong> booking(s) in the system.</p>
                    <p style="color: #666; font-size: 14px;">You have two options:</p>
                    
                    <div class="warning-options">
                        <div class="option-box">
                            <h3>Option 1: Delete Everything</h3>
                            <p>Delete this customer AND all their bookings</p>
                            <a href="delete_customer_force.php?id=<?php echo $customer_id; ?>" 
                               class="btn-danger"
                               onclick="return confirm('⚠️ WARNING: This will delete ALL bookings for this customer! Are you sure?')">
                                🗑️ Delete Customer & All Bookings
                            </a>
                        </div>
                        
                        <div class="option-box">
                            <h3>Option 2: Cancel</h3>
                            <p>Go back to customer list</p>
                            <a href="customers.php" class="btn-cancel">
                                ← Go Back to Customers
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        // Customer has no bookings - Delete directly
        $sql = "DELETE FROM customers WHERE customer_id = $customer_id";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                alert('✅ Customer deleted successfully!');
                window.location.href = 'customers.php';
            </script>";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
} else {
    header("Location: customers.php");
}

$conn->close();
?>