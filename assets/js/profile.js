import * as root from "./root.js";
const editBtn = document.getElementById("edit-btn");
const saveBtn = document.getElementById("save-btn");
const username = document.getElementById("username");
const email = document.getElementById("email");
const password = document.getElementById("password");
const userForm = document.getElementById("user-form");

userForm.onsubmit = (e)=>{
    e.preventDefault();
    saveNewData();
}
window.onload = getInfo();
// Get User Info
function getInfo(){
    if(sessionStorage.getItem("user") && sessionStorage.getItem("token")){
    let user = JSON.parse(sessionStorage.getItem("user"));
    username.value = user['username'];
    email.value = user['email'];
    password.value = sessionStorage.getItem("password");
    }else{
        location.href = "./login.php";
    }
}

// Start Edit
editBtn.onclick = ()=>{
    username.removeAttribute("readonly");
    email.removeAttribute("readonly");
    password.removeAttribute("readonly");
    password.setAttribute("type","text");
    editBtn.style.display = 'none';
    saveBtn.style.display = 'block';
}

// Save New Data
function saveNewData(){
    let token =sessionStorage.getItem("token");
    
    fetch(root.api_url+"auth/update",{
        method : "PUT",
        headers : {
            "Content-Type":"application/json",
            "Authorization": "Bearer "+token
        },
        body:JSON.stringify({
            "username": username.value,
            "email": email.value,
            "password": password.value
        })
    }).then((res)=>res.json()).then((data)=>{
        root.Swal.fire({
            title : "Success",
            text: data['message'],
            icon: "success"
        }).then(()=>{location.reload()});
        
    }).catch(()=>{
        root.Swal.fire({
            title : "Error",
            text: "Try Again Later!!",
            icon: "error"
        }).then(()=>{location.href="./login.php"});
    })
}