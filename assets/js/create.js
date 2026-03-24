import * as root from "./root.js";
const createForm = document.getElementById("create-form");
const title = document.getElementById("post-title");
const content = document.getElementById("post-content");

createForm.onsubmit = (e)=>{
    e.preventDefault();
    createPost();
}
function createPost() {
    fetch(root.api_url + "post", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + sessionStorage.getItem("token")
        },
        body: JSON.stringify({
            "title": title.value,
            "content": content.value
        })
    }).then((res)=>res.json()).then((data)=>{
        if(data['status']){
            root.Swal.fire({
                title : "Success",
                text: data['message'],
                icon: "success"
            }).then(()=>{location.href = './index.php'});
        }
        
    }).catch(()=>{location.href = './index.php'});
}