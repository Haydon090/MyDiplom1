document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('addMaterialBtn').addEventListener('click', function() {
        document.getElementById('materialMenu').style.display = 'block';
    });

    document.getElementById('materialType').addEventListener('change', function() {
        var materialType = this.value;
        var inputFieldsDiv = document.getElementById('inputFields');

        // Очищаем контейнер с полями ввода
        inputFieldsDiv.innerHTML = '';

        // Создаем и добавляем элементы для ввода в зависимости от выбранного типа материала
        if (materialType === 'text') {
            var textInput = document.createElement('textarea');
            textInput.className = 'form-control';
            textInput.name = 'content';
            textInput.placeholder = 'Enter text';
            inputFieldsDiv.appendChild(textInput);

            // Создаем поле для выбора шрифта
            var fontSelect = document.createElement('select');
            fontSelect.className = 'form-control mt-3';
            fontSelect.name = 'font';
            var fontOptions = ['Arial', 'Times New Roman', 'Verdana']; // Примеры шрифтов
            for (var i = 0; i < fontOptions.length; i++) {
                var option = document.createElement('option');
                option.value = fontOptions[i];
                option.text = fontOptions[i];
                fontSelect.appendChild(option);
            }
            inputFieldsDiv.appendChild(fontSelect);

            // Создаем поле для выбора размера текста
            var sizeInput = document.createElement('input');
            sizeInput.type = 'number';
            sizeInput.className = 'form-control mt-3';
            sizeInput.name = 'size';
            sizeInput.placeholder = 'Enter font size';
            inputFieldsDiv.appendChild(sizeInput);
        } else if (materialType === 'link' || materialType === 'video') {
            var urlInput = document.createElement('input');
            urlInput.type = 'url';
            urlInput.className = 'form-control';
            urlInput.name = 'url';
            urlInput.placeholder = 'Enter URL';
            inputFieldsDiv.appendChild(urlInput);
        } else if (materialType === 'image') {
            var fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.className = 'form-control-file';
            fileInput.name = 'image';
            inputFieldsDiv.appendChild(fileInput);
        }
    });

    document.getElementById('submitMaterialBtn').addEventListener('click', function() {
        // Здесь можно добавить логику для отправки данных на сервер
        // Например, с помощью AJAX-запроса
        var materialType = document.getElementById('materialType').value;
        var formData = new FormData();

        if (materialType === 'image') {
            var file = document.querySelector('input[type=file]').files[0];
            formData.append('image', file);
        } else {
            var inputField = document.querySelector('#inputFields input, #inputFields textarea');
            formData.append(materialType, inputField.value);
        }

        // Отправка данных на сервер
        // Например, с помощью fetch API или другого метода
    });
});
