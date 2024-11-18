var url= new URLSearchParams(window.location.search)
var id_url= url.get('song_id')
var id_playlist= url.get('playlist_id')
function get_inf(id_url){
    fetch(`../api/api_bookmarks.php`) // bookmark
    .then(res => res.json())
    .then((data) => {
        if(data.success){ 
            // console.log(data.data)
            list_m=[]
            data.data.forEach(e => {
                if(id_url===e.song_id){
                    $('.liked').click()
                }
            });
        }
    })
    .catch(err => console.error(err))

    fetch(`../api/api_comments.php`) // comment
    .then(res => res.json())
    .then((data) => {
        if(data.success){ 
            // console.log(data.data)
            list_m=[]
            let ls=$('.list_cmt')
            // ls.find("li").remove()
            // console.log(data.data)
            data.data.forEach(e => {
                if(id_url===e.song_id){
                    let card=`<li class="fullcm">
                                <img src="../images/Unknown.jpg" slt="...">
                                <h5 class="fullcmm">
                                    ${e.username}
                                    <div class="ff">${e.content}</div>
                                </h5>
                            </li>`
                    ls.append(card)
                }
            });
        }
    })
    .catch(err => console.error(err))
    // console.log(`<button type="submit" id="btntext" data-id=${id_url}><i class="bi bi-send bi-sm"></i></button>`)
    $('#btntext').remove()
    $('.input-group').append(`<button type="submit" id="btntext" data-id=${id_url}><i class="bi bi-send bi-sm"></i></button>`)
}
$(function(){
    // $('#btntext').on("click",function(){
    //     let data=$(this).closest(".input-group").find("input").val()
    //     get_inf()
    // })
    if(id_url!=null){
        let ls=$('.list_cmt')
        ls.find("li").remove()
        get_inf(id_url)
    }
        
})
