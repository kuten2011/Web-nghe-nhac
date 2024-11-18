var url= new URLSearchParams(window.location.search)
var id_url= url.get('id')
var psw=''
function get_inf(){
    fetch(`../api/api_users.php?id=${id_url}`)
    .then(res => res.json())
    .then((data) => {
        if(data.success){
            psw=data.data.password
        }
    })
    .catch(err => console.error(err))
}
function checkdata(data){
    let pw_input=data["pw_input"]
    let new_pw=data["new_pw"]
    let rnew_pw=data["rnew_pw"]
    if (pw_input==='' || new_pw==='' || rnew_pw==='')
        return "Please enter all."
    if (psw!=pw_input || psw==='')
        return "Wrong password"
    if (psw===new_pw || psw===rnew_pw)
        return "Enter new different password"
    if (pw_input===new_pw || pw_input===rnew_pw)
        return "Enter new different password"
    if (new_pw!=rnew_pw)
        return "Password confirmation must be the same as new password"
    let reg = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/    
    if (!new_pw.match(reg))
        return "Password at least 8 characters with at least 1 number, 1 letter, 1 special character."
    return true
}
$(function(){
    get_inf()
    $("#btnsave").click(function(){
        let thongtinpw={
            pw_input:       $('#curpw').find("input").val(),
            new_pw:         $('#newpw').find("input").val(),
            rnew_pw:        $('#rnewpw').find("input").val()
        }
        if(!checkdata(thongtinpw)){
            $('#msg').text("Error")
            $('#msg').css("background-color","lightcoral")
            return false
        }
        let thongtin={
            user_id:        id_url,
            username:       "",
            email:          "",
            password:       thongtinpw["new_pw"],
            dateofbirth:    "",
            gender:         ""
        }
        fetch(`../api/api_users.php`,{method: 'put', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(thongtin)})
        .then(res => res.json())
        .then((data) => {
            if(data.success){
                if(data.data){
                    window.location.href=`profile.html?id=${id_url}`
                    return true
                }else{
                    return false
                }
            }
        })
        .catch(err => console.error(err))
    })
})
