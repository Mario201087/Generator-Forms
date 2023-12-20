document.body.style.opacity = 1;
// Ensure the DOM is fully loaded before manipulating it
let booleanutton = true;
// Przycisk do ukrywania i pokazywania sidebar
const $button = document.querySelector('#sidebar-toggle');
const $wrapper = document.querySelector('#wrapper');
let i = 1;
$button.addEventListener('click', (e) => {
    e.preventDefault();
    $wrapper.classList.toggle('toggled');
});

let draggingElement = null;

const element = document.getElementById('yourIdx');

element.addEventListener('click', function(event) {
    showModals(element.getAttribute('data-element-type'), element.getAttribute('data-idx'));
});

// Pobieramy zawartość HTML formularza


function createFormElement(elementType) {
    const parentContainer = document.getElementById('yourIdx');

    if (!parentContainer) {
        alert('Nie znaleziono kontenera formularza.');
        return;
    }

    const childElementId = generateUniqueId();
    const divContainer = document.createElement('div');
    divContainer.className = 'form-control';
    divContainer.style.cursor = 'grab';

    divContainer.id = childElementId;
    divContainer.setAttribute('draggable', true);

    divContainer.addEventListener('dragstart', (e) => {
        e.dataTransfer.setData('text/plain', childElementId);
        draggingElement = divContainer;
    });

    divContainer.addEventListener('dragover', (e) => {
        e.preventDefault();
    });

    divContainer.addEventListener('drop', (e) => {
        e.preventDefault();

        if (draggingElement && divContainer !== draggingElement) {
            const parent = parentContainer;

            const index1 = Array.from(parent.children).indexOf(draggingElement);
            const index2 = Array.from(parent.children).indexOf(divContainer);

            if (index1 < index2) {
                parent.insertBefore(draggingElement, divContainer.nextSibling);
            } else {
                parent.insertBefore(draggingElement, divContainer);
            }
        }
    });

    divContainer.addEventListener('dragend', () => {
        draggingElement = null;
    });

    divContainer.addEventListener('click', function(event) {
        event.stopPropagation();
    });

    divContainer.addEventListener('click', () => showModals(elementType, childElementId + 1));

    if (elementType === 'Input Text') {
        const newLabel = document.createElement('label');
        newLabel.value = i + 'NewOption';
        newLabel.textContent = i + 'NewOption';
        newLabel.id = childElementId + 12;
        divContainer.appendChild(newLabel);
        const inputText = document.createElement('input');
        inputText.type = 'text';
        inputText.name = i + 'NewOption';
        inputText.className = 'form-control mb-1';
        inputText.placeholder = 'Input Text';
        inputText.disabled = true;
        inputText.style.pointerEvents = 'none';
        inputText.id = childElementId + 1;
        i++;
        divContainer.appendChild(inputText);

        setTimeout(() => {
            showModals(elementType, childElementId + 1);
        }, 100);
    } else if (elementType === 'Select') {
        const newLabel1 = document.createElement('label');
        newLabel1.value = i + 'NewOption';
        newLabel1.textContent = i + 'NewOption';
        newLabel1.id = childElementId + 12;
        divContainer.appendChild(newLabel1);

        const select = document.createElement('select');
        select.className = 'form-select mb-1';
        select.disabled = true;
        select.name = i + 'NewOption';
        select.style.pointerEvents = 'none';
        select.id = childElementId + 1;
        divContainer.appendChild(select);
        i++;
        setTimeout(() => {
            showModals(elementType, childElementId + 1);
        }, 100);
    } else if (elementType === 'Button') {
        // Check if there is no button in the divContainer
        if (booleanutton === true) {
            const button = document.createElement('button');
            button.textContent = 'Button';
            button.className = 'btn btn-secondary col-12 mb-1';
            button.type = 'submit';
            button.style.pointerEvents = 'none';
            button.id = childElementId + 1;
            divContainer.appendChild(button);
            booleanutton = false;
        } else {
            // Alert the user or handle the case where a button already exists
            alert('Button already exists in the divContainer.');
        }
    } else {
        alert('Nieobsługiwany typ elementu.');
        return;
    }

    parentContainer.appendChild(divContainer);
}

function showModals(elementType, idx) {
    let modalInstance;

    function createInputElement(type, placeholder) {
        const input = document.createElement('input');
        input.type = type;
        input.setAttribute('data-dirty', 'false');
        input.className = 'form-control mb-2';
        input.placeholder = placeholder;
        return input;
    }

    function createSelectElement(placeholder, selectedValue) {
        const select = document.createElement('select');
        select.className = 'form-select mb-2';
        select.placeholder = placeholder;

        const options = [
            'text', 'password', 'number', 'email', 'url', 'date',
            'file', 'color', 'range', 'hidden', 'tel'
        ];

        for (let i = 0; i < options.length; i++) {
            const option = document.createElement('option');
            option.value = options[i]; // Set option value
            option.text = options[i].charAt(0).toUpperCase() + options[i].slice(1);
            select.appendChild(option);
        }

        select.value = selectedValue;

        return select;
    }

    function createUpdateButton() {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'btn btn-secondary';
        button.textContent = 'Update';
        return button;
    }

    const targetElement = document.getElementById(idx);

    if (targetElement) {
        const modalId = elementType + '-modal-' + idx;
        const existingModal = document.getElementById(modalId);

        if (existingModal) {
            existingModal.remove();
        }

        const modal = document.createElement('div');
        modal.classList.add('modal', 'fade');
        modal.id = modalId;

        const modalDialog = document.createElement('div');
        modalDialog.classList.add('modal-dialog', 'modal-dialog-centered');
        modal.appendChild(modalDialog);

        const modalContent = document.createElement('div');
        modalContent.classList.add('modal-content');
        modalDialog.appendChild(modalContent);

        const modalBody = document.createElement('div');
        modalBody.classList.add('modal-body');
        modalContent.appendChild(modalBody);

        if (elementType === 'Input Text') {
            const inputLabel = createInputElement('text', 'Input Text');
            inputLabel.placeholder = 'Add questions to your field';

            inputLabel.focus();
            inputLabel.setAttribute('data-dirty', 'false');

            const inputText = createInputElement('text', 'Input Text');
            inputText.focus();

            const typeSelect = createSelectElement('Type', targetElement.type);

            const saveButton = createUpdateButton();
            const idx2 = idx + 2;
            const idx3 = idx + 3;
            const siblingElement = document.getElementById(idx2);

            inputText.addEventListener('input', function() {
                inputText.setAttribute('data-dirty', 'true');
            });

            inputLabel.addEventListener('input', function() {
                inputLabel.setAttribute('data-dirty', 'true');
            });

            if (siblingElement) {
                modalBody.appendChild(inputLabel);
                modalBody.appendChild(inputText);
                modalBody.appendChild(typeSelect);
                modalBody.appendChild(saveButton);

                saveButton.addEventListener('click', function() {
                    if (inputText.getAttribute('data-dirty') === 'true') {
                        targetElement.placeholder = inputText.value;
                    }

                    targetElement.type = typeSelect.value;

                    if (targetElement.type === 'range') {
                        const divCont = document.getElementById(idx2);

                        if (divCont) {
                            var x = document.createElement("output");
                            x.id = idx3;
                            divCont.appendChild(x);
                        } else {
                            console.error('Div container not found for range input.');
                        }
                    }

                    if (inputLabel.value.trim() !== '') {
                        targetElement.name = inputLabel.value;
                    }

                    if (siblingElement.tagName === 'LABEL') {
                        if (inputLabel.getAttribute('data-dirty') === 'true') {
                            siblingElement.textContent = inputLabel.value;
                        }
                    }

                    modalInstance.hide();
                    document.body.style.opacity = 1;
                });
            } else {
                alert('Nie znaleziono odpowiedniego brata.');
            }
        } else if (elementType === 'Select') {
            const inputLabel1 = createInputElement('text', 'Input Text');
            inputLabel1.placeholder = 'Add description to your file';
            inputLabel1.setAttribute('data-dirty', 'false');

            const updateOptionsButton = document.createElement('button');
            updateOptionsButton.type = 'button';
            updateOptionsButton.className = 'btn btn-secondary col-3';
            updateOptionsButton.textContent = 'Update';

            const idx2 = idx + 2;
            const siblingElement = document.getElementById(idx2);

            inputLabel1.addEventListener('input', function() {
                inputLabel1.setAttribute('data-dirty', 'true');
            });

            modalBody.appendChild(inputLabel1);
            modalBody.appendChild(updateOptionsButton);

            updateOptionsButton.addEventListener('click', function() {
                const selectOptions = targetElement.querySelectorAll('option');
                const optionInputGroups = modalBody.querySelectorAll('.xx');

                for (let i = 0; i < selectOptions.length; i++) {
                    const optionTextInput = optionInputGroups[i].querySelector('input[placeholder="Text"]');

                    if (optionTextInput) {
                        const newOptionValue = optionTextInput.value;
                        selectOptions[i].value = newOptionValue;
                        selectOptions[i].textContent = newOptionValue;
                    }
                }

                if (inputLabel1.getAttribute('data-dirty') === 'true') {
                    targetElement.name = inputLabel1.value;

                    if (siblingElement.tagName === 'LABEL') {
                        siblingElement.textContent = inputLabel1.value;
                    }
                }

                modalInstance.hide();
            });


            // Dodaj pole input do wprowadzenia liczby pól
            const addOptionInput = createInputElement('text', 'Input Text');
            addOptionInput.placeholder = 'Enter number of fields';
            addOptionInput.className = 'form-control col-9';

            const addOptionButton = document.createElement('button');
            addOptionButton.type = 'button';
            addOptionButton.className = 'btn btn-secondary col-3';
            addOptionButton.textContent = 'Add Option';

            const inputGroupContainer = document.createElement('div');
            inputGroupContainer.className = 'input-group row m-1 col-12';
            inputGroupContainer.appendChild(addOptionInput);
            inputGroupContainer.appendChild(addOptionButton);

            modalBody.appendChild(inputGroupContainer);

            addOptionButton.addEventListener('click', function() {
                const numberOfFields = parseInt(addOptionInput.value) || 1;

                // Remove existing options
                while (targetElement.options.length > 0) {
                    targetElement.remove(0);
                }

                // Add new options
                for (let j = 0; j < numberOfFields; j++) {
                    const option = document.createElement('option');
                    const newOptionValue = ''; // Add your logic to get the value from your input
                    option.value = newOptionValue;
                    option.textContent = newOptionValue;
                    targetElement.appendChild(option);
                }

                modalInstance.hide();
                showModals(elementType, idx);
            });

            addOptionInput.addEventListener('input', function() {
                // Przekazuj aktualną wartość pola input jako parametr do funkcji obsługującej zdarzenie przycisku
                addOptionButton.nr = addOptionInput.value;
            });

            // ... (your existing code)


            const selectOptions = targetElement.querySelectorAll('option');

            for (let i = 0; i < selectOptions.length; i++) {
                const optionInputGroup = document.createElement('div');
                optionInputGroup.className = 'xx input-group m-1 col-12';


                const optionTextInput = createInputElement('text', 'Text');

                optionTextInput.value = selectOptions[i].textContent;

                optionInputGroup.appendChild(optionTextInput);

                const removeOptionButton = document.createElement('button');
                removeOptionButton.type = 'button';
                removeOptionButton.className = 'btn btn-secondary col-3';
                removeOptionButton.textContent = 'Remove';

                optionInputGroup.appendChild(removeOptionButton);

                modalBody.appendChild(optionInputGroup);

                removeOptionButton.addEventListener('click', function() {
                    targetElement.removeChild(selectOptions[i]);
                    optionInputGroup.remove();
                });
            }
        } else if (elementType === 'Button') {
            const buttonText = document.createElement('input');
            buttonText.type = 'text';
            buttonText.className = 'form-control mb-2';
            buttonText.value = targetElement.textContent;
            modalBody.appendChild(buttonText);

            const saveButton = document.createElement('button');
            saveButton.type = 'button';
            saveButton.className = 'btn btn-secondary';
            saveButton.textContent = 'Save';

            modalBody.appendChild(saveButton);

            saveButton.addEventListener('click', function() {
                targetElement.textContent = buttonText.value;
                modalInstance.hide();
                document.body.style.opacity = 1;
            });
        }

        if (elementType === 'FORM') {
            return;
        }

        const cancelButton = createUpdateButton();
        cancelButton.textContent = 'Cancel';
        modalBody.appendChild(cancelButton);

        $('#' + modalId).on('hide.bs.modal', function(event) {
            const inputTextValue = document.querySelector('#' + modalId + ' input').value;

            if (elementType === 'Select') {
                const optionValueInputs = modalBody.querySelectorAll('input[placeholder="Value"]');
                for (const optionValueInput of optionValueInputs) {
                    if (optionValueInput.value.trim() === '') {
                        event.preventDefault();
                        alert('Pole input nie może być puste!');
                        return;
                    }
                }
            } else if (inputTextValue.trim() === '') {
                event.preventDefault();
                alert('Pole input nie może być puste!');
            }
        });

        cancelButton.addEventListener('click', function() {
            modalInstance.hide();
            document.body.style.opacity = 1;
        });

        const deleteButton = createUpdateButton();
        deleteButton.textContent = 'Delete';
        modalBody.appendChild(deleteButton);

        deleteButton.addEventListener('click', function() {
            targetElement.remove();

            const idx2 = idx + 2;
            const sibling = document.getElementById(idx2);

            if (sibling) {
                sibling.remove();
            }

            modalInstance.hide();
            document.body.style.opacity = 1;
        });

        const body = document.querySelector('body');
        body.appendChild(modal);
        const modalElement = document.getElementById(modalId);
        modalInstance = new bootstrap.Modal(modalElement);
        modalInstance.show();
    }
}





function removeFormControlDivsAndStylesFromFormHTML() {
    createFormHeader();
    const formHTML = document.querySelector('form').outerHTML;
    const parser = new DOMParser();
    const doc = parser.parseFromString(formHTML, 'text/html');

    const divsToRemove = doc.querySelectorAll('div.form-control');
    for (const div of divsToRemove) {
        const parent = div.parentNode;
        const elements = div.querySelectorAll('*');
        for (const element of elements) {
            if (element.hasAttribute('style')) {
                const styleValue = element.getAttribute('style');
                if (styleValue.includes('pointer-events: none;')) {
                    element.removeAttribute('style');
                }
            }
            if (element.hasAttribute('disabled')) {
                element.removeAttribute('disabled');
            }
        }
        while (div.firstChild) {
            parent.insertBefore(div.firstChild, div);
        }
        parent.removeChild(div);
    }

    const formAction = document.getElementById('formAction').value; // Set the appropriate formAction value
    let modifiedHTML = doc.querySelector('form').outerHTML;
    sendModifiedHTMLToServer(modifiedHTML, formAction); // Corrected: Call to sendModifiedHTMLToServer with the appropriate data
}



function createFormHeader() {
    const formName = document.getElementById('formName').value;
    const form = document.querySelector('form');

    const existingHeaders = form.querySelectorAll('h2');
    for (const header of existingHeaders) {
        header.remove();
    }

    if (formName) {
        const formHeader = document.createElement('h2');
        formHeader.textContent = formName;
        formHeader.style.textAlign = 'center';
        form.setAttribute("action", "new.php"); // Ustaw atrybut 'action' formularza na "mailto:"
        form.insertBefore(formHeader, form.firstChild);
    }
}

function sendModifiedHTMLToServer(modifiedHTML, formAction) {
    if (modifiedHTML) {
        const formData = new FormData();
        formData.append('modifiedHTML', modifiedHTML);
        formData.append('formAction', formAction);

        // Include timestamp in the fileName
        const timestamp = Date.now();
        const fileName = `${owner}${timestamp}.html`;

        formData.append('fileName', fileName);

        fetch('save.php', {
                method: 'POST',
                body: formData,
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json(); // Try to parse the response as JSON
            })
            .then((data) => {
                // Check if 'fileLink' exists in the response
                const fileLink = data && data.fileLink;

                if (fileLink) {
                    // Display download link in a modal
                    displayDownloadModal(fileLink);

                    // Pass fileLink to createTableInDatabase function
                    createTableInDatabase(modifiedHTML, fileLink);
                } else {
                    console.error('Invalid response from the server:', data);
                }
            })
            .catch((error) => {
                console.error('Error:', error.message);
            });

    }
}

function displayDownloadModal(fileLink) {
    // Display a modal with a download link
    // This function is called after successfully saving the file
    // You can customize this modal as needed
    const newModal = document.createElement('div');
    newModal.classList.add('modal', 'fade');
    newModal.id = 'dynamicModal';

    newModal.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pobierz zmodyfikowany formularz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <a href="${fileLink}" target="_blank">${fileLink}</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>`;

    document.body.appendChild(newModal);
    const dynamicModal = new bootstrap.Modal(newModal);
    dynamicModal.show();
}

function createTableInDatabase(modifiedHTML, fileLink) {
    // Retrieve the session variable in JavaScript

    const form = document.createElement('div');
    form.innerHTML = modifiedHTML;
    const formNameElement = form.querySelector('h2');

    if (!formNameElement) {
        console.error('No h2 element found in the form');
        return;
    }

    const formName = formNameElement.innerText.trim();

    // Initialize columns with default columns (id and owner)
    const columns = [
        'id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
        `Name VARCHAR(255) NOT NULL DEFAULT "${formName}"`
    ];

    // Dynamically add columns based on extracted texts
    const labelColumns = extractLabelColumns(modifiedHTML);
    columns.push(...labelColumns);

    // Create SQL statement for table creation
    const sql = `CREATE TABLE \`${fileLink}\` (${columns.join(', ')})`;

    // Send the SQL statement to the server for table creation
    fetch('create.php', {
            method: 'POST',
            body: JSON.stringify({
                sql: sql,
            }),
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(handleResponse)
        .then((data) => {
            if (data.success) {
                console.log('Table created successfully');
            } else {
                console.error('Error creating table:', data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error.message);
        });
}

function extractLabelColumns(modifiedHTML) {
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = modifiedHTML;

    // Find all label elements and extract their text
    const labelElements = tempDiv.querySelectorAll('label');
    const labelsTextArray = Array.from(labelElements).map(label => label.innerText.trim());

    // Initialize an array to store column names
    const columns = [];

    labelsTextArray.forEach((text) => {
        const column_name = text.replace(/[^a-zA-Z0-9_]/g, '_');

        let unique_column_name = `${column_name}`;

        if (unique_column_name.trim() !== '') {
            columns.push(`${unique_column_name} VARCHAR(255)`);

            // Check if the column name already exists with an underscore at the end
            const column_name_with_underscore = `${column_name}_`;
            if (!columns.includes(`${column_name_with_underscore} VARCHAR(255)`)) {
                columns.push(`${column_name_with_underscore} VARCHAR(255)`);
            }
        }
    });

    return columns;
}

function handleResponse(response) {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.json();
}


// Example function to extract texts from HTML (customize based on your actual HTML structure)
function extractTextsFromHTML(html) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    const textElements = doc.body.querySelectorAll('label'); // Assuming you want to extract text from label elements
    return Array.from(textElements).map((element) => element.innerText.trim());
}







const openModalButton = document.getElementById('configureForm');

openModalButton.addEventListener('click', () => {
    configureModal.show();
});

const saveFormConfig = document.getElementById('saveFormConfig');
saveFormConfig.addEventListener('click', () => {
    removeFormControlDivsAndStylesFromFormHTML();
    configureModal.hide();
});
const configureModal = new bootstrap.Modal(document.getElementById('configureModal'));




function generateUniqueId() {
    return 'element-' + Math.random().toString(36).substr(2, 9);
}

function getElementType(element) {
    const text = element.textContent;

    if (text.includes('Input Text')) {
        return 'Input Text';
    } else if (text.includes('Select')) {
        return 'Select';
    } else if (text.includes('Radio')) {
        return 'Radio';
    } else if (text.includes('Button')) {
        return 'Button';
    } else if (text.includes('Range')) {
        return 'Range';
    }
    return 'unknown';
}