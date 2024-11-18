var url= new URLSearchParams(window.location.search)
var id_url= url.get('user_id')
function get_inf(){
    fetch(`../api/api_users.php`)
    .then(res => res.json())
    .then((data) => {
        if(data.success){
            let ls=$("#username").find("input")
            ls.attr("placeholder",data.data.username)
            ls=$("#email").find("input")
            ls.attr("placeholder",data.data.email)
            ls=$("#dateofbirth").find("input")
            ls.attr("placeholder",convert_datetime(data.data.date_of_birth))
            ls=$("#gender").find("input")
            ls.attr("placeholder",data.data.gender.toUpperCase())
        }
    })
    .catch(err => console.error(err))

}
function checkdata(data){
    // console.log(data["user_id"])
    let email =data["email"].trim()
    let reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
    if (!email.match(reg) && email!="")
        return false

    let username =data["username"].trim()
    reg = /(^[a-zA-Z0-9]{8,}$)/
    if (!username.match(reg) && username!=""){
        return false
    }
        
    let dateofbirth=data["dateofbirth"]
    reg=/^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/
    if (!dateofbirth.match(reg) && dateofbirth!="")
        return false
    return true
}
$(function(){
    $("#btnsave").click(function(){
        let thongtin={
            user_id:        id_url,
            username:       $("#username").find("input").val(),
            email:          $('#email').find("input").val(),
            password:       "",
            dateofbirth:    convert_datetime($('#dateofbirth').find("input").val()),
            gender:         $('#gender').find("select").val()
        }
        if(!checkdata(thongtin)){
            $('#msg').text("Error")
            $('#msg').css("background-color","lightcoral")
            return false
        }
        fetch(`../api/api_users.php`,{method: 'put', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(thongtin)})
        .then(res => res.json())
        .then((data) => {
            if(data.success){
                if(data.data){
                    window.location.href=`profile.html?user_id=${id_url}`
                    return true
                }else{
                    return false
                }
            }
        })
        .catch(err => console.error(err))
    })
})
