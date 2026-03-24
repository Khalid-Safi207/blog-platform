<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/create.css">
</head>
<body>
        <?php include "../includes/header.php"?>

     <!-- Start Create Container -->
    <div class="container">
        <h1>Create Post</h1>
        <form id="create-form">
            <div>
                <label for="post-title">Post Title</label>
                <input type="text" id="post-title" required>
            </div>
            <div>
                <label for="post-content">Post Content</label>
                <textarea id="post-content" required></textarea>
            </div>
            <button type="submit" id="publish-btn">Publish Post</button>
        </form>
    </div>
     <!-- End Create Container -->
    <script type="module" src="../assets/js/create.js"></script>
</body>
</html>