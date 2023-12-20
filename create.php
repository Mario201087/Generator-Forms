<?php
include('connect.php');
header('Content-Type: application/json');

// Odczytaj dane POST jako JSON
$input_data = json_decode(file_get_contents("php://input"), true);

// Sprawdź, czy dane istnieją
if (!$input_data || empty($input_data['sql'])) {
    echo json_encode(['success' => false, 'message' => 'Brak danych POST.']);
    exit();
}

// Execute SQL query on the database
$sql = $input_data['sql'];

// Wykonaj zapytanie SQL na bazie danych
// Pamiętaj, że ten kod jest podatny na ataki SQL Injection. W prawdziwej aplikacji używaj przygotowanych instrukcji SQL.

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Błąd połączenia z bazą danych: ' . $conn->connect_error]);
    exit();
}

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Zapytanie SQL zostało wykonane pomyślnie.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Błąd podczas wykonywania zapytania SQL: ' . $conn->error]);
}

$conn->close();
?>
