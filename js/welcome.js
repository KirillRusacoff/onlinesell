const formCompany = document.querySelector('#form-company');

formCompany.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = $(this).serialize();

    $.ajax({
        url: 'php/company_data/company_data.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            // Если в PHP возвращается корректный JSON, то парсинг JSON больше не нужен
            // const jsonResponse = JSON.parse(response);
            console.log("Данные переданы успешно!");
            console.log("Ответ сервера:", response);
            
            // Выводим добавленные данные
            console.log("Добавленные данные:", response.data);

            window.location.href = './../create.html';
        },
        error: function(xhr, status, error) {
            console.log("Ошибка регистрации: " + xhr.responseText);
        }
    });
});
