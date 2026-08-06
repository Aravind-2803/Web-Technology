<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="history">
    <h2>📜 Booking History</h2>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Booking ID</th>
            <th>Customer</th>
            <th>Machine</th>
            <th>Mode</th>
            <th>Cloth Type</th>
            <th>Quantity</th>
            <th>Total Cost</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT b.*, c.name as customer_name, m.machine_name, s.service_name 
                FROM bookings b 
                JOIN customers c ON b.customer_id = c.customer_id 
                JOIN machines m ON b.machine_id = m.machine_id 
                JOIN services s ON b.service_id = s.service_id 
                ORDER BY b.booking_id DESC";
        
        $result = $conn->query($sql);
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>#" . $row['booking_id'] . "</td>";
            echo "<td>" . $row['customer_name'] . "</td>";
            echo "<td>" . $row['machine_name'] . "</td>";
            echo "<td>" . $row['service_name'] . "</td>";
            echo "<td>" . $row['cloth_type'] . "</td>";
            echo "<td>" . $row['quantity'] . "</td>";
            echo "<td>₹" . $row['total_cost'] . "</td>";
            
            $status_class = $row['status'];
            echo "<td class='$status_class'>" . strtoupper($row['status']) . "</td>";
            
            echo "<td>" . $row['booking_date'] . "</td>";
            
            // Status Update Action
            echo "<td>";
            if($row['status'] == 'pending') {
                echo "<a href='update_status.php?id=" . $row['booking_id'] . "&status=processing' class='status-btn processing-btn'>▶ Start Processing</a>";
            } elseif($row['status'] == 'processing') {
                echo "<a href='update_status.php?id=" . $row['booking_id'] . "&status=completed' class='status-btn complete-btn'>✅ Mark Completed</a>";
            } elseif($row['status'] == 'completed') {
                echo "<span class='completed-text'>✅ Done</span>";
            } else {
                echo "<span class='cancelled-text'>❌ Cancelled</span>";
            }
            echo "</td>";
            
            echo "</tr>";
        }
        ?>
    </table>
</div>

</body>
</html>