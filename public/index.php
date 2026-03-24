<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Platform</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/index.css">
</head>

<body>
    <?php include "../includes/header.php"?>
     <!-- Start Hero Section -->
      <section class="hero">
        <h1>Welcome to Our Blog!</h1>
        <p>Explore the latest articles, ideas, and stories shared by our community.</p>
      </section>
     <!-- End Hero Section -->
    
     <section class="blogs" id="blogs">
        <div class="loader" id="loader"></div> 
       
     </section>
     <a href="./create-post.php"><button class="create-btn">Create Post <i class="fa-solid fa-plus"></i></button></a>

     <script type="module" src="../assets/js/index.js"></script>
</body>

</html>