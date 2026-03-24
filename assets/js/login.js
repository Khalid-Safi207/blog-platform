import * as root from "./root.js";
const email = document.getElementById("email");
const password = document.getElementById("password");
const loginForm = document.getElementById("login-form");

loginForm.onsubmit = (e) => {
    e.preventDefault();
    login();
}
function login() {
    fetch(root.api_url + "auth/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "email": email.value,
            "password": password.value
        })
    }).then((res) => res.json()).then((data) => {
        console.log(data);
        if (data["user"]) {
            sessionStorage.setItem("user", JSON.stringify(data['user']));
            sessionStorage.setItem("token", data['token']);
            sessionStorage.setItem("password", password.value);
            root.Swal.fire({
                title: "Success",
                text: "You Are Welcome " + data['user']['username'],
                icon: "success"
            }).then(() => { location.href = "./index.php" })
        }else{
            root.Swal.fire({
            title: "Error",
            text: data['message'],
            icon: "error"
        })
        }
    }).catch(() => {
        root.Swal.fire({
            title: "Error",
            text: "Try Again Later!!",
            icon: "Error"
        }).then(() => { location.href = "./index.php" })
    })

}