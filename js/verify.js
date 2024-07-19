// отправка запроса на авторизацию
const formVerify = document.querySelector('.form--verify');

formVerify.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = $(this).serialize();

    $.ajax({
        url: 'php/registration_and_authorization/verify.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            // предполагая, что jQuery автоматически преобразует JSON-ответ в объект
            console.log(response.message);

            if (response.message === "Верификация прошла успешно!") {
                window.location.href = './../welcome.html';
            }
        },
        error: function(xhr, status, error) {
            console.log("Ошибка верификации: " + xhr.responseText);
        }
    });
});
