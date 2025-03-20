<?php
// delete_user.php
include('database/config.php');

// Check if the user_id is set in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare SQL query to delete user by user_id
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        // Redirect to the users list page with a success message
        header("Location: view_users.php?msg=User deleted successfully");
        exit();
    } else {
        // In case of error, show an error message
        echo "<p class='error-message'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
} else {
    // If no user_id is provided, show an error message
    echo "<p class='error-message'>No user ID provided for deletion.</p>";
}
?>
