document.querySelector('#sidebar-toggle');
const $button = document.querySelector('#sidebar-toggle');
const $wrapper = document.querySelector('#wrapper');

$button.addEventListener('click', (e) => {
    e.preventDefault();
    $wrapper.classList.toggle('toggled');
});

let draggingElement = null;
let idx;
let inputEmail;
// Funkcja do wyświetlania kodu w oknie dialogowym i kopiowania go do schowka

const element = document.querySelector('#yourIdx');


element.addEventListener('click', function(event) {
    showModals(element.getAttribute('data-element-type'), element.getAttribute('data-idx'));
});

// Funkcja do wyświetlania kodu w oknie dialogowym i kopiowania go do schowka
function showFormCode() {
    // Pobierz element formularza o określonym id
    const formElement = document.getElementById('yourIdx');

    if (!formElement) {
        alert('Nie znaleziono formularza o id "yourIdx" w kodzie.');
        return;
    }

    // Pobierz zawartość znacznika <form> razem z samym znacznikiem
    const formCode = formElement.outerHTML;

    // Usuń atrybuty "disabled" z kodu
    const cleanedFormCode = formCode.replace(/disabled/g, '');

    // Wyświetl kod w oknie dialogowym
    const formModal = document.createElement('div');
    formModal.classList.add('modal', 'fade');
    formModal.id = 'formModal';

    const modalDialog = document.createElement('div');
    modalDialog.classList.add('modal-dialog', 'modal-lg');
    formModal.appendChild(modalDialog);

    const modalContent = document.createElement('div');
    modalContent.classList.add('modal-content');
    modalDialog.appendChild(modalContent);

    const modalBody = document.createElement('div');
    modalBody.classList.add('modal-body');
    modalContent.appendChild(modalBody);

    // Utwórz element <pre>, aby wyświetlić kod
    const codePre = document.createElement('pre');
    codePre.textContent = cleanedFormCode;
    modalBody.appendChild(codePre);

    // Utwórz przycisk "Kopiuj kod"
    const copyButton = document.createElement('button');
    copyButton.textContent = 'Kopiuj kod';
    copyButton.classList.add('btn', 'btn-primary', 'mb-2');
    copyButton.addEventListener('click', function() {
        // Kopiuj kod do schowka
        const codeText = codePre.textContent;
        const dummyTextarea = document.createElement('textarea');
        dummyTextarea.value = codeText;
        document.body.appendChild(dummyTextarea);
        dummyTextarea.select();
        document.execCommand('copy');
        document.body.removeChild(dummyTextarea);
        alert('Kod został skopiowany do schowka.');
    });

    modalBody.appendChild(copyButton);

    document.body.appendChild(formModal);

    // Otwórz okno dialogowe
    const formModalInstance = new bootstrap.Modal(formModal);
    formModalInstance.show();
}

function createFormElement(elementType) {
    const parentContainer = document.getElementById('yourIdx');

    if (!parentContainer) {
        alert('Nie znaleziono kontenera formularza.');
        return;
    }

    const childElementId = generateUniqueId();
    const divContainer = document.createElement('div');
    divContainer.className = 'row justify-content-center align-items-center m-1';
    divContainer.style.cursor = 'grab'; // Zmień kursor na "grab" dla przeciągania

    divContainer.id = childElementId;
    divContainer.setAttribute('draggable', true); // Ustaw element jako przeciągalny

    divContainer.addEventListener('dragstart', (e) => {
        e.dataTransfer.setData('text/plain', childElementId);
        draggingElement = divContainer; // Ustaw przeciągający element
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
        const inputText = document.createElement('input');
        inputText.type = 'text';
        inputText.className = 'form-control mb-1';
        inputText.placeholder = 'Input Text';
        inputText.disabled = true;
        inputText.style.pointerEvents = 'none';
        inputText.id = childElementId + 1;

        divContainer.appendChild(inputText);
    } else if (elementType === 'Select') {
        const select = document.createElement('select');
        select.className = 'form-select mb-1';
        select.disabled = true;
        select.style.pointerEvents = 'none';
        select.id = childElementId + 1;
        divContainer.appendChild(select);
    } else if (elementType === 'Button') {
        const button = document.createElement('button');
        button.textContent = 'Button';
        button.className = 'btn btn-primary col-12 mb-1';
        button.type = 'submit';
        button.style.pointerEvents = 'none';
        button.id = childElementId + 1;
        divContainer.appendChild(button);
    } else {
        alert('Nieobsługiwany typ elementu.');
        return;
    }

    parentContainer.appendChild(divContainer);
}



function showModals(elementType, idx) {



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
        if (elementType === 'Select') {
            const options = targetElement.getElementsByTagName('option');

            for (let i = 0; i < options.length; i++) {
                const inputSelectOptionText = document.createElement('input');
                inputSelectOptionText.type = 'text';
                inputSelectOptionText.className = 'form-control mb-3';
                inputSelectOptionText.placeholder = 'Option Text';
                inputSelectOptionText.value = options[i].textContent;
                modalBody.appendChild(inputSelectOptionText);

                const inputSelectOptionValue = document.createElement('input');
                inputSelectOptionValue.type = 'text';
                inputSelectOptionValue.className = 'form-control mb-3';
                inputSelectOptionValue.placeholder = 'Option Value';
                inputSelectOptionValue.value = options[i].value;
                modalBody.appendChild(inputSelectOptionValue);
            }

            const addOptionButton = document.createElement('button');
            addOptionButton.type = 'button';
            addOptionButton.className = 'btn btn-primary mx-2';
            addOptionButton.textContent = 'Add Option';
            modalBody.appendChild(addOptionButton);

            addOptionButton.addEventListener('click', () => {
                const newOption = document.createElement('option');
                newOption.text = 'Nowa opcja';
                newOption.value = 'nowa_wartosc';
                targetElement.add(newOption);
                showModals(elementType, idx);
            });
        } else if (elementType === 'Input Text') {
            const inputFieldType = document.createElement('select');
            inputFieldType.className = 'form-select mb-3';
            modalBody.appendChild(inputFieldType);

            // Dodaj opcje atrybutów pola input
            const inputFieldOptions = ['text', 'password', 'number', 'date'];

            inputFieldOptions.forEach((option) => {
                const optionElement = document.createElement('option');
                optionElement.value = option;
                optionElement.textContent = option;
                inputFieldType.appendChild(optionElement);
            });

            const inputFieldName = document.createElement('input');
            inputFieldName.type = 'text';
            inputFieldName.className = 'form-control mb-3';
            inputFieldName.placeholder = 'Field Name';
            modalBody.appendChild(inputFieldName);

            const inputFieldValue = document.createElement('input');
            inputFieldValue.type = 'text';
            inputFieldValue.className = 'form-control mb-3';
            inputFieldValue.placeholder = 'Field Value';
            modalBody.appendChild(inputFieldValue);

            const inputFieldPlaceholder = document.createElement('input');
            inputFieldPlaceholder.type = 'text';
            inputFieldPlaceholder.className = 'form-control mb-3';
            inputFieldPlaceholder.placeholder = 'Placeholder';
            modalBody.appendChild(inputFieldPlaceholder);
        } else if (elementType === 'Button') {

            const inputButtonText = document.createElement('input');
            inputButtonText.type = 'text';
            inputButtonText.className = 'form-control mb-3';
            inputButtonText.placeholder = 'Button Text';
            inputButtonText.value = targetElement.textContent; // Set the value to the current button text
            modalBody.appendChild(inputButtonText);
        } else if (elementType === 'FORM') {
            // Dodaj pole do wprowadzenia adresu e-mail
            const inputEmail = document.createElement('input');
            inputEmail.type = 'email';
            inputEmail.className = 'form-control mb-3';
            inputEmail.placeholder = 'Adres e-mail';
            inputEmail.value = targetElement.getAttribute('action'); // Set the value to the current action attribute
            modalBody.appendChild(inputEmail);
        }
        const updateButton = document.createElement('button');
        updateButton.type = 'button';
        updateButton.className = 'btn btn-primary mx-2';
        updateButton.textContent = 'Update';
        modalBody.appendChild(updateButton);

        const cancelButton = document.createElement('button');
        cancelButton.type = 'button';
        cancelButton.className = 'btn btn-secondary mx-2';
        cancelButton.textContent = 'Cancel';
        modalBody.appendChild(cancelButton);

        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.className = 'btn btn-danger mx-2';
        deleteButton.textContent = 'Delete';
        modalBody.appendChild(deleteButton);

        cancelButton.addEventListener('click', () => {
            modalInstance.hide();
        });

        deleteButton.addEventListener('click', () => {
            targetElement.remove();
            modalInstance.hide();
        });

        if (elementType === 'FORM') {
            deleteButton.remove();
        }

        updateButton.addEventListener('click', () => {
            if (targetElement.tagName === 'SELECT') {
                const options = targetElement.getElementsByTagName('option');
                while (options.length > 0) {
                    targetElement.remove(0);
                }
                const selectOptions = modalBody.querySelectorAll('.modal-body .form-control');
                for (let i = 0; i < selectOptions.length; i += 2) {
                    const optionText = selectOptions[i].value;
                    const optionValue = selectOptions[i + 1].value;
                    const newOption = document.createElement('option');
                    newOption.text = optionText;
                    newOption.value = optionValue;
                    targetElement.add(newOption);
                }
                modalInstance.hide();
            } else if (targetElement.tagName === 'Button') {
                inputButtonText = modalBody.querySelector('input[placeholder="Button Text"]');
                targetElement.textContent = inputButtonText.value;
                modalInstance.hide();
            } else if (targetElement.tagName === 'INPUT') {
                const inputFieldType = modalBody.querySelector('select');
                const inputFieldName = modalBody.querySelector('input[placeholder="Field Name"]');
                const inputFieldValue = modalBody.querySelector('input[placeholder="Field Value"]');
                const inputFieldPlaceholder = modalBody.querySelector('input[placeholder="Placeholder"]');

                targetElement.type = inputFieldType.value;
                targetElement.name = inputFieldName.value;
                targetElement.value = inputFieldValue.value;
                targetElement.placeholder = inputFieldPlaceholder.value;
                modalInstance.hide();
            } else if (targetElement.tagName === 'FORM') {
                const inputEmail = modalBody.querySelector('input[placeholder="Adres e-mail"]');
                const adres = inputEmail.value;
                targetElement.setAttribute('method', 'POST');
                targetElement.setAttribute('action', adres);
                modalInstance.hide();
            }

            modalInstance.hide();
        });

        // Otwórz modal
        const body = document.querySelector('body');
        body.appendChild(modal);
        const modalElement = document.getElementById(modalId);
        const modalInstance = new bootstrap.Modal(modalElement);
        modalInstance.show();
    }
}



function generateUniqueId() {
    return 'element-' + Math.random().toString(36).substr(2, 9);
}

function getElementType(text) {
    if (text.includes("Input Text")) {
        return 'Input Text';
    } else if (text.includes("Select")) {
        return 'Select';
    } else if (text.includes("Radio")) {
        return 'Radio';
    } else if (text.includes("Button")) {
        return 'Button';
    } else if (text.includes("Range")) {
        return 'Range';
    }
    return 'unknown';
}