function get_inf(){
    fetch('../api/api_artists.php')
    .then(res => res.json())
    .then((data) => {
        if(data.success){
            let ls=$("#list_artists")
            console.log(ls)
            ls.find("div").remove()
            for (let i=0;i<data.data.length;i++){
                // console.log(data.data[i])
                let img_artist=``
                if(isFileExist(`../images/artist_${data.data[i].artist_id}.jpg`)){
                    img_artist=`artist_${data.data[i].artist_id}.jpg`
                }else{
                    img_artist="Unknown.jpg"
                }
                card=  `<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 rounded-circle">
                            <a href="#" class="link-item">
                            <img src="../images/${img_artist}" class="img-circle" alt="...">
                            <div class="card mb-3">
                                <div class="card-body">
                                <h5 class="card-title">${data.data[i].artist_name}</h5>
                                <p class="card-text"></p>
                                </div>
                            </div>
                            </a>
                        </div>`
                ls.append(card)
            }
        }
    })
    .catch(err => console.error(err))
}
