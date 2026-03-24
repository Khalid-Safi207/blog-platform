<!DOCTYPE html>
<html>
<head>
<title>Register</title>
    <!-- Custom CSS -->
     <link rel="stylesheet" href="../assets/css/auth.css">
     <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div class="box">
    <h2>Register</h2>
    <form id="register-form">
        <div class="input-box">
            <input type="text" placeholder="Username" id="username" required>
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="input-box">
            <input type="email" placeholder="Email" id="email" required>
            <i class="fa-solid fa-at"></i>
        </div>
        <div class="input-box">
            <input type="password" minlength="8" placeholder="Password" id="password" required>
            <i class="fa-solid fa-lock"></i>
        </div>
        <div class="input-box">
            <input type="password" minlength="8" placeholder="Password Again" id="password-again" required>
            <i class="fa-solid fa-lock"></i>
        </div>
        <a href="./login.php">I already have an account. Login</a>
        <button>Register</button>
    </form>
</div>

<script type="module" src="../assets/js/register.js"></script>
</body>
</html>