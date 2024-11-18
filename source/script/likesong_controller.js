let song_id_list = []
function get_inf() {
	let thongtin={
		action: "like-song-page"
	}
	fetch('../api/api_songs.php', {
		method: 'POST',
		headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify(thongtin)
	})
		.then(res => res.json())
		.then((data) => {
			console.log(data)
			if (data.success) {
				let ls = $("#list_songs")
				ls.find("li").remove()
				let color = 'aqua'
				for (let i = 0; i < data.data.length; i++) {
					if (isFileExist(`../images/song_${data.data[i].song_id}.jpg`)) {
						img_song = `song_${data.data[i].song_id}.jpg`
					} else if (isFileExist(`../images/artist_${data.data[i].artist_id}.jpg`)) {
						img_song = `artist_${data.data[i].artist_id}.jpg`
					}
					else {
						img_song = "Unknown.jpg"
					}
					card = `
                <li class="songItem">
                    <div class="container">
                      <div class="row">
                        <div class="col-1">
                          <h6>${i + 1}</h6>
                        </div>
                        <div class="col-1">
                          <div class="song-item">
                            <i class="fas fa-play-circle" id="10" onclick="openSong()"></i>
                            <img src="../images/${img_song}" onclick="openSong()" alt="WFY">
                          </div>
                        </div>
                        <div class="col-6">
                          <h5 onclick="openSong()">
                            ${data.data[i].song_title}
                            <div class="subtitle">${data.data[i].artist_name}</div>
                          </h5>
                        </div>
                        <div class="col-2">
                          <div class="btns">
                            <button id="btnh" value="${data.data[i].song_id}"  class="list-btn">
                              <i class="heart-button btn-love fas fa-heart " style='color:${color}' ></i></button>
                          </div>
                        </div>
                        <div class="col-1">
                          <div class="moreOption">
                            <button class="morebtn">
                              <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div id="myShowmore" class="showMore-content" style="width: fit-content">
                              <a href="#">Remove from Playlist</a>
                              <a href="#">Rating</a>
                              <a href="#">Download</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                `
					ls.append(card)
				}
			}
		})
		.catch(err => console.error(err))
}


// function loadItem() {
// 	let beginGet = limit * (thisPage - 1)
// 	let endGet = limit * thisPage - 1
// 	list.forEach((item, key) => {
// 		if (key >= beginGet && key <= endGet) {
// 			item.style.display = 'block'
// 		} else {
// 			item.style.display = 'none'
// 		}
// 	})
// 	listPage()
// }
// loadItem()
// function listPage() {
// 	let count = Math.cell(list.length / limit)
// 	document.querySelector('.listPage').innerHTML = ''

// 	if (thisPage != 1) {
// 		let prev = document.createElement('li')
// 		prev.innerText = "PREV"
// 		prev.setAttribute('onclick', "changePage(" + (thisPage - 1) + ")")
// 		document.querySelector('.listPage').appendChild(prev)
// 	}

// 	for (i = 1; i <= count; i++) {
// 		let newPage = document.createElement('li')
// 		newPage.innerText = i
// 		if (i == thisPage) {
// 			newPage.classList.add('active')
// 		}
// 		newPage.setAttribute('onclick', "changePage(" + i + ")")
// 		document.querySelector('.listPage').appendChild(newPage)
// 	}
// 	if (thisPage != count) {
// 		let prev = document.createElement('li')
// 		prev.innerText = "NEXT"
// 		prev.setAttribute('onclick', "changePage(" + (thisPage + 1) + ")")
// 		document.querySelector('.listPage').appendChild(prev)
// 	}
// }
// function changePage(i) {
// 	thisPage = i;
// 	loadItem();
// }

$(function () {
	$(".top-song").on("click", ".list-btn", function () {
		let i_btn = $(this).find("i")

		if (i_btn.css("color") == "rgb(0, 255, 255)") {
			i_btn.css({
				color: "grey",
				transition: "color 0.2s"
			});
			let thongtin = {
				action: "remove-like",
				song_id: $(this).val()
			}
			console.log(thongtin)
			fetch(`../api/api_bookmarks.php`, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(thongtin)
			})
				.then(res => res.json())
				.then((data) => {
					console.log(data);
				})
		} else {
			i_btn.css({
				color: "aqua",
				transition: "color 0.2s"
			});
			let thongtin = {
				action: "add-like",
				song_id: $(this).val()
			}
			console.log(thongtin)
			fetch(`../api/api_bookmarks.php`, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(thongtin)
			})
				.then(res => res.json())
				.then((data) => {
					console.log(data);
				})

		}
	})
})