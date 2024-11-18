function isFileExist(urlToFile) {
	var xhr = new XMLHttpRequest();
	xhr.open('HEAD', urlToFile, false);
	xhr.send();

	if (xhr.status == "404") {
		return false;
	} else {
		return true;
	}
}
function pageRedirect() {
	window.location.href = "login.html";
}
function convert_datetime(str) {
	let strs = str.split("-")
	let kq = ''
	for (let i in strs.reverse()) {
		kq = kq + strs[i] + "/"
	}
	kq = kq.slice(0, -1)
	return kq
}

function loggedIndex() {
	let isLogin = sessionStorage.getItem('isLogin');
	let user_id = sessionStorage.getItem('user_id');
	let username = sessionStorage.getItem('username');
	let accountHtml = ``
	if (isLogin) {
		let profileUrl = ''
		let avatarUrl = ''
		if (window.location.pathname.includes("/html/")) {
			profileUrl = "../php/profile.php";
			avatarUrl = "../images/Unknown.jpg"
			console.log(1)
		} else {
			profileUrl = "./php/profile.php";
			avatarUrl = "./images/Unknown.jpg"
			console.log(2)
		}
		accountHtml = `
                    <label for="dropbtn">
                    <div class="dropdown" for = "dropbtn">
                    <label class="user-img" for="dropbtn">
                        <img id="user-img" src="${avatarUrl}" alt="avt">
                    </label>
                    <label id="username" for="dropbtn" class="user-name">${username}</label>
                    <button id="dropbtn" class="dropbtn">
                        <i class="fas fa-caret-down"></i>
                    </button>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="${profileUrl}">Profile</a>
                        <a id="logout-btn" href="#">Log Out</a>
                    </div>
                </div>
                </label>
        `;
		$('#account').html(accountHtml);
		if (sessionStorage.getItem('admin_rights') == 1) {
			forAdmin = `<a id="admin_rights" href="#">For Admin</a>`;
			$('#myDropdown').append(forAdmin)
		}
		
		$('#logout-btn').on('click', function () {
			let thongtin = {
				action: "logout"
			}
			console.log(thongtin)
			let urlFetch = ``
			if (window.location.pathname.includes("/html/")) {
				urlFetch = `../api/api_users.php`
			}
			else {
				urlFetch = `./api/api_users.php`
			}
			fetch(urlFetch, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(thongtin)
			})
				.then(res => res.json())
				.then((data) => {
					console.log(data)
					if (data.success) {
						sessionStorage.removeItem('isLogin');
						sessionStorage.removeItem('user_id');
						sessionStorage.removeItem('username');
						location.reload();
					}
					else {
						console.log('Error')
					}
				})
				.catch(err => {
					console.log(err)
				})

		});
	}
};
function url(url){
	if (window.location.pathname.includes("/html/")) {
		return `../${url}`;
	} else {
		return `./${url}`;
	}
}
function forAdmin(){
	$('#account').on('click','#admin_rights', function(){
		console.log("click adminright")
		let thongtin={
			action: "adminRights"
		}
		console.log(url("api/api_users"))
		fetch(url("api/api_users.php"), {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(thongtin)
		})
			.then(res => res.json())
			.then((data) => {
				console.log(url("api/api_users"))
				console.log(data)
				if(data.success){
					window.location.href = url("admin_table/tb_users.html")
				}
			})
			.catch(err => {
				console.log(err)
			})
	})
}
function showUser() {
	document.getElementById("myDropdown").classList.toggle("show");
}
$(function () {
	get_inf()
	forAdmin()
	loggedIndex();
	$("#login").on("click", function () {
		// console.log(window.location.pathname)
		if (window.location.pathname == "/") {
			window.location.href = "./html/login.html";
		} else {
			window.location.href = "../html/login.html";
		}
	});

	$("#signup").on("click", function () {
		if (window.location.pathname == "/") {
			window.location.href = "./html/signup.html";
		} else {
			window.location.href = "../html/signup.html";
		}
	});
	$('#dropbtn').on('click', function () {
		let dropdowns = $(".dropdown-content");
		for (let i = 0; i < dropdowns.length; i++) {
			let openDropdown = dropdowns[i];
			if (openDropdown.classList.contains('show')) {
				openDropdown.style.display = 'none';
			}
			else {
				openDropdown.style.display = 'block';
			}
		}
		showUser();
	});
	$('#search-btn').on('click', function () {
		let search = $('#search-input').val().trim();
		let regSearch = /^[\p{L}\d\s]+$/u
		if (!search.match(regSearch)) {
			search = ''
		}
		let songUrl = ''
		let tosongHTMLUrl = ''
		if (window.location.pathname.includes("/html/")) {
			songUrl = "../api/api_songs.php";
			tosongHTMLUrl = "../html/searchsongs.html"
			console.log("search, in html")
		} else {
			songUrl = "./api/api_songs.php";
			tosongHTMLUrl = "./html/searchsongs.html"
			console.log("search, in root")
		}
		let thongtin = {
			input: search,
			action: "search"
		}
		console.log(thongtin)
		fetch(songUrl, {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify(thongtin)
		})
			.then(res => res.json())
			.then((data) => {
				sessionStorage.setItem('dataSearch', JSON.stringify(data))
				console.log(data)
				console.log(JSON.stringify(sessionStorage.getItem('dataSearch')))
				window.location.href = tosongHTMLUrl
			})
			.catch(err => {
				console.log(err)
			})
	})
});


// sdfsadfsdf