<?php
include 'database/config.php';

// Check if car ID is provided
if (!isset($_GET['id'])) {
    echo "<script>alert('Car ID missing!'); window.location.href='available_cars.php';</script>";
    exit;
}

$car_id = $_GET['id'];

// Fetch car details
$sql = "SELECT * FROM cars WHERE id = $car_id AND status = 'available'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<script>alert('Car is already rented or unavailable.'); window.location.href='available_cars.php';</script>";
    exit;
}

$car = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $rental_days = $_POST['rental_days'];
    $total_price = $car['price_per_day'] * $rental_days;
    
    // Insert rental record
    $sql = "INSERT INTO rentals (car_id, customer_name, customer_email, rental_days, total_price, rental_date)
            VALUES ('$car_id', '$customer_name', '$customer_email', '$rental_days', '$total_price', NOW())";

    if ($conn->query($sql) === TRUE) {
        // Mark car as rented
        $conn->query("UPDATE cars SET status='rented' WHERE id=$car_id");
        echo "<script>alert('Car rented successfully!'); window.location.href='available_cars.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Car | Car Rental</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styling -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .form-label {
            font-weight: bold;
        }
        .car-details {
            background: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .total-price {
            font-weight: bold;
            color: #28a745;
        }
    </style>
    
    <script>
        function calculateTotal() {
            let pricePerDay = <?php echo $car['price_per_day']; ?>;
            let rentalDays = document.getElementById("rental_days").value;
            let total = pricePerDay * rentalDays;
            document.getElementById("total_price").innerText = total ? "$" + total.toFixed(2) : "$0.00";
        }
    </script>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="form-container">
        <h2 class="text-center text-primary mb-4">Rent Car</h2>
        
        <div class="car-details">
            <h5><?php echo $car['brand'] . ' ' . $car['model']; ?></h5>
            <p><strong>Year:</strong> <?php echo $car['year']; ?></p>
            <p><strong>Price per Day:</strong> $<?php echo $car['price_per_day']; ?></p>
        </div>
        
        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Your Name</label>
                <input type="text" name="customer_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Your Email</label>
                <input type="email" name="customer_email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Number of Rental Days</label>
                <input type="number" name="rental_days" id="rental_days" class="form-control" required min="1" onchange="calculateTotal()">
            </div>
            <div class="mb-3">
                <label class="form-label">Total Price:</label>
                <span class="total-price" id="total_price">$0.00</span>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-custom">Confirm Rental</button>
                <a href="available_cars.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
