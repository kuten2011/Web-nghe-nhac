function get_inf() {
    fetch('api/api_songs.php')  //for card
        .then(res => res.json())
        .then((data) => {
            if (data.success) {
                let ls = $("#list_songs")
                ls.find("div").remove()
                let list_i = [];
                
                for (let j = 0; j < 6; j++) {
                    let i;
                    i = Math.floor(Math.random() * (data.data.length - 1)) + 1;
                    while (data.data[i].song_id in list_i) {
                        i = Math.floor(Math.random() * (data.data.length - 1)) + 1;
                    }
                    list_i.push(data.data[i].song_id);
                    let img_song = ``
                    if (isFileExist(`./images/song_${data.data[i].song_id}.jpg`)) {
                        img_song = `song_${data.data[i].song_id}.jpg`
                    } else if (isFileExist(`./images/album_${data.data[i].album_id}.jpg`)) {
                        img_song = `album_${data.data[i].album_id}.jpg`
                    } else if (isFileExist(`./images/artist_${data.data[i].artist_id}.jpg`)) {
                        img_song = `artist_${data.data[i].artist_id}.jpg`
                    } else {
                        img_song = "Unknown.jpg"
                    }
                    card = `<div data-id=${data.data[i].song_id} class="card-music col-xs-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="card mb-3">
                            <i class="fas fa-play-circle" id="10"></i>
                            <img src="./images/${img_song}" class="rounded-3" alt="...">
                            </div>
                            <div class="description">
                                <p style="color:white;">${data.data[i].song_title} <br> <i>${data.data[i].artist_name}</i></p>
                            </div>
                        </div>`
                    ls.append(card)
                }
            }
        })
        .catch(err => console.error(err))

    fetch('api/api_playlists.php?action=get_inf') //for playlist
        .then(res => res.json())
        .then((data) => {
            if (data.success) {
                let ls = $(".music-weekly")
                // $(".chart").remove()
                let ls2 = $(".menu_song")
                ls2.find("li").remove()
                let spl = $("#showplaylist")
                spl.find("li").remove()
                for (let i = 0; i < data.data.length; i++) {
                    if (i < 2) {
                        // console.log(data.data[i][0].playlist_id)
                        card = `<li><a style="text-decoration: none;" href="html/mhhn.html?playlist_id=${data.data[i][0].playlist_id}">
                                <i class="fas fa-list"></i>
                                <span class="nav-item">${data.data[i][0].playlist_name}</span>
                            </a></li>`
                        spl.append(card)
                    }
                    if (i === 0 && data.data[i][0].song_id != '') {
                        let img_song = ``
                        // console.log(data.data[i][0])
                        if (isFileExist(`./images/song_${data.data[i][0].song_id}.jpg`)) {
                            img_song = `song_${data.data[i][0].song_id}.jpg`
                        } else if (isFileExist(`./images/album_${data.data[i][0].album_id}.jpg`)) {
                            img_song = `album_${data.data[i][0].album_id}.jpg`
                        } else if (isFileExist(`./images/artist_${data.data[i][0].artist_id}.jpg`)) {
                            img_song = `artist_${data.data[i][0].artist_id}.jpg`
                        } else {
                            img_song = "Unknown.jpg"
                        }
                        card = `<h4 style="color:white; text-align: left;">MUSIC WEEKLY</h4>
                            <img src="./images/${img_song}" alt="party img" width="200px" height="150px">
                            <p style="color: white; text-align: center;">${data.data[i][0].playlist_name}
                            <br> Updated 10/4/2023
                            </p>
                            <button class="btn-auto" value=${data.data[i][0].playlist_id}>
                            <i class="fas fa-play"></i><i class="text-auto">Auto Playlist</i></button>
                            <br>`
                        ls.html(card)

                        for (let j = 0; j < data.data[i].length && j < 5; j++) {
                            // console.log(data.data[i][j])
                            img_song = ``
                            // console.log(data.data[i][0])
                            if (isFileExist(`./images/song_${data.data[i][j].song_id}.jpg`)) {
                                img_song = `song_${data.data[i][j].song_id}.jpg`
                            } else if (isFileExist(`./images/album_${data.data[i][j].album_id}.jpg`)) {
                                img_song = `album_${data.data[i][j].album_id}.jpg`
                            } else if (isFileExist(`./images/artist_${data.data[i][j].artist_id}.jpg`)) {
                                img_song = `artist_${data.data[i][j].artist_id}.jpg`
                            } else {
                                img_song = "Unknown.jpg"
                            }
                            // ${data.data[i][j].playlist_name}
                            card =
                                `
                                <li class="songItem" value=${data.data[i][j].song_id}=>
								<div class="container">
									<div class="row">
										<div class="col-1">
											<div class="song-item">
												<i class="fas fa-play-circle" id="10"></i>
												<img src="images/${img_song}" alt="">
											</div>
										</div>
										<div class="col-7">
											<h5>
												${data.data[i][j].song_title}
												<div class="subtitle">${data.data[i][j].artist_name}</div>
											</h5>
										</div>
									</div>
								</div>
							</li>`
                            ls2.append(card)
                        }
                    }
                }
            }
        })
        .catch(err => console.error(err))

    fetch('api/api_songs.php?action=get_chart')  //for chart
        .then(res => res.json())
        .then((data) => {
            if (data.success) {
                let ls = $(".top-song")
                ls.find("li").remove()
                for (let i = 1; i < 5; i++) {
                    if (i === 1) {
                        let img_song = ``
                        if (isFileExist(`./images/song_${data.data[0].song_id}.jpg`)) {
                            img_song = `song_${data.data[0].song_id}.jpg`
                        } else if (isFileExist(`./images/album_${data.data[0].album_id}.jpg`)) {
                            img_song = `album_${data.data[0].album_id}.jpg`
                        } else if (isFileExist(`./images/artist_${data.data[0].artist_id}.jpg`)) {
                            img_song = `artist_${data.data[0].artist_id}.jpg`
                        } else {
                            img_song = "Unknown.jpg"
                        }
                        card = `<li class="songItem" value=${data.data[0].song_id}>
                                <h3 style="color: aqua; border: 3px solid aqua;">01</h3>
                                <div class="song-item" id="top1-item">
                                    <i class="fas fa-play-circle" id="10"></i>
                                    <img src="./images/${img_song}" alt="CND">
                                </div>
                                <h5>
                                    ${data.data[0].song_title}
                                    <div class="subtitle">${data.data[0].artist_name}</div>
                                </h5>
                            </li>`
                        ls.append(card)
                    }
                    let img_song = ``
                    if (isFileExist(`./images/song_${data.data[i].song_id}.jpg`)) {
                        img_song = `song_${data.data[i].song_id}.jpg`
                    } else if (isFileExist(`./images/album_${data.data[i].album_id}.jpg`)) {
                        img_song = `album_${data.data[i].album_id}.jpg`
                    } else if (isFileExist(`./images/artist_${data.data[i].artist_id}.jpg`)) {
                        img_song = `artist_${data.data[i].artist_id}.jpg`
                    } else {
                        img_song = "Unknown.jpg"
                    }
                    card = `<li class="songItem" value=${data.data[i].song_id}>
                                <h6>0${i + 1}</h6>
                                <div class="song-item">
                                    <i class="fas fa-play-circle" id="10"></i>
                                    <img src="./images/${img_song}" alt="LT">
                                </div>
                                <h5>
                                    ${data.data[i].song_title}
                                    <div class="subtitle">${data.data[i].artist_name}</div>
                                </h5>
                            </li>`
                    ls.append(card)
                }
            }
        })
        .catch(err => console.error(err))
}
$(function () {
    $('.music-weekly').on("click", ".btn-auto", function () {
        let id = $(this).val()
        window.location.href = `html/mhhn.html?playlist_id=${id}`
        // console.log(`html/mhhn.html?playlist_id=${id}`)
    })
    $('#list_songs').on("click", ".card-music", function () {
        let id = $(this).data("id")
        window.location.href = `html/mhhn.html?song_id=${id}`
        // console.log(`html/mhhn.html?song_id=${id}`)
    })
    $('body').on("click", ".songItem", function () {
        let id = $(this).val()
        window.location.href = `html/mhhn.html?song_id=${id}`
        // console.log(`html/mhhn.html?song_id=${id}`)
    })
})