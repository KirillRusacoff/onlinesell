const formCompany = document.querySelector('#form-company');

formCompany.addEventListener('submit', function(e){
    e.preventDefault();

    const formData = new FormData(this); // Используем FormData для отправки файлов

    $.ajax({
        url: 'php/company_data/company_data3.php',
        type: 'POST',
        data: formData,
        processData: false, // Не обрабатываем данные, как строку
        contentType: false, // Не устанавливаем content-type
        success: function(response) {
            console.log("Данные переданы успешно!");
            console.log("Ответ сервера:", response);

            window.location.href = './../../create3.html';
        },
        error: function(xhr, status, error) {
            console.log("Ошибка регистрации: " + xhr.responseText);
        }
    });
});
