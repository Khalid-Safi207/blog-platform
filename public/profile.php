<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
        <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
    <?php include "../includes/header.php"?>

        <!-- Start User Info Section-->
    <h1>Profile Details</h1>
    <form class="user-info" id="user-form">
        <div>
            <label for="username">Username</label>
            <input type="text" minlength="2" id="username" readonly required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" readonly required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" minlength="8" id="password" readonly required>
        </div>
        <button class="save-btn" id="save-btn">Save</button>
    </form>
    <button class="edit-btn" id="edit-btn">Edit</button>
    <!-- End User Info Section-->
     <script type="module" src="../assets/js/profile.js"></script>

</body>
</html>