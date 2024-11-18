function get_inf(){
    fetch('../api/api_albums.php')
    .then(res => res.json())
    .then((data) => {
        if(data.success){
            let ls=$("#table-body")
            ls.find("tr").remove()
            for (let i=0;i<data.data.length;i++){
                card=  `<tr>
                            <td>${data.data[i].album_id}</td>
                            <td>${data.data[i].album_title}</td>
                            <td>${data.data[i].artist_name}</td>
                            <td>${data.data[i].release_date}</td>
                            <td>
                                <a href="#">Edit</a>  |  <a href="#" onclick="confirmRemoval()">Delete</a>
                            </td>
                        </tr>`
                ls.append(card)
            }
        }
    })
    .catch(err => console.error(err))
}