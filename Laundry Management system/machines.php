<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="machines">
    <h2>🔄 Machine Status</h2>
    
    <div class="machine-grid">
        <?php
        $sql = "SELECT * FROM machines";
        $result = $conn->query($sql);
        
        while($row = $result->fetch_assoc()) {
            $status_class = ($row['status'] == 'free') ? 'free' : 'busy';
            echo "<div class='machine " . $status_class . "'>";
            echo "<h3>" . $row['machine_name'] . "</h3>";
            
            if($row['status'] == 'free') {
                echo "<p class='free'>🟢 Free</p>";
                echo "<p>Time: --</p>";
            } else {
                echo "<p class='busy'>🔴 Busy</p>";
                echo "<p>Time: " . $row['time_remaining'] . " min left</p>";
                echo "<p>Mode: " . $row['current_mode'] . "</p>";
            }
            
            echo "</div>";
        }
        ?>
    </div>
</div>

</body>
</html>