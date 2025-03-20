<?php
include 'database/config.php';



// Mark car as under maintenance
if (isset($_GET['maintain_id'])) {
    $car_id = $_GET['maintain_id'];
    $conn->query("UPDATE cars SET status='maintenance' WHERE id=$car_id");
    echo "<script>alert('Car marked as under maintenance!'); window.location.href='admin_maintenance.php';</script>";
}

// Mark car as available after maintenance
if (isset($_GET['available_id'])) {
    $car_id = $_GET['available_id'];
    $conn->query("UPDATE cars SET status='available' WHERE id=$car_id");
    echo "<script>alert('Car is now available!'); window.location.href='admin_maintenance.php';</script>";
}

// Fetch all cars
$sql = "SELECT * FROM cars ORDER BY status DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Car Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { margin-top: 50px; }
        .btn-maintain { background-color: #ffc107; color: black; }
        .btn-maintain:hover { background-color: #e0a800; }
        .btn-available { background-color: #28a745; color: white; }
        .btn-available:hover { background-color: #218838; }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center text-primary mb-4">Car Maintenance Management</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Car</th>
                <th>Model</th>
                <th>Year</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['brand']; ?></td>
                <td><?php echo $row['model']; ?></td>
                <td><?php echo $row['year']; ?></td>
                <td><span class="badge bg-<?php echo ($row['status'] == 'maintenance') ? 'warning' : 'success'; ?>"> <?php echo ucfirst($row['status']); ?> </span></td>
                <td>
                    <?php if ($row['status'] != 'maintenance') { ?>
                        <a href="admin_maintenance.php?maintain_id=<?php echo $row['id']; ?>" class="btn btn-maintain btn-sm">Mark as Maintenance</a>
                    <?php } else { ?>
                        <a href="admin_maintenance.php?available_id=<?php echo $row['id']; ?>" class="btn btn-available btn-sm">Mark as Available</a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
