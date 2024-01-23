 var  requiredmsg = 'هذا الحقل مطلوب';
 var  emailmsg ='هذا الحقل يجب ان يكون عنوان بريد الكتروني';
 function  validatempty(input) {

    //var input = $(this);
    // $("#" + key).addClass('parsley-error');
    input.removeClass("parsley-error");
   input.nextAll(':has(.parsley-required):first').find('.parsley-required').html("");
    if (!required(input.val())) {
        input.addClass("parsley-error");//emptyMsg
        input.nextAll(':has(.parsley-required):first').find('.parsley-required').html(requiredmsg);
        return false;
    }
    return true;
}
function required(inputtxt) {

    var empt = $.trim(inputtxt);
    if (empt == "") {
        //alert("Please input a Value");
        return false;
    }
    else {
        //alert('Code has accepted : you can try another');
        return true;
    }
}
function validateinputemail(input, msg) {
    //var input = $(this);
    input.removeClass("parsley-error");
    input.nextAll(':has(.parsley-required):first').find('.parsley-required').html("");
    if (!ValidateEmail(input.val())) {
        input.addClass("parsley-error");//emptyMsg
        input.nextAll(':has(.parsley-required):first').find('.parsley-required').html(msg);
        return false;
    }
    return true
}
function allnumeric(inputtxt) {
    const regex = /^[0-9]+$/;
    const found = inputtxt.match(regex);
    if (found != null) {
        //  alert('Your Registration number has accepted....');
        return true;
    }
    else {


        return false;
    }
}
function ValidateEmail(inputText) {
    // alert("hii");
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (inputText.match(mailformat)) {

        return true;
    }
    else {
        //alert("You have entered an invalid email address!");
        //document.form1.text1.focus();
        return false;
    }
}

function stringlength(inputtxt, minlength, maxlength) {
    var field = inputtxt;
    var mnlen = minlength;
    var mxlen = maxlength;

    if (field.length < mnlen || field.length > mxlen) {

        return false;
    }
    else {
        //alert('Your userid have accepted.');
        return true;
    }
}

$(document).ready(function () {
//  customer

function validateinput(input, minlength, maxlength, emptyMsg, lengthMsg) {

    //var input = $(this);
    input.removeClass("is-invalid");
    input.nextAll('.alert-danger:first').attr("hidden", true).empty();
    if (!required(input.val())) {
        input.addClass("is-invalid");
        input.nextAll('.alert-danger:first').attr("hidden", false).append(emptyMsg);
        return false;

    } else if (!stringlength(input.val(), minlength, maxlength)) {
        input.addClass("is-invalid");
        input.nextAll('.alert-danger:first').attr("hidden", false).append(lengthMsg);
        return false;
    }
    return true;
}

function validateNumber(input) {

    //var input = $(this);
    input.removeClass("is-invalid");
    input.nextAll('.alert-danger:first').attr("hidden", true).empty();
    if (!allnumeric(input.val())) {
        input.addClass("is-invalid");
        input.nextAll('.alert-danger:first').attr("hidden", false).append(NotNumericMsg);
        return false;
    }
    return true;
}
function validateinputlength(input, minlength, maxlength, msg) {

    //var input = $(this);
    input.removeClass("is-invalid");
    input.nextAll('.alert-danger:first').attr("hidden", true).empty();
    if (!stringlength(input.val(), minlength, maxlength)) {
        input.addClass("is-invalid");
        msg = msg.replace("[[min]]", minlength.toString());
        msg = msg.replace("[[max]]", maxlength.toString());
        input.nextAll('.alert-danger:first').attr("hidden", false).append(msg);
        return false;
    }
    return true;
}


//check valid in form
//name
$("form#customerform input[name=name]").focusout(function (e) {
    if (!validateinput($(this), 1, 100, emptyMsg, lengthMsg)) {
        tmpchk = tmpchk && false;
        return false;
    } else {
        tmpchk = tmpchk && true;
        return true;
    }

});
//lastname
$("form#customerform input[name=lastName]").focusout(function (e) {

    if (!validateinput($(this), 1, 100, emptyMsg, lengthMsg)) {
        tmpchk = tmpchk && false;
        return false;
    } else {
        tmpchk = tmpchk && true;
        return true;
    }
});
//company
$("form#customerform input[name=company]").focusout(function (e) {
    lengthlessMsg = lengthlessMsg.replace("[[max]]", (100).toString());
    if (!validateinputlength($(this), 0, 100, lengthlessMsg)) {
        tmpchk = tmpchk && false;
        return false;
    } else {
        tmpchk = tmpchk && true;
        return true;
    }

});
//cityName
$("form#customerform [name=cityName]").focusout(function (e) {

    if (!validatempty($(this))) {
        tmpchk = tmpchk && false;
        return false;
    } else {
        tmpchk = tmpchk && true;
        return true;
    }
});
//address
$("form#customerform input[name=address]").focusout(function (e) {


    if (!validateinput($(this), 1, 100, emptyMsg, lengthMsg)) {
        tmpchk = tmpchk && false;
        return false;
    } else {
        tmpchk = tmpchk && true;
        return true;
    }
});
//phone
$("form#customerform input[name=phone]").focusout(function (e) {

    if (required($(this).val())) {
        if (!validateNumber($(this))) {
            tmpchk = tmpchk && false;
            return false;
        } else if (!validateinputlength($(this), 4, 15, lengthMsg)) {
            tmpchk = tmpchk && false;
            return false;

        } else {
            tmpchk = tmpchk && true;
            return true;
        }
    } else {
        tmpchk = tmpchk && true;
        return true;
    }

});

$("form#customerform input[name=phone]").keypress(function (e) {
    // 
    //   var content = $(this).val();
    var s = String.fromCharCode(e.which);
    if (!allnumeric(s)) {
        e.preventDefault();
    }
});
$("form#customerform input[name=phone]").on("paste", function (e) {
    var pastedData = e.originalEvent.clipboardData.getData('text');
    if (!allnumeric(pastedData)) {
        e.preventDefault();
        //NotNumericMsg
        return false;
    }
    return true;
});
////////////////
//mobile
$("form#customerform input[name=mobile]").focusout(function (e) {

    if (!validatempty($(this))) {
        tmpchk = tmpchk && false;
        return false;
    }
    else if (!validateNumber($(this))) {
        tmpchk = tmpchk && false;
        return false;
    } else if (!validateinputlength($(this), 4, 15, lengthMsg)) {
        tmpchk = tmpchk && false;
        return false;

    } else {
        tmpchk = tmpchk && true;
        return true;
    }
});

$("form#customerform input[name=mobile]").keypress(function (e) {
    // 
    //   var content = $(this).val();
    var s = String.fromCharCode(e.which);
    if (!allnumeric(s)) {
        e.preventDefault();
    }
});
$("form#customerform input[name=mobile]").on("paste", function (e) {
    var pastedData = e.originalEvent.clipboardData.getData('text');
    if (!allnumeric(pastedData)) {
        e.preventDefault();
        //NotNumericMsg
        return false;
    }
    return true;
});
////////////////
//Email

$("form#customerform input[name=email]").focusout(function (e) {

    if (!validatempty($(this))) {
        tmpchk = tmpchk && false;
        return false;
    }
    else if (!validateinputemail($(this), EmailNotValidMsg)) {
        tmpchk = tmpchk && false;
        return false;
    } else if (!validateinputlength($(this), 4, 100, lengthMsg)) {
        tmpchk = tmpchk && false;
        return false;
    } else {
        tmpchk = tmpchk && true;
        return true;
    }
});
$("form#customerform input[name=email]").on("paste", function (e) {
    var pastedData = e.originalEvent.clipboardData.getData('text');

    if (!ValidateEmail(pastedData)) {
        e.preventDefault();
        return false;
    } else if (!stringlength(pastedData, 4, 100)) {
        e.preventDefault();
        return false;
    } else {
        return true;
    }
    //NotNumericMsg
});
////
//user name
$("form#customerform input[name=userName]").focusout(function (e) {

    if (!validatempty($(this))) {
        return false;
    }
    else if (!validateinputlength($(this), 3, 100, lengthMsg)) {
        return false;
    } else {
        return true;
    }
});
/////////
//password
//
$("form#customerform input[name=password]").focusout(function (e) {
    if (!validatempty($(this))) {
        tmpchk = tmpchk && false;
        return false;
    }
    else if (!validateinputlength($(this), 6, 20, lengthMsg)) {
        tmpchk = tmpchk && false;
    } else {
        tmpchk = tmpchk && true;
        return true;
    }
});
    //login
    //user name
    $("form#loginForm input[name=userName]").focusout(function (e) {

        if (!validatempty($(this))) {
            return false;
        }
        else if (!validateinputlength($(this), 3, 100, lengthMsg)) {
            return false;
        } else {
            return true;
        }
    });
    /////////
    //password
    //
    $("form#loginForm input[name=password]").focusout(function (e) {
        if (!validatempty($(this))) {
            tmpchk = tmpchk && false;
            return false;
        }
        else if (!validateinputlength($(this), 6, 20, lengthMsg)) {
            tmpchk = tmpchk && false;
        } else {
            tmpchk = tmpchk && true;
            return true;
        }
    });
    //end login
    //change password
    $("form#ChPassform input[name=oldPassword]").focusout(function (e) {
        if (!validatempty($(this))) {
            tmpchk = tmpchk && false;
            return false;
        }
        else if (!validateinputlength($(this), 6, 20, lengthMsg)) {
            tmpchk = tmpchk && false;
        } else {
            tmpchk = tmpchk && true;
            return true;
        }
    });
    $("form#ChPassform input[name=password]").focusout(function (e) {
        if (!validatempty($(this))) {
            tmpchk = tmpchk && false;
            return false;
        }
        else if (!validateinputlength($(this), 6, 20, lengthMsg)) {
            tmpchk = tmpchk && false;
        } else {
            tmpchk = tmpchk && true;
            return true;
        }
    });
    $("form#ChPassform input[name=passwordconfirm]").focusout(function (e) {
        if (!validatempty($(this))) {
            tmpchk = tmpchk && false;
            return false;
        }
        else if (!validateinputlength($(this), 6, 20, lengthMsg)) {
            tmpchk = tmpchk && false;
        }
        else if ($(this).val() != $("form#ChPassform input[name=password]").val() ) {

            $(this).removeClass("is-invalid");
            $(this).nextAll('.alert-danger:first').attr("hidden", true).empty();
            $(this).addClass("is-invalid");
            $(this).nextAll('.alert-danger:first').attr("hidden", false).append(notMatchMsg);
            tmpchk = tmpchk && false;
        }
        else {
            tmpchk = tmpchk && true;
            return true;
        }
    });

    //contact form
    //name
    $("form#contactform input[name=name]").focusout(function (e) {
        if (!validateinput($(this), 1, 100, emptyMsg, lengthMsg)) {
            tmpchk = tmpchk && false;
            return false;
        } else {
            tmpchk = tmpchk && true;
            return true;
        }

    });

    $("form#contactform input[name=email]").focusout(function (e) {

        if (!validatempty($(this))) {
            tmpchk = tmpchk && false;
            return false;
        }
        else if (!validateinputemail($(this), EmailNotValidMsg)) {
            tmpchk = tmpchk && false;
            return false;
        } else if (!validateinputlength($(this), 4, 100, lengthMsg)) {
            tmpchk = tmpchk && false;
            return false;
        } else {
            tmpchk = tmpchk && true;
            return true;
        }
    });
    $("form#contactform input[name=email]").on("paste", function (e) {
        var pastedData = e.originalEvent.clipboardData.getData('text');

        if (!ValidateEmail(pastedData)) {
            e.preventDefault();
            return false;
        } else if (!stringlength(pastedData, 4, 100)) {
            e.preventDefault();
            return false;
        } else {
            return true;
        }
        //NotNumericMsg
    });
    //mobile
    $("form#contactform input[name=mobile]").focusout(function (e) {

        if (!validatempty($(this))) {
            tmpchk = tmpchk && false;
            return false;
        }
        else if (!validateNumber($(this))) {
            tmpchk = tmpchk && false;
            return false;
        } else if (!validateinputlength($(this), 4, 15, lengthMsg)) {
            tmpchk = tmpchk && false;
            return false;

        } else {
            tmpchk = tmpchk && true;
            return true;
        }
    });

    $("form#contactform input[name=mobile]").keypress(function (e) {
        // 
        //   var content = $(this).val();
        var s = String.fromCharCode(e.which);
        if (!allnumeric(s)) {
            e.preventDefault();
        }
    });
    $("form#contactform input[name=mobile]").on("paste", function (e) {
        var pastedData = e.originalEvent.clipboardData.getData('text');
        if (!allnumeric(pastedData)) {
            e.preventDefault();
            //NotNumericMsg
            return false;
        }
        return true;
    });
////////////////
    //message
    $("form#contactform #messagetrix").focusout(function (e) {


        if (!validatempty($(this))) {
            tmpchk = tmpchk && false;
            return false;
        }
        else if (!validateinputlength($(this), 15, 500, lengthMsg)) {
            tmpchk = tmpchk && false;
            return false;
        } else {
            tmpchk = tmpchk && true;
            return true;
        }
    });

    //admin
    //social
    $("form#socialform input[name=facebook]").focusout(function (e) {
        if (!validateinput($(this), 1, 100, emptyMsg, lengthMsg)) {
            tmpchk = tmpchk && false;
            return false;
        } else {
            tmpchk = tmpchk && true;
            return true;
        }

    });
 
    $("form#socialform input[name=twitter]").focusout(function (e) {
        if (!validateinput($(this), 1, 100, emptyMsg, lengthMsg)) {
            tmpchk = tmpchk && false;
            return false;
        } else {
            tmpchk = tmpchk && true;
            return true;
        }

    });
    $("form#socialform input[name=instagram]").focusout(function (e) {
        if (!validateinput($(this), 1, 100, emptyMsg, lengthMsg)) {
            tmpchk = tmpchk && false;
            return false;
        } else {
            tmpchk = tmpchk && true;
            return true;
        }

    });
});
    /////////////////////////////////////////////////////
 