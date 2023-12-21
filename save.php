<?php

$modifiedHTML = $_POST["modifiedHTML"];
$fileName = $_POST['fileName'];
$formAction = $_POST['formAction'];

$htmlTemplate = '
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3y\'D65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
';

$formStyles = '
    <style>
        form {
            min-height: 75vh;
            width: 75vw;
            -webkit-box-shadow: -2px 0px 32px 12px rgba(70, 66, 60, 0.5);
            -moz-box-shadow: -2px 0px 32px 12px rgba(70, 66, 60, 0.5);
            box-shadow: -2px 0px 32px 12px rgba(70, 66, 60, 0.5);
            background-color: #e6e6e6;
            padding: 20px;
            border-radius: 10px;
        }
        
        label {
            color: #333;
        }
        
        input {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 8px;
            margin-bottom: 10px;
        }
        
        button {
            background-color: #66bb6a;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        
        @media only screen and (min-width: 1200px) {
            form {
                width: 60vw;
            }
        }
        
        @media only screen and (max-width: 600px) {
            form {
                width: 95vw;
            }
        }
    </style>
   <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
';

$htmlTemplateEnd = ' </div>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="index.js"></script>
   
<<<<<<< HEAD
      <script>
        // Assign the PHP value to a JavaScript variable
        const formActionValue = "send_email.php";

        function trackRangeValues() {
            var rangeInputs = document.querySelectorAll(\'input[type="range"]\');

            rangeInputs.forEach(function(range) {
                var label = document.getElementById(range.id).previousElementSibling;

                range.addEventListener("input", function() {
                    label.textContent = label.textContent.split(":")[0] + ": " + range.value;
                });

                label.textContent = label.textContent.split(":")[0] + ": " + range.value;
            });
        }

        function sendEmail(formData, formAction) {
            const emailRecipient = ' . json_encode($formAction) . '; // Set the recipient email address here

            let emailContent = "Form Data:\n";
            formData.forEach(function(value, key) {
                emailContent += `${key}: ${value}\n`;
            });

            const emailData = new FormData();
            emailData.append("recipient", emailRecipient);
            emailData.append("subject", "Form Submission");
            emailData.append("content", emailContent);

            fetch(formAction, {
                    method: "POST",
                    body: emailData,
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(data => {
                    console.log("Server response:", data);

                    // Parse JSON response
                    const responseData = JSON.parse(data);

                    // Display information to the user
                    alert(responseData.message);

                    // Access additional information
                    const recipient = responseData.recipient;
                    const subject = responseData.subject;
                    content = responseData.content;

                    // You can use or display this information as needed
                    console.log("Recipient:", recipient);
                    console.log("Subject:", subject);
                    console.log("Content:", content);
                })
                .catch((error) => {
                    console.error("Error sending email:", error.message);

                    // Handle errors, e.g., display an error message
                    alert(\'Error submitting form. Please try again.\');
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            trackRangeValues();

            document.querySelector("form").addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent the default form submission
                alert(\'Form submitted\');

                const formData = new FormData(document.getElementById("yourIdx")); // Assuming your form has an ID of "yourIdx"
                // Use the JavaScript variable here
                const formAction = formActionValue;
                sendEmail(formData, formAction);
            });
        });
    </script>
=======
    
    <script>
    // Assign the PHP values to JavaScript variables
    const formActionEmail = "send_email.php";
    const formActionNew = "new.php";

    function trackRangeValues() {
        var rangeInputs = document.querySelectorAll(\'input[type="range"]\');

        rangeInputs.forEach(function (range) {
            var label = document.getElementById(range.id).previousElementSibling;

            range.addEventListener("input", function () {
                label.textContent = label.textContent.split(":")[0] + ": " + range.value;
            });

            label.textContent = label.textContent.split(":")[0] + ": " + range.value;
        });
    }

    function sendEmail(formData) {
        const emailRecipient = ' . json_encode($formAction) . '; // Set the recipient email address here
        // Concatenate the URL
        const apiUrl = "https://css.createplus.pl/login.php";

let emailContent = "Twój Formularz: \n";
formData.forEach(function (value, key) {
    emailContent += `${key}: ${value}\n`;
});

// Add apiUrl to emailContent
emailContent += `\nAdres API: https://css.createplus.pl/login.php`;

        const emailData = new FormData();
        emailData.append("recipient", emailRecipient);
        emailData.append("subject", "Form Submission");
        emailData.append("content", emailContent);

        fetch(formActionEmail, {
            method: "POST",
            body: emailData,
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.text();
            })
            .then(data => {
                console.log("Server response:", data);
                // Parse JSON response
                const responseData = JSON.parse(data);
                // Display information to the user
                alert(responseData.message);
            })
            .catch((error) => {
                console.error("Error sending email:", error.message);
                // Handle errors, e.g., display an error message
            });
    }

    document.addEventListener("DOMContentLoaded", function () {
        trackRangeValues();

        document.querySelector("form").addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(document.getElementById("yourIdx")); // Assuming your form has an ID of "yourIdx"

            // Call the sendEmail function for send_email.php
            sendEmail(formData);

            // Simulate traditional form submission
            this.submit();
        });
    });
</script>

>>>>>>> 8b042ad (Commit message describing your changes)
    </body>
    </html>
';

$fullHTML = $htmlTemplate . $formStyles . $modifiedHTML . $htmlTemplateEnd;

if (file_put_contents($fileName, $fullHTML) !== false) {
    $fileLink =  $fileName;
    echo json_encode(['fileLink' => $fileLink]);
} else {
    echo json_encode(['error' => 'Nie udało się zapisać pliku.']);
}

?>
