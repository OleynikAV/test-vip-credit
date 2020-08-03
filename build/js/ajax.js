$( document ).ready(function() {
    $("#btn").click(
        function(){
            $('#btn').attr('disabled' , true);
            sendAjaxForm('result_form', 'ajax_form', '././mail/mail.php');
            return false;
        }
    );
});

function sendAjaxForm(result_form, ajax_form, url) {
    var formData = new FormData($(".bottom__form")[0]);
    $.ajax({
        url:     url, //url страницы (mail.php)
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) { //Данные отправлены успешно
            if (response == 'bigsize'){
                alert('Большой размер файла, не больше 5 мб');
            }else if(response == "wrongtype"){
                alert('Неподходящий тип файла');
            }else{
                result = $.parseJSON(response);
                // $('#result_form').html('ФИО: '+result.name+'<br>Емеил: '+result.email + '<br>Сообщение:'+result.text);
                $('.bg_form-succes_email').addClass('bg_form_email_on');
                $('.form-succes_email').addClass('form-succes_email_on');
                $(".bottom__form").trigger("reset");
                setTimeout(function () {
                    $('.bg_form-succes_email').removeClass('bg_form_email_on');
                    $('.form-succes_email').removeClass('form-succes_email_on');
                    $('#btn').removeAttr('disabled');
                },3000);
                $(".bottom__input-descr").text("Добавить файл(ы)");

            }



        },

        error: function(response) { // Данные не отправлены
            // alert('Ошибка. Данные не отправлены.');
            $('#result_form').html('0gfsdgdfgsdg');
            $('#btn').removeAttr('disabled');
        }
    });
}
$('#email-form-close').click(function () {
    if (this){
        $('.form-succes_email,.bg_form-succes_email').addClass('offf');
    }
});