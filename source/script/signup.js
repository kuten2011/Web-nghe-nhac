
function checkEmail() {
    let email = $('#email').val().trim()
    if (email == "") {
        $("#msgEmail").text("Please enter your email.")
        return false
    }
    let reg = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    if (!email.match(reg)) {
        $("#msgEmail").text("Please enter a valid email.")
        return false
    }
    $("#msgEmail").text('')
    return true
}
function checkPassword() {
    let pas = $('#password').val();
    let reg = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}/;
    if (pas == '') {
        $("#msgPassword").text("Please enter your password")
        return false
    }
    if (!pas.match(reg)) {
        $("#msgPassword").text("Password must be at least 8 characters with at least 1 letter, 1 number and 1 special character.")
        return false;
    }
    $("#msgPassword").text('')
    return true
}
function checkCfPassword() {
    let pas = $('#password').val();
    let cfpas = $('#cfpassword').val();
    if (pas !== cfpas) {
        $("#msgCfpassword").text("Please enter the same password.")
        return false
    }
    if (pas === '') {
        $("#msgCfpassword").text("Please enter password first.")
        return false
    }
    $("#msgCfpassword").text('')
    return true
}
function checkUsername() {
    let reg = /^[a-zA-Z0-9]{8,}$/;
    let usn = $('#username').val();
    if (usn === '') {
        $("#msgUsername").text("Please enter your username")
        return false
    }
    if (!usn.match(reg)) {
        $("#msgUsername").text("Username must be at least 8 characters, can contain letter and number.")
        return false;
    }
    $("#msgUsername").text('')
    return true
}
function checkDate() {
    let regDay = /^(0?[1-9]|[1-2][0-9]|3[0-1])$/;
    let regYear = /^(19\d{2}|20\d{2}|(?:21(?=[012]))\d{2})$/
    let day = $('#day').val();
    let year = $('#year').val()
    let month = $('#month').val()
    if (day === '' || year === '' || month === '') {
        $('#msgDate').text("Please enter date.")
        return false
    }
    if (!day.match(regDay)) {
        $('#msgDate').text("Please enter a valid day.")
        return false
    }
    if (!year.match(regYear)) {
        $('#msgDate').text("Please enter a valid year.")
        return false
    }
    $('#msgDate').text("")
    return true
}
function checkGender() {
    if ($("input[name='gender']:checked").length == 0) {
        $('#msgGender').text("Select your gender.")
        return false
    }
    $('#msgGender').text("")
    return true
}
function checkData() {
    checkEmail();
    checkPassword();
    checkCfPassword();
    checkUsername();
    checkDate();
    checkGender();
}
$(function () {
    $('#email').blur(function () {
        checkEmail();
    })
    $('#password').blur(function () {
        checkPassword();
    })
    $('#cfpassword').blur(function () {
        checkCfPassword();
    })
    $('#username').blur(function () {
        checkUsername();
    })
    $('#day').blur(function () {
        checkDate();
    })
    $('#month').blur(function () {
        checkDate();
    })
    $('#year').blur(function () {
        checkDate();
    })
    $('#showPassword').click(function(){
        var x = document.getElementById("password");
		if (x.type === "password") {
			x.type = "text";
			$('#showPassword').find('i').remove();
			$('#showPassword').append('<i class="far fa-eye-slash"></i>');
		} else {
			x.type = "password";
			$('#showPassword').find('i').remove();
			$('#showPassword').append('<i class="far fa-eye"></i>');
		}
    })
    $('#showCfPassword').click(function(){
        var x = document.getElementById("cfpassword");
		if (x.type === "password") {
			x.type = "text";
			$('#showCfPassword').find('i').remove();
			$('#showCfPassword').append('<i class="far fa-eye-slash"></i>');
		} else {
			x.type = "password";
			$('#showCfPassword').find('i').remove();
			$('#showCfPassword').append('<i class="far fa-eye"></i>');
		}
    })
    $('#signup').click(function () {
        if (
            checkEmail() &&
            checkPassword() &&
            checkCfPassword() &&
            checkUsername() &&
            checkDate() &&
            checkGender()
        ) {
            let email = $('#email').val()
            let pas = $('#password').val()
            let usn = $('#username').val()
            let gender = $('input[name="gender"]:checked').val();
            let date = $('#year').val()+"-"+$('#month').val()+"-"+$('#day').val()
            let thongtin = {
                email: email,
                password: pas,
                username: usn,
                dateofbirth: date,
                gender: gender,
                action: "signup"
            }
            console.log(thongtin)
            fetch(`../api/api_users.php`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(thongtin)
            })
                .then(res => res.json())
                .then((data) => {
                    
                    if (data.success) {
                        console.log(data.data)
                        window.location.href= '../html/login.html'
                    }
                    else {
                            $('#msgGender').text(data.data)

                    }
                })
                .catch(err => {
                    $('#msgGender').text("Failed.")
                    console.log(err)
                })
        }
        else {
            checkData();
        }

    })

});

