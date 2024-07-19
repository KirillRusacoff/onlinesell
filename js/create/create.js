const formCompany = document.querySelector('#bot-token');

formCompany.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = $(this).serialize();

    $.ajax({
        url: 'php/company_data/company_data2.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            console.log("Данные переданы успешно!");
            console.log("Ответ сервера:", response);
            
            // Переход на следующую страницу
            window.location.href = './../create2.html';
        },
        error: function(xhr, status, error) {
            console.log("Ошибка регистрации: " + xhr.responseText);
        }
    });
});
