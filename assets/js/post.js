import * as root from "./root.js";
const title = document.querySelectorAll(".title");
const createdAt = document.getElementById("created-at");
const author = document.getElementById("author");
const content = document.getElementById("content");
const loader = document.getElementById("loader");
const comments = document.getElementById("comments");
const newCommentForm = document.getElementById("new-comment-form");
const newCommentInp = document.getElementById("comment-input");
loader.style.display = 'block';


newCommentForm.onsubmit = (e) => {
    e.preventDefault();
    newComment();
}

getPostId()
function getPostId() {
    if (location.search) {
        let id = location.search.slice(4);
        getPost(id);
    } else {
        location.href = "./index.php";
    }
}

function getPost(id) {
    fetch(root.api_url + 'onepost/' + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem("token")
        }
    }).then((res) => res.json()).then((data) => {
        
        if (data['status']) {
            let post = data["data"];
            title.forEach((el) => {
                el.innerHTML = post.title;
            })
            createdAt.innerHTML = post['created_at'];
            author.innerHTML = post['username'];
            content.innerHTML = post['content'];
            getComments(post['id'])
            loader.style.display = 'none';

        }

    }).catch(() => { location.href = './index.php' });
}

function getComments(id) {
    fetch(root.api_url + "comment/" + id, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem("token")
        }
    }).then((res) => res.json()).then((data) => {
        
        let commentsData = data['data'];
        commentsData.forEach(comment => {
            let username = '';
            if (comment['user_id'] == JSON.parse(sessionStorage.getItem("user"))['id']) {
                username = comment['username'] + '<button class="deleteComment" onclick="deleteComment('+comment['id']+')">Delete Comment</button>'

            } else {
                username = comment['username'];
            }
            comments.innerHTML += `
            <div class="comment">
                <i class="fa-solid fa-user"></i>
                <div class="comment-details">
                    <span id="comment-author">${username}</span>
                    <span id="comment-created-at">Posted ${comment['created_at']}</span>
                    <span id="comment-content">${comment['comment']}</span>
                </div>
            </div> 
            `
        });
    })
}

function newComment() {
    let commentInpValue = newCommentInp.value;
    if (commentInpValue.length > 0) {
        fetch(root.api_url + "comment", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + sessionStorage.getItem("token")
            },
            body: JSON.stringify({
                "comment": commentInpValue,
                "post_id": location.search.slice(4)
            })
        }).then((res) => res.json()).then((data) => {
            if (data['status']) {
                root.Swal.fire({
                    title: "Success",
                    text: data['Message'],
                    icon: "success"
                }).then(() => { location.reload() })
            } else {
                root.Swal.fire({
                    title: "Error",
                    text: data['Message'],
                    icon: "error"
                }).then(() => { location.reload() })
            }

        }).catch(() => { location.reload() })
    }
}

function viewCalc(){
    fetch(root.api_url+"post",{
        method: "PATCH",
        headers:{
            "Content-Type": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem("token")
        },
        body: JSON.stringify({
            "id": location.search.slice(4)
        })
    })
}

setTimeout(viewCalc,10000);



