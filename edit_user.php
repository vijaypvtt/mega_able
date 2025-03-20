<?php
// edit_user.php
include('database/config.php');

// Check if the user ID is provided in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch the user data from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the user exists, fetch the user data
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "<p class='error-message'>User not found!</p>";
        exit();
    }

    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash the new password if provided
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone_number = ?, password_hash = ?, role = ? WHERE user_id = ?");
        $stmt->bind_param("ssssssi", $first_name, $last_name, $email, $phone_number, $password_hash, $role, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone_number = ?, role = ? WHERE user_id = ?");
        $stmt->bind_param("sssssi", $first_name, $last_name, $email, $phone_number, $role, $user_id);
    }

    if ($stmt->execute()) {
        echo "<p class='success-message'>User updated successfully!</p>";
    } else {
        echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
        /* General reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fc;
    color: #333;
    line-height: 1.6;
}

/* Container styling */
.container {
    width: 60%;
    margin: 50px auto;
    padding: 30px;
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    max-width: 800px;
}

/* Heading */
h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Form group styling */
.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
    font-size: 16px;
}

input, select {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    background-color: #f9f9f9;
    color: #333;
}

input:focus, select:focus {
    outline: none;
    border-color: #4CAF50;
    background-color: #fff;
}

/* Button styling */
button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    width: 100%;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

/* Error and Success message styling */
.success-message {
    color: green;
    font-size: 18px;
    text-align: center;
    margin-top: 20px;
}

.error-message {
    color: red;
    font-size: 18px;
    text-align: center;
    margin-top: 20px;
}

/* Back to list button */
.btn-back {
    display: block;
    text-align: center;
    margin-top: 20px;
    font-size: 16px;
    color: #4CAF50;
    text-decoration: none;
    padding: 10px 0;
}

.btn-back:hover {
    text-decoration: underline;
}

/* Responsive styling */
@media screen and (max-width: 768px) {
    .container {
        width: 90%;
    }
}

    </style>
    <div class="container">
        <h1>Edit User</h1>

        <!-- Display Success or Error Messages -->
        <?php if (isset($msg)): ?>
            <p class="error-message"><?php echo $msg; ?></p>
        <?php endif; ?>

        <form method="POST" action="edit_user.php?id=<?php echo $user['user_id']; ?>">

            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $user['first_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $user['last_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" value="<?php echo $user['phone_number']; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password (leave empty to keep the current password)</label>
                <input type="password" id="password" name="password" placeholder="Enter new password">
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                    <option value="owner" <?php echo ($user['role'] == 'owner') ? 'selected' : ''; ?>>Owner</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit">Update User</button>
            </div>
        </form>

        <a href="view_users.php" class="btn-back">Back to Users List</a>
    </div>
</body>
</html>
