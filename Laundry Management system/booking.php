<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        function updateDetails() {
            var service = document.getElementById("service").value;
            
            // Get service details via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_service_details.php?service_id=" + service, true);
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    document.getElementById("duration").innerHTML = data.duration + " min";
                    document.getElementById("cost").innerHTML = "₹" + data.price;
                }
            };
            xhr.send();
        }

        function checkCustomer() {
            var customerName = document.getElementById("customer_name").value;
            
            if(customerName.trim() == "") {
                document.getElementById("customer_status").innerHTML = "⚠️ Please enter customer name";
                document.getElementById("customer_status").style.color = "orange";
                document.getElementById("customer_id_hidden").value = "";
                return;
            }

            // AJAX call to check if customer exists
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "check_customer.php?name=" + encodeURIComponent(customerName), true);
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    
                    if(response.exists) {
                        document.getElementById("customer_status").innerHTML = "✅ Customer exists! Customer ID: " + response.customer_id;
                        document.getElementById("customer_status").style.color = "green";
                        document.getElementById("customer_id_hidden").value = response.customer_id;
                    } else {
                        document.getElementById("customer_status").innerHTML = "❌ Customer not found! Please add customer first.";
                        document.getElementById("customer_status").style.color = "red";
                        document.getElementById("customer_id_hidden").value = "";
                    }
                }
            };
            xhr.send();
        }
    </script>
</head>
<body>

<div class="booking">
    <h2>📋 Book a Washing Machine</h2>
    
    <form action="process_booking.php" method="POST" target="main" onsubmit="return validateForm()">
        
        <div class="form-group">
            <label>👤 Customer Name:</label>
            <input type="text" id="customer_name" name="customer_name" 
                   placeholder="Enter customer name" 
                   onkeyup="checkCustomer()" required>
            <span id="customer_status" style="display:block; margin-top:5px; font-size:14px;"></span>
            <input type="hidden" id="customer_id_hidden" name="customer_id" value="">
            <small style="color: #666;">Type customer name to check if they exist</small>
        </div>
        
        <div class="form-group">
            <label>🔄 Select Machine:</label>
            <select name="machine_id" required>
                <option value="">-- Select Machine --</option>
                <?php
                $sql = "SELECT * FROM machines WHERE status = 'free'";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['machine_id'] . "'>" . $row['machine_name'] . " (Free)</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>⚙️ Select Mode:</label>
            <select name="service_id" id="service" onchange="updateDetails()" required>
                <option value="">-- Select Mode --</option>
                <?php
                $sql = "SELECT * FROM services";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['service_id'] . "'>" . $row['service_name'] . " - ₹" . $row['price'] . "</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>👕 Cloth Type:</label>
            <select name="cloth_type" required>
                <option>Bedding</option>
                <option>Shirt</option>
                <option>Jeans</option>
                <option>T-Shirt</option>
                <option>Dress</option>
                <option>Jacket</option>
                <option>Other</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>🔢 Quantity:</label>
            <input type="number" name="quantity" min="1" value="1" required>
        </div>
        
        <div class="details-box">
            <h3>📊 Service Details</h3>
            <p>⏱️ Duration: <span id="duration">--</span></p>
            <p>💰 Cost per item: <span id="cost">--</span></p>
        </div>
        
        <input type="submit" value="✅ Book Machine">
        <input type="reset" value="❌ Clear" onclick="resetForm()">
        
    </form>
</div>

<script>
function validateForm() {
    var customerId = document.getElementById("customer_id_hidden").value;
    
    if(customerId == "") {
        alert("❌ Customer not found! Please add customer first.");
        return false;
    }
    
    return true;
}

function resetForm() {
    document.getElementById("customer_status").innerHTML = "";
    document.getElementById("customer_id_hidden").value = "";
    document.getElementById("duration").innerHTML = "--";
    document.getElementById("cost").innerHTML = "--";
}
</script>

</body>
</html>