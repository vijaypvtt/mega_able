<?php
include 'database/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $price_per_day = $_POST['price_per_day'];
    $status = 'available'; // Default status

    // Handle Image Upload
    $image = $_FILES['image']['name'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Insert into database
        $sql = "INSERT INTO cars (brand, model, year, price_per_day, image, status) 
                VALUES ('$brand', '$model', '$year', '$price_per_day', '$image', '$status')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Car added successfully!'); window.location.href='available_cars.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car | Car Rental</title>
    
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
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="form-container">
        <h2 class="text-center text-primary mb-4">Add a New Car</h2>
        <form action="add_cars.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Car Brand</label>
                <input type="text" name="brand" class="form-control" required placeholder="e.g., Tesla">
            </div>
            <div class="mb-3">
                <label class="form-label">Car Model</label>
                <input type="text" name="model" class="form-control" required placeholder="e.g., Model S">
            </div>
            <div class="mb-3">
                <label class="form-label">Manufacture Year</label>
                <input type="number" name="year" class="form-control" required min="1990" max="2025">
            </div>
            <div class="mb-3">
                <label class="form-label">Price per Day ($)</label>
                <input type="number" name="price_per_day" class="form-control" required step="0.01">
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Car Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-custom">Add Car</button>
                <a href="available_cars.php" class="btn btn-secondary">Back to Listings</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
