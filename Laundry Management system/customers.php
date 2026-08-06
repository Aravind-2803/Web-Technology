<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="customers">
    <h2>👤 Customer Management</h2>
    
    <!-- Add Customer Form -->
    <div class="add-customer">
        <h3>➕ Add New Customer</h3>
        <form action="add_customer.php" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="email" name="email" placeholder="Email">
            <input type="text" name="address" placeholder="Address">
            <input type="submit" value="Add Customer">
        </form>
    </div>
    
    <!-- Customer List with Delete Option -->
    <div class="customer-list">
        <h3>📋 Customer List</h3>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            <?php
            $sql = "SELECT * FROM customers ORDER BY customer_id DESC";
            $result = $conn->query($sql);
            
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['customer_id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>
                        <a href='delete_customer.php?id=" . $row['customer_id'] . "' 
                           onclick='return confirm(\"Are you sure you want to delete this customer?\")' 
                           class='delete-btn'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>