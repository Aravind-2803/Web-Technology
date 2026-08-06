<?php
include 'db.php';

// Get machine statistics
$total_machines = 6;
$free_query = "SELECT COUNT(*) as free_count FROM machines WHERE status = 'free'";
$free_result = $conn->query($free_query);
$free_row = $free_result->fetch_assoc();
$free_count = $free_row['free_count'];
$busy_count = $total_machines - $free_count;
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="dashboard">
    <h2>📊 Machine Status Overview</h2>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Machine No.</th>
            <th>Status</th>
            <th>Time Remaining</th>
            <th>Mode</th>
        </tr>
        <?php
        $sql = "SELECT * FROM machines";
        $result = $conn->query($sql);
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><b>" . $row['machine_name'] . "</b></td>";
            
            if($row['status'] == 'free') {
                echo "<td class='free'>🟢 Free</td>";
                echo "<td>--</td>";
                echo "<td>--</td>";
            } else {
                echo "<td class='busy'>🔴 Busy</td>";
                echo "<td>" . $row['time_remaining'] . " min</td>";
                echo "<td>" . $row['current_mode'] . "</td>";
            }
            
            echo "</tr>";
        }
        ?>
    </table>
    
    <div class="summary">
        <h3>📈 Summary</h3>
        <p>Total Machines: <b>6</b></p>
        <p>Free Machines: <b class="free"><?php echo $free_count; ?></b></p>
        <p>Busy Machines: <b class="busy"><?php echo $busy_count; ?></b></p>
    </div>
</div>

</body>
</html>