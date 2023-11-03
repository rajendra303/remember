<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the image data from the form
    $imageData = $_POST['image_data'];

    // You may want to save the image to a file (optional)
    $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
    $imageData = base64_decode($imageData);

    // Database connection settings
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPassword = '9528176114';
    $dbName = 'deepu';

    // Create a connection to the database
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL to insert image data into the 'uploaded_images' table
    $sql = "INSERT INTO uploaded_images (image_data) VALUES (?)";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind the image data to the prepared statement
        $stmt->bind_param("s", $imageData);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Image data successfully inserted into the database.";
        } else {
            echo "Error inserting image data: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error preparing SQL statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>



