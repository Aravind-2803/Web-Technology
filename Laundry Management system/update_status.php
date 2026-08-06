<?php
include 'db.php';
if(isset($_GET['id']) && isset($_GET['status'])) {
    $booking_id = $_GET['id'];
    $new_status = $_GET['status'];
    // Get booking details to update machine status
    $booking_sql = "SELECT machine_id, status FROM bookings WHERE booking_id = $booking_id";
    $booking_result = $conn->query($booking_sql);
    $booking_row = $booking_result->fetch_assoc();
    $machine_id = $booking_row['machine_id'];
    // Update booking status
    $update_sql = "UPDATE bookings SET status = '$new_status' WHERE booking_id = $booking_id";
    if ($conn->query($update_sql) === TRUE) {
        // If status is completed, free the machine
        if($new_status == 'completed') {
            $free_machine = "UPDATE machines SET status = 'free', current_mode = NULL, time_remaining = 0 WHERE machine_id = $machine_id";
            $conn->query($free_machine);
        }       
        echo "<script>
            alert('✅ Status updated to " . strtoupper($new_status) . " successfully!');
            window.location.href = 'history.php';
        </script>";
    } else {
        echo "Error updating status: " . $conn->error;
    }
} else {
    header("Location: history.php");
}
$conn->close();
?>