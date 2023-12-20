<?php
include('connect.php');

// Check if the form was submitted from a valid source
if (isset($_SERVER['HTTP_REFERER'])) {
    $referer = $_SERVER['HTTP_REFERER'];
    echo "Formularz został wysłany ze strony: $referer";

    // Extract the table name from the URL path
    $path = parse_url($referer, PHP_URL_PATH);
    $pathSegments = explode('/', $path);
    $tableName = end($pathSegments);

    // Process POST data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
       // Get form data
        $formData = $_POST;

        // Initialize arrays for field names and values
        $fieldNames = array();
        $fieldValues = array();

        foreach ($formData as $fieldName => $value) {
            // Sanitize the field name to create a valid column name
            $sanitizedFieldName = preg_replace("/[^a-zA-Z0-9_]/", "_", str_replace(" ", "_", $fieldName));

            // Check if the sanitized field name is not empty
            if (!empty($sanitizedFieldName)) {
                $fieldNames[] = $sanitizedFieldName;
                $fieldValues[] = $conn->real_escape_string($value); // Escape values to prevent SQL injection
            }
        }

        // Check if there are non-empty field names
        if (!empty($fieldNames)) {
            // Create the SQL query for inserting data into the table
            $sql = "INSERT INTO `$tableName` (id, " . implode(', ', $fieldNames) . ") VALUES (NULL, '" . implode("', '", $fieldValues) . "')";

            // Execute the SQL query
            if ($conn->query($sql) === TRUE) {
                echo "<script>
                    window.location.href = 'success_page.php'
                </script>";
            } else {
                echo "Błąd przy dodawaniu danych do tabeli: " . $conn->error;
                echo " Zapytanie SQL: " . $sql; // Display the actual SQL query in case of an error
            }
        } else {
            echo "<script>
                    window.location.href = 'success_page.php'
                </script>";
        }
    } else {
        echo "Nieprawidłowa metoda żądania.";
    }
} else {
    echo "Nie można uzyskać informacji o stronie źródłowej.";
}

// Close the database connection
$conn->close();
?>
