import * as root from "./root.js";
const registerForm = document.getElementById("register-form");
const username = document.getElementById("username");
const email = document.getElementById("email");
const password = document.getElementById("password");
const passwordAgain = document.getElementById("password-again");

registerForm.onsubmit = (e) => {
    e.preventDefault();
    register();
}
function register() {
    if (password.value == passwordAgain.value) {
        fetch(root.api_url + "auth/register", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "username": username.value,
                "email": email.value,
                "password": password.value,
            })
        }).then((res) => res.json()).then((data) => {
            if (data['status']) {
                root.Swal.fire({
                    title: "Success",
                    text: data['message'],
                    icon: "success"
                }).then(() => {
                    location.href = "./login.php";
                });
            } else {
                root.Swal.fire({
                    title: "Error",
                    text: data['message'],
                    icon: "error"
                }).then(() => {
                    location.reload();
                });
            }
        })
    } else {
        root.Swal.fire({
            title: "Error",
            text: "Please enter identical values ​​in the password.",
            icon: "error"
        }).then(() => {
            location.reload();
        });
    }
}