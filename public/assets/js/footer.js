$(document).ready(function () {

    $("#sendMail").click(function (e) {
        e.preventDefault();

        var name = document.getElementById('name').value;
        var email = document.getElementById('emails').value;
        var subject = document.getElementById('subject').value;
        var message = document.getElementById('message').value;
        var captcha = document.getElementById('recaptcha_v2').value;

        if(name.length < 1){
            $('#name').after('<span class="error">This field is required</span>');
            return false;
        }
        if(email.length < 1){
            $('#emails').after('<span class="error">This field is required</span>');
            return false;
        } 
        if(subject.length < 1){
            $('#subject').after('<span class="error">This field is required</span>');
            return false;
        }
        if(message.length < 1){
            $('#message').after('<span class="error">This field is required</span>');
            return false;
        }
        if(captcha.length < 1){
            $('#recaptcha_v2').after('<span class="error">please check captcha</span>');
            $('#recaptcha_v2').focus();
            return false;
        }

        var formData = new FormData(document.getElementById('formInbox'));
        $.ajax({
            url: $('#formInbox').attr('action'),
            type: "post",
            data: formData,
            processData: !1,
            contentType: !1,
            cache: !1,
            dataType: "JSON",
            timeout:5000,
            beforeSend: function () {
                // disableButton()	
                haltButton(true,'sendMail','status');
            },
            complete: function () {
                haltButton(false,'sendMail','status');
                // enableButton()
            },
            success: function (e) {
                // console.log(e);
                Swal.fire(
                    'Thank you',
                    'We will inform you ASAP',
                    'success'
                )
                document.getElementById('formInbox').reset();
                document.getElementsByClassName('error').remove;
                // validate(e.validate.input),e.validate.success&&("ok"==e.status?(toastSuccess(e.message),refreshData(),1==e.modalClose&&$("#modalForm").modal("hide"),clearInput(e.validate.input),socket.emit?.("affectDataTable", tableId)):toastWarning(e.message));
            },
            error: function (err) {
                Swal.fire(
                    'Oops',
                    'Someting Problem',
                    'failed'
                )
                // errorCode(err)
            }
        })
    })

    $("#sendMail2").click(function (e) {
        e.preventDefault();

        var name = document.getElementById('name').value;
        var email = document.getElementById('emails').value;
        var subject = document.getElementById('subject').value;
        var message = document.getElementById('message').value;
        var captcha = document.getElementById('recaptcha_v2').value;

        if(name.length < 1){
            $('#name').after('<span class="error">This field is required</span>');
            return false;
        }
        if(email.length < 1){
            $('#emails').after('<span class="error">This field is required</span>');
            return false;
        } 
        if(subject.length < 1){
            $('#subject').after('<span class="error">This field is required</span>');
            return false;
        }
        if(message.length < 1){
            $('#message').after('<span class="error">This field is required</span>');
            return false;
        }
        if(captcha.length < 1){
            $('#recaptcha_v2').after('<span class="error">please check captcha</span>');
            $('#recaptcha_v2').focus();
            return false;
        }

        var formData = new FormData(document.getElementById('formInbox2'));

        $.ajax({
            url: $('#formInbox').attr('action'),
            type: "post",
            data: formData,
            processData: !1,
            contentType: !1,
            cache: !1,
            dataType: "JSON",
            timeout:5000,
            beforeSend: function () {
                // disableButton()	
                haltButton(true,'sendMail','status');
            },
            complete: function () {
                haltButton(false,'sendMail','status');
                // enableButton()
            },
            success: function (e) {
                // console.log(e);
                Swal.fire(
                    'Thank you',
                    'We will inform you ASAP',
                    'success'
                )
                document.getElementById('formInbox2').reset();
                document.getElementsByClassName('error').remove;
                // validate(e.validate.input),e.validate.success&&("ok"==e.status?(toastSuccess(e.message),refreshData(),1==e.modalClose&&$("#modalForm").modal("hide"),clearInput(e.validate.input),socket.emit?.("affectDataTable", tableId)):toastWarning(e.message));
            },
            error: function (err) {
                Swal.fire(
                    'Oops',
                    'Someting Problem',
                    'failed'
                )
                // errorCode(err)
            }
        })
    })
})

async function haltButton(slug = false, id = null, chilid = null) {
    if(slug == true){
        // $(`#${id}`).prop('disabled',true);
        document.getElementById(id).disabled = true;
        $(`#${id}`+ chilid != null ? ` .${chilid}` : '').addClass('spinner-border');
    }else{
        document.getElementById(id).disabled = false;
        $(`#${id}`+ chilid != null ? ` .${chilid}` : '').removeClass('spinner-border');
    }
}

function timeout(func = null){
    setTimeout(func,5000);
}