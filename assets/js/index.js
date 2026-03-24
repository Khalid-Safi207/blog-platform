import * as root from "./root.js";
const loader = document.getElementById("loader");
const blogs = document.getElementById("blogs");


loader.style.display = 'block';
fetch(root.api_url + "post", {
    method: "GET",
    headers: {
        "Content-Type": "application/json",
        "Authorization": "Bearer " + sessionStorage.getItem("token")
    }
}).then((res) => res.json()).then((data) => {
    let posts = data['data'];
    if (data['status']) {
        blogs.innerHTML = "";
        posts.forEach(post => {
            blogs.innerHTML += `
        <div class="blog" data-post-id="${post.id}">
            <div class="blog-header">
                <h3 id="title">${post.title}</h3>
                <div id="author-name"><i class="fa-solid fa-user"></i><span>${post.username}</span></div>
            </div>
            <div class="blog-body">
                <p id="short-content">${post.content}</p>
            </div>
            <div class="blog-footer">
                <span id="views">${post.views} <i class="fa-solid fa-eye"></i></span>
                <a href="./post.php?id=${post.id}"><button class="read-more">Read More <i class="fa-solid fa-angle-right"></i></button></a>
            </div>
        </div>
        `;
        });
    } else {
        location.href = "./login.php";

    }

}).catch(() => {
    location.href = "./login.php";
})