<?php
        // Check if the form was submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the selected blood group
            $bloodGroup = $_POST['bloodGroup'];

            // Connect to the database
            $servername = "localhost";
            $username = "root";  // Default XAMPP username
            $password = "";      // Default XAMPP password is empty
            $dbname = "blood_donation";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query the database
            $sql = "SELECT name, age, blood_group, contact FROM donors WHERE blood_group = '$bloodGroup'";
            $result = $conn->query($sql);

            // Display the results
            if ($result->num_rows > 0) {
                echo '<div class="mt-4">';
                echo '<h4 class="text-center">Search Results</h4>';
                echo '<table class="table table-striped">';
                echo '<thead><tr><th>Name</th><th>Age</th><th>Blood Group</th><th>Contact</th></tr></thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["name"] . "</td><td>" . $row["age"] . "</td><td>" . $row["blood_group"] . "</td><td>" . $row["contact"] . "</td></tr>";
                }
                echo '</tbody></table></div>';
            } else {
                echo '<div class="alert alert-info mt-4 text-center">No results found for the selected blood group.</div>';
            }

            // Close connection
            $conn->close();
        }
        ?>