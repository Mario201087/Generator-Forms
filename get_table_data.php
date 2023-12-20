<?php
require('connect.php');

if (isset($_GET['tableName'])) {
    $tableName = $_GET['tableName'];

    // Fetch values for 'Name' column
    $sqlNameColumn = "SELECT Name FROM `$tableName` WHERE id = 1";
    $resultNameColumn = $conn->query($sqlNameColumn);

    if ($resultNameColumn->num_rows > 0) {
        $nameTableValues = array();

        while ($nameRow = $resultNameColumn->fetch_assoc()) {
            $nameTableValues[] = $nameRow['Name'];
        }

        // Select all columns except 'id' and columns named 'Name'
        $sqlColumns = "SELECT COLUMN_NAME 
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_NAME = '$tableName'
                AND COLUMN_NAME NOT IN ('id', 'Name')";

        $resultColumns = $conn->query($sqlColumns);

        if ($resultColumns->num_rows > 0) {
            $columns = array();

            while ($row = $resultColumns->fetch_assoc()) {
                $columns[] = $row['COLUMN_NAME'];
            }

            // Fetch entire table data
            $sqlData = "SELECT * FROM `$tableName`";
            $resultData = $conn->query($sqlData);

            // Fetch counted values
            $data = array();
            if ($resultData->num_rows > 0) {
                while ($row = $resultData->fetch_assoc()) {
                    $data[] = $row;
                }

                $countedData = array();
                foreach ($columns as $columnName) {
                    $countedValues = array_count_values(array_map('strval', array_column($data, $columnName)));
                    foreach ($countedValues as $value => $count) {
                        $countedData[] = array(
                            'Kolumna' => $columnName,
                            'Wartość' => $value,
                            'Częstość' => $count
                        );
                    }
                }

                // JSON response for entire table
                $responseTable = array(
                    'success' => true,
                    'columns' => $columns,
                    'data' => $data,
                    'tableName' => $tableName,
                    'nameTableValues' => $nameTableValues // Include 'Name' column values
                );

                // JSON response for counted values
                $responseCounted = array(
                    'success' => true,
                    'countedData' => $countedData
                );

                // Sending JSON responses
                header('Content-Type: application/json');
                echo json_encode($responseTable);

                // Separate the responses with a newline character
                echo "\n";

                echo json_encode($responseCounted);
            } else {
                // Handling the case when there is no data in the table
                $response = array(
                    'success' => false,
                    'message' => "Brak danych w tabeli $tableName."
                );

                header('Content-Type: application/json');
                echo json_encode($response);
            }
        } else {
            // Handling the case when there are no columns in the table
            $response = array(
                'success' => false,
                'message' => "Brak danych w tabeli $tableName."
            );

            header('Content-Type: application/json');
            echo json_encode($response);
        }
    } else {
        // Handling the case when there are no 'Name' column values
        $response = array(
            'success' => false,
            'message' => "Brak danych w kolumnie 'Name' tabeli $tableName."
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    $conn->close();
} else {
    // Handling the case when the table name is not provided in the GET parameter
    $response = array(
        'success' => false,
        'message' => "Brak nazwy tabeli w parametrze GET."
    );

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
