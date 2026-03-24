import * as root from "./root.js";
const loader = document.getElementById("loader");
const postTitle = document.getElementById("post-title");
const postContent = document.getElementById("post-content");
const editForm = document.getElementById("edit-form");
getPostId()
function getPostId() {
    if (location.search) {
        let id = location.search.slice(4);
        getPost(id);
    } else {
        location.href = "./index.php";
    }
}

editForm.onsubmit = (e) => {
    e.preventDefault();
    editPost();
}
loader.style.display = 'block';
function getPost(post_id) {
    fetch(root.api_url + 'onepost/' + post_id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem("token")
        }
    }).then((res) => res.json()).then((data) => {
        editForm.setAttribute("data-post-id", data['data']['id']);
        postTitle.value = data['data']['title'];
        postContent.value = data['data']['content'];
        loader.style.display = 'none';
    })
}

function editPost() {
    let post_id = editForm.getAttribute("data-post-id");
    fetch(root.api_url + "post", {
        method: "PUT",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem("token")
        },
        body: JSON.stringify({
            "id": post_id,
            "title": postTitle.value,
            "content": postContent.value
        })
    }).then((res) => res.json()).then((data) => {
        console.log(data);
        if (data['status']) {
            root.Swal.fire({
                title: "Success",
                text: data['message'],
                icon: "success"
            }).then(() => { location.href = "./post.php?id=" + post_id })
        } else {
            root.Swal.fire({
                title: "Error",
                text: data['message'],
                icon: "error"
            }).then(() => { location.href = "./post.php?id=" + post_id })
        }
    }).catch(() => { location.href = './index.php' })
}