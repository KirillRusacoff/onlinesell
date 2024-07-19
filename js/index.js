//фильтр блоков телефон и email
const radioEmail = document.querySelector('#email_radio');
const radioPhone = document.querySelector('#phone_radio');
const formEmail = document.querySelector('.form--email');
const formPhone = document.querySelector('.form--phone');
const formEmailInputs = formEmail.querySelectorAll('input');
const formPhoneInputs = formPhone.querySelectorAll('input');

function clearInputs(inputs) {
    inputs.forEach(input => {
        input.value = '';
    });
}

radioEmail.addEventListener('change', function(){
    formEmail.style = 'display:flex';
    formPhone.style = 'display:none';
    clearInputs(formPhoneInputs);
});

radioPhone.addEventListener('change', function(){
    formEmail.style = 'display:none';
    formPhone.style = 'display:flex';
    clearInputs(formEmailInputs);
});

//фильтр блоков регистрации и авторизации
const onReg = document.querySelector('#on-reg, #on-reg2');
const onAuth = document.querySelector('#on-auth, #on-auth2');
const formReg = document.querySelector('.forms--reg');
const formAuth = document.querySelector('.forms--auth');

onReg.addEventListener('click', function(){
    formReg.style = 'display:block';
    formAuth.style = 'display:none';
});

onAuth.addEventListener('click', function(){
    formReg.style = 'display:none';
    formAuth.style = 'display:block';
});

//отправка запроса на регистрацию
const formsReg = document.querySelectorAll('.forms--reg form');

formsReg.forEach(function(item){
    item.addEventListener('submit', function(e){
        e.preventDefault();

        const formData = $(this).serialize();

        
        $.ajax({
            url: 'php/registration_and_authorization/registration.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log("Регистрация прошла успешно!");

                window.location.href = './../verify.html';
            },
            error: function(xhr, status, error) {
                console.log("Ошибка регистрации: " + xhr.responseText);
            }
        });
    })
});

//отправка запроса на авторизацию
const formsAuth = document.querySelectorAll('.forms--auth form');

formsAuth.forEach(function(item){
    item.addEventListener('submit', function(e){
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: 'php/registration_and_authorization/authorization.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log("Авторизация прошла успешно!");

                window.location.href = './../welcome.html';
            },
            error: function(xhr, status, error) {
                console.log("Ошибка авторизации: " + xhr.responseText);
            }
        });
    })
});