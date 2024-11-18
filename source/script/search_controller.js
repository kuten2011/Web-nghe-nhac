let song_id_list = []
function get_inf() {
	
	let data = JSON.parse(sessionStorage.getItem('dataSearch'))
	console.log(data)
	let color = ''
	let ls = $("#list_songs")
	ls.find("li").remove()
	if(data.data=="Invalid Input") {
		card=`<h4 style="color:white;">No result found</h4>`
		ls.append(card)
	}
	else if (data.data.length>0 ){
		for (let i = 0; i < data.data.length; i++) {
			// console.log(data.data[i])
			let img_song = ``
			if (isFileExist(`../images/song_${data.data[i].song_id}.jpg`)) {
				img_song = `song_${data.data[i].song_id}.jpg`
			} else if (isFileExist(`../images/artist_${data.data[i].artist_id}.jpg`)) {
				img_song = `artist_${data.data[i].artist_id}.jpg`
			}
			else {
				img_song = "Unknown.jpg"
			}
	
			color = 'grey'
			// console.log(data)
			if (data.isLogin) {
				
				for (let j = 0; j < data.dataLike.length; j++) {
					if (data.dataLike[j] === data.data[i].song_id) {
						color = 'aqua'
						console.log("bang nhau")
					}
					
				}
			}
			else {
				color = 'rgba(128, 128, 128, 0)'
			}
			// console.log(data.data[i])
			card = `
					<li class="songItem" data-id="${data.data[i].song_id}">
						<div class="container" >
						  <div class="row">
							<div class="col-1">
							  <h6>${i + 1}</h6>
							</div>
							<div class="col-1">
							  <div class="song-item">
								<i class="fas fa-play-circle" id="10" ></i>
								<img src="../images/${img_song}" alt="WFY">
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
								  <a id="remove" href="#">Remove from Playlist</a>
								  <a id="rating" href="#">Rating</a>
								  <a id="download" href="../mp3/${data.data[i].song_id}.mp3" download="${data.data[i].song_title}.mp3">Download</a>
								</div>
							  </div>
							</div>
						  </div>
						</div>
					  </li>
					`
					ls.append(card)
		}
	} else {
		card=`<h4 style="color:white;">No result found</h4>`
		ls.append(card)
	}
	
	
}
$(function(){
    $('#list_songs').on("click",".songItem",function(){
		let t= event.target;
		console.log(t)
		console.log(t.tagName)
		if(t.tagName!='I'){
			let id= $(this).data("id")
        	window.location.href=`mhhn.html?song_id=${id}`
			// console.log(`html/mhhn.html?song_id=${id}`)
		}
    })
})

$(function () {
	// get_inf()
	let i_btn=''
	if (sessionStorage.getItem('isLogin')) {
		$(".top-song").on("click", ".list-btn", function () {
			i_btn = $(this).find("i")

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
	}
})