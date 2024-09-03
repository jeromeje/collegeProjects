<?php
// Database configuration
$servername = "localhost"; // Usually 'localhost' if running on the same server
$username = "example_user";
$password = "example_password";
$dbname = "example_database";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";

// Close the connection (optional in simple scripts, good practice in long-running scripts)
mysqli_close($conn);
?>


To connect to a MySQL database using PHP, you can use either the `mysqli` extension (MySQL Improved) or the PDO (PHP Data Objects) extension. Below, I'll guide you through both methods, providing examples to help you understand how to establish a connection and interact with a MySQL database using PHP.

### **1. Connecting to MySQL Database Using `mysqli`**

The `mysqli` extension provides both procedural and object-oriented methods for interacting with MySQL databases. Below, I'll use the procedural style for simplicity.

#### **Steps to Connect Using `mysqli`:**

1. **Create a MySQL Database and User**: Ensure you have a database and user set up. For this example, let's assume:
   - **Database Name:** `example_database`
   - **Username:** `example_user`
   - **Password:** `example_password`
   - **Host:** `localhost`

2. **PHP Script for Database Connection Using `mysqli`:**

```php
<?php
// Database configuration
$servername = "localhost"; // Usually 'localhost' if running on the same server
$username = "example_user";
$password = "example_password";
$dbname = "example_database";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";

// Close the connection (optional in simple scripts, good practice in long-running scripts)
mysqli_close($conn);
?>
```

#### **Explanation:**

- **`mysqli_connect()`**: This function attempts to establish a connection to the MySQL database using the server name, username, password, and database name.
- **Error Handling**: The `if (!$conn)` statement checks if the connection was successful. If not, it terminates the script using `die()` and displays the connection error using `mysqli_connect_error()`.
- **`mysqli_close($conn)`**: This function closes the database connection. It is good practice to close the connection when it is no longer needed, especially in long-running scripts.

### **2. Connecting to MySQL Database Using PDO**

PDO (PHP Data Objects) is a more versatile extension that supports multiple database types. It provides a consistent interface for accessing databases and offers more robust error handling and prepared statements.

#### **Steps to Connect Using PDO:**

1. **PHP Script for Database Connection Using PDO:**

```php
<?php
// Database configuration
$dsn = "mysql:host=localhost;dbname=example_database;charset=utf8";
$username = "example_user";
$password = "example_password";

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected successfully";
    
    // Close the connection (optional, PDO does it automatically when script ends)
    $pdo = null;
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
```

#### **Explanation:**

- **DSN (Data Source Name)**: This string contains the information required to connect to the database. It includes the database type (`mysql`), host (`localhost`), database name (`example_database`), and charset (`utf8`).
- **Creating a PDO Instance**: `new PDO($dsn, $username, $password)` creates a new PDO instance to manage the connection to the database.
- **Error Handling**: Using `try...catch`, any exceptions thrown by PDO are caught and handled, preventing the script from breaking and allowing for custom error messages.
- **Closing the Connection**: Setting `$pdo = null` explicitly closes the connection. PDO automatically closes the connection when the script ends, but it's good practice to do this explicitly in scripts that handle multiple database operations.

### **3. Choosing Between `mysqli` and PDO**

- **`mysqli`**:
  - Best if you are working only with MySQL.
  - Offers both procedural and object-oriented styles.
  - Has built-in functions specifically designed for MySQL.

- **PDO**:
  - Supports multiple database types (MySQL, PostgreSQL, SQLite, etc.).
  - Uses a consistent interface for database interactions, making it easier to switch database types if needed.
  - Offers advanced features like prepared statements and transactions.

### **4. Example: Executing a Query Using `mysqli`**

Here’s how you can use `mysqli` to execute a simple SQL query and fetch results:

```php
<?php
$servername = "localhost";
$username = "example_user";
$password = "example_password";
$dbname = "example_database";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query
$sql = "SELECT id, name FROM users";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "ID: " . $row["id"] . " - Name: " . $row["name"] . "<br>";
    }
} else {
    echo "0 results";
}

// Close connection
mysqli_close($conn);
?>
```

### **5. Example: Executing a Query Using PDO**

Here’s how you can use PDO to execute a simple SQL query and fetch results:

```php
<?php
$dsn = "mysql:host=localhost;dbname=example_database;charset=utf8";
$username = "example_user";
$password = "example_password";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL query
    $stmt = $pdo->prepare("SELECT id, name FROM users");
    $stmt->execute();
    
    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($results as $row) {
        echo "ID: " . $row['id'] . " - Name: " . $row['name'] . "<br>";
    }
    
    // Close the connection
    $pdo = null;
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
```

### **Summary**

- Both `mysqli` and PDO are effective for connecting PHP to MySQL databases.
- Choose `mysqli` if you are only working with MySQL and prefer a simpler interface.
- Choose PDO for its flexibility, support for multiple database types, and advanced features.

By following these examples, you can successfully connect PHP to a MySQL database, execute queries, and fetch results using either `mysqli` or PDO. Always remember to handle errors and close connections to ensure your application runs smoothly and securely.

