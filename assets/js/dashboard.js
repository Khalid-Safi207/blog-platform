import * as root from "./root.js";
getUserData();

const loader = document.getElementById("loader");
loader.style.display = 'block';
// Get User Data
function getUserData() {
    fetch(root.api_url + "allposts/", {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem("token")
        }
    }).then((res) => res.json()).then((data) => {
        setData(data)
        loader.style.display = 'none';

    }).catch(() => { location.href = "./index.php" })
}

// Set Data
function setData(posts) {

    let data = posts;
    console.log(data);
    const allPosts = document.getElementById("all-posts");
    const totalPosts = document.getElementById("total-posts");
    const totalViews = document.getElementById("total-views");
    if (data['status'] == true) {
        totalPosts.innerHTML = '<i class="fa-solid fa-file-lines"></i>' + data['data'].length;
        let viewsCount = 0;
        allPosts.innerHTML = "";
        for (let i = 0; i < data['data'].length; i++) {
            viewsCount += data['data'][i]['views'];
            commentsCount(data['data'][i]['id']);
            allPosts.innerHTML += `
            <div class="post">
                <h4 id="title">${data["data"][i]['title'].slice(0, 40) + "..."}</h4>
                <p id="created-at">Published ${data["data"][i]['created_at']}</p>
                <div class="actions">
                    <a href="./post.php?id=${data['data'][i]['id']}"><button id="view">view</button></a>
                    <a href="./edit-post.php?id=${data['data'][i]['id']}"><button id="edit">edit</button></a>
                    <button id="delete" onclick="deletePost(${data["data"][i]['id']})">delete</button>
                </div>
            </div>
            `;
        }
        totalViews.innerHTML = '<i class="fa-solid fa-eye"></i>' + viewsCount;


    }
    if (data['status'] == false) {
        allPosts.innerHTML = "<h3>"+data['message']+"</h3>";
    }
}

// Get Comments Count
function commentsCount(post_id) {
    const totalComments = document.getElementById("total-comments");
    let counter = 0;
    fetch(root.api_url + "commentsCount/" + post_id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem("token")
        }
    }).then((res) => res.json()).then((data) => {
            counter = counter + data['data']['comment_count'];
            totalComments.innerHTML = '<i class="fa-solid fa-comment"></i>' + counter; 
    
    });
}


