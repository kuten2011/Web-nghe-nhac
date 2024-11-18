function get_inf(){
    fetch('../api/api_albums.php')
    .then(res => res.json())
    .then((data) => {
        if(data.success){
            let ls=$("#list_albums")
            ls.find("div").remove()
            for (let i=0;i<data.data.length;i++){
                // console.log(data.data[i])
                let img_album=``
                if(isFileExist(`../images/album_${data.data[i].album_id}.jpg`)){
                    img_album=`album_${data.data[i].album_id}.jpg`
                }else if(isFileExist(`../images/artist_${data.data[i].artist_id}.jpg`)){
                    img_album=`artist_${data.data[i].artist_id}.jpg`
                }else{
                    img_album="Unknown.jpg"
                }
                card=  `<div data-id=${data.data[i].album_id} class="card-music col-xs-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="card mb-3">
                                <i class="fas fa-play-circle" id="10"></i>
                                <img src="../images/${img_album}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">${data.data[i].album_title}</h5>
                                <p class="card-text">${data.data[i].artist_name}</p>
                            </div>
                            </div>
                        </div>`
                ls.append(card)
            }
        }
    })
    .catch(err => console.error(err))
}
$(function(){
    $('#list_albums').on("click",".card-music",function(){
        let id= $(this).data("id")
        window.location.href=`mhhn.html?album_id=${id}`
        // console.log(`html/mhhn.html?song_id=${id}`)
    })
})