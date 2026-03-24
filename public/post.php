<?php
if (!isset($_GET['id'])) {
    header("location: ./index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="title">Post</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/post.css">
</head>

<body>

    <?php include "../includes/header.php" ?>
    <div class="loader" id="loader"></div>
    <!-- Start Post Section-->
    <section class="post">
        <h1 class="title"></h1>
        <span>Published <span id="created-at"></span> by <span id="author"></span></span>
        <p id="content">

        </p>
    </section>
    <!-- End Post Section -->
    <!-- Start Comment Section -->
    <section class="container">
        <div class="comments" id="comments">
            <h3>Comments</h3>



        </div>
        <div class="new-comment">
            <h4>Leave a Comment</h4>
            <form id="new-comment-form">
                <textarea id="comment-input" placeholder="Comment..." required></textarea>
                <button id="submit-comment-btn">Submit Comment</button>
            </form>
        </div>
    </section>
    <!-- End Comment Section -->

    <script type="module" src="../assets/js/post.js"></script>
    <script>
        function deleteComment(id) {
            if(confirm("Do you want to Delete the comment?")){
            fetch("../api/comment/"+id,{
                method: "DELETE",
                headers : {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer " + sessionStorage.getItem("token")
                    
                }
            }).then((res)=>res.json()).then((data)=>{
              location.reload();
                
            })
        }
}
        </script>
</body>

</html>