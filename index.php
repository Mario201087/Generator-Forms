<?php
session_start();
include('connect.php');

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    // User is not logged in, redirect to the login page
    header("Location: login.php");
    exit(); // Ensure the script exits after redirection
}

$ownerValue = $_SESSION['login'];

// Query to retrieve all tables starting with the owner value
$query = "SHOW TABLES LIKE '$ownerValue%'";
$result = $conn->query($query);

$tables = [];

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_row()) {
            $tableName = $row[0];

            // Exclude the 'users' table
            if ($tableName != 'users') {
                // Fetch the default value of 'Name' column from the INFORMATION_SCHEMA.COLUMNS
                $defaultValueQuery = "SELECT COLUMN_DEFAULT FROM INFORMATION_SCHEMA.COLUMNS
                                      WHERE TABLE_NAME = '$tableName' AND COLUMN_NAME = 'Name'";
                $defaultValueResult = $conn->query($defaultValueQuery);

                if ($defaultValueResult !== false && $defaultValueResult->num_rows > 0) {
                    $defaultValueRow = $defaultValueResult->fetch_assoc();
                    $defaultValue = $defaultValueRow['COLUMN_DEFAULT'];

                    // If the default value is NULL, handle it as needed
                    if ($defaultValue === null || strtoupper($defaultValue) === 'NULL') {
                        $defaultValue = "Default Name"; // Set a default value if needed
                    } else {
                        // Remove any quotes around the default value
                        $defaultValue = trim($defaultValue, "'");
                    }

                    $tables[] = ['table' => $tableName, 'name' => $defaultValue];
                } else {
                    if ($defaultValueResult === false) {
                        echo "Error executing query: " . $conn->error;
                    } else {
                        // If no default value is found, handle it as needed
                        $defaultValue = "Default Name"; // Set a default value if needed
                        $tables[] = ['table' => $tableName, 'name' => $defaultValue];
                    }
                }
            }
        }
    }
} else {
    echo "Error executing query: " . $conn->error;
}
$result->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3y^D65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="logo.png">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Generator Forms</title>
</head>

<body>
    <div id="wrapper">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <h2>createplus</h2>
            </div>
            <ul class="sidebar-nav">
                <li class="draggable" onclick="createFormElement('Input Text')">
                    <a href="#"><i class="fa fa-code" aria-hidden="true"></i>Input Text</a>
                </li>
                <li class="draggable" onclick="createFormElement('Select')">
                    <a href="#"><i class="fa fa-code" aria-hidden="true"></i>Select</a>
                </li>
                <li>
                    <a href="#">
                        <button id="configureForm" class="btn btn-warning col-10 mb-1"
                            onclick="createFormElement('Button')">
                            <i class="fa fa-search" style="margin-left: -103px; margin-right: 7px;"
                                aria-hidden="true"></i>Pobierz
                        </button>
                    </a>
                </li>
                <li>
                    <?php if (isset($_SESSION['login'])) : ?>
                        <a href="#" id="userLoginLink" onclick="toggleTableList()">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <?php echo $_SESSION['login']; ?>
                            <?php if (!empty($tables)) : ?>
                                <ul id="tableList" style="display: none;">
                                    <?php foreach ($tables as $table) : ?>
                                        <li data-table="<?php echo $table['table']; ?>"
                                            onclick="loadTableFields('<?php echo $table['table']; ?>')">
                                            <?php echo $table['name']; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </a>
                        <a href="logout.php"> <!-- Add this line for Log Out -->
                            <i class="fa fa-sign-out" aria-hidden="true"></i> Log Out
                        </a>
                    <?php else : ?>
                        <a href="login.php">
                            <i class="fa fa-sign-in" aria-hidden="true"></i> Log In
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </aside>

        <div id="navbar-wrapper">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
                    </div>
                </div>
            </nav>
        </div>

        <section id="content-wrapper" class="d-flex justify-content-center align-items-center"
            style="height: 88vh;">
            <div class="row d-flex justify-content-center align-items-center col-12 m-0 p-0 h-100">
                <div class="col-lg-6 col-12 m-0 p-0" id="yourTableContainer">
                    <form class="p-2 mx-auto pe-auto" id="yourIdx" data-element-type="FORM" data-idx="yourIdx"
                        method="POST">
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="configureModal" tabindex="-1" aria-labelledby="configureModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="configureModalLabel">Configure Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formName" class="form-label">Form Name</label>
                        <input type="text" class="form-control" id="formName"
                            style="background-color: #e6f7ff; border: 1px solid #3399ff; color: #000; border-radius: 5px;">
                    </div>
                    <div class="mb-3">
                        <label for="formAction" class="form-label">Form Action</label>
                        <input type="text" class="form-control" id="formAction"
                            style="background-color: #e6f7ff; border: 1px solid #3399ff; color: #000; border-radius: 5px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveFormConfig">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="configureModaltable" tabindex="-1" aria-labelledby="configureModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveFormConfig">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for displaying the error message -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Błąd</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onClick="closeModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="errorModalBody">
                    <!-- Error message will be displayed here -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tableModal" tabindex="-1" role="dialog" aria-labelledby="tableModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tableModalLabel">Tabela</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr></tr>
                        </thead>
                        <tbody id="tableModalBody"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="printModalButton">Pobierz jako XML</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
       // Function to toggle the display of the table list
function toggleTableList() {
    var tableList = document.getElementById("tableList");
    tableList.style.display = (tableList.style.display === "none") ? "block" : "none";
}

// Function to clear the modal content
// Function to close the modal and remove the table
function closeModal() {
    // Dispose of the modal
    console.log('Script started');
    
    // Remove the table inside the modal
    $('#tableModalBody').empty();
    
    // Optionally, you can hide the modal instead of disposing it
    $('#tableModal').modal('hide');
    $('#errorModal').modal('hide');
}

// Function to load table fields
function loadTableFields(tableName) {
    // Clear the modal content before loading new data
    $.ajax({
        type: "GET",
        url: "get_table_data.php?tableName=" + tableName,
        dataType: "text",
        success: function (response) {
            var responses = response.trim().split('\n');

            var titleSet = false;
            var linkSet = false;

            responses.forEach(function (jsonString) {
                var parsedResponse = JSON.parse(jsonString);

                if (parsedResponse.success === false) {
                    $('#errorModalBody').text(parsedResponse.message);
                    $('#errorModal').modal('show');
                    $('#yourTableContainer').empty();
                    return;
                }

                if (!titleSet) {
                    if (parsedResponse.columns && parsedResponse.data) {
                        displayTable(parsedResponse.columns, parsedResponse.data, tableName, 'Whole Table', parsedResponse.nameTableValues);
                        titleSet = true;
                    }
                }

                if (!linkSet && parsedResponse.countedData) {
                    displayTable(['Kolumna', 'Wartość', 'Częstość'], parsedResponse.countedData, tableName, 'Counted Values', parsedResponse.nameTableValues);
                    createDownloadLink(tableName);
                    linkSet = true;
                }
            });
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText);
            console.error("Status:", status);
            console.error("Error:", error);

            $('#noRecordsModal').modal('show');
            $('#yourTableContainer').empty();
        }
    });
}

// Function to open the modal
function openModal(tableName) {
    // Set the table name in the modal title using html()
    $('#tableModalLabel').html(tableName);

    // Display the modal
    $('#tableModal').modal('show');

    // Load table fields and data
    loadTableFields(tableName);
}

// Function to create the download link
function createDownloadLink(tableName) {
    // Remove any existing link
    $('#downloadLink').remove();

    // Add the download link to the modal body
    var downloadLink = $('<a id="downloadLink" href="#">Link to Form: ' + tableName + '</a>');
    downloadLink.attr('href', tableName);

    $('#tableModalBody').append(downloadLink);
}

// Function to display the table
function displayTable(columns, data, tableName, nameTableValue) {
    var htmlTable = '<table id="example" class="table table-striped nowrap" style="width:100%">';
    htmlTable += '<thead><tr>';

    columns.forEach(function (column) {
        htmlTable += '<th>' + column + '</th>';
    });

    htmlTable += '</tr></thead>';
    htmlTable += '<tbody>';

    data.forEach(function (row) {
        htmlTable += '<tr>';
        columns.forEach(function (column) {
            htmlTable += '<td>' + row[column] + '</td>';
        });
        htmlTable += '</tr>';
    });

    htmlTable += '</tbody></table>';

    // Append the new table to the modal content
    $('#tableModalBody').append(htmlTable);

    // Set the table name in the modal title using html()
    $('#tableModalLabel').html(nameTableValue);

    // Display the modal
    $('#tableModal').modal('show');
}


// Attach an event listener to the modal hide event
$(document).on('click', function (e) {
    if ($(e.target).hasClass('modal')) {
        console.log('Click outside modal');
        // Clear the modal content when the modal is closed
        $('#tableModalBody').empty();

        // Call the closeModal function
        closeModal();
    }
});

// Add event handling for the "Pobierz jako XML" button
$(document).on("click", "#printModalButton", function () {
    printTableModalContent();
});

// Function to print the modal content
function printTableModalContent() {
    var modalContent = '';
    // Get the modal title content
    modalContent += 'Modal Title: ' + $('#tableModalLabel').text().trim() + '\n';

    // Get the table content
    $('#tableModalBody tr').each(function (index, row) {
        $(row).find('td').each(function (index, cell) {
            modalContent += $(cell).text() + '\t';
        });
        modalContent += '\n';
    });

    // Log the modal content
    console.log(modalContent);

    // Add code here to create an XML file and initiate its download
    downloadTableAsXml(modalContent);
}

// Function to download the table as an XML file
function downloadTableAsXml(xmlContent) {
    var blob = new Blob([xmlContent], { type: "application/xml" });
    var link = document.createElement("a");

    // Set link attributes to make it clickable and download the file
    link.href = window.URL.createObjectURL(blob);
    link.download = "table_content.xml";

    // Add the link to the body and trigger a click event
    document.body.appendChild(link);
    link.click();

    // Remove the link from the body
    document.body.removeChild(link);
}
$(document).ready(function() {
    var table = $('#example').DataTable({
        searchPanes: true
    });
    table.searchPanes.container().prependTo(table.table().container());
    table.searchPanes.resizePanes();
});
// Variable to store the owner value from PHP session
var owner = "<?php echo isset($_SESSION['login']) ? $_SESSION['login'] : ''; ?>";


    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="index.js"></script>
</body>

</html>

