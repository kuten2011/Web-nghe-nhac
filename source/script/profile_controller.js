var url = new URLSearchParams(window.location.search)
var id_url = url.get('user_id')
let thongtin = {
    action: "profile"
}
console.log(thongtin)
function get_inf() {
    fetch(`../api/api_users.php`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(thongtin)
    })
        
        .then(res => res.json())
        .then((data) => {
            if (data.success) {
                let ls = $("#username")
                ls.text(data.data.username)
                ls = $("#email")
                ls.text(data.data.email)
                ls = $("#dateofbirth")
                ls.text(convert_datetime(data.data.date_of_birth))
                ls = $("#gender")
                ls.text(data.data.gender.toUpperCase())
            }
        })
        .catch(err => console.error(err))
    $('#profile_url').attr("href", `profile.`)
    $('#editPF_url').attr("href", `editPF.html`)
    $('#changePW_url').attr("href", `changePW.html`)
}