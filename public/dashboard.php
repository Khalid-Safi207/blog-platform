<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
    <?php include "../includes/header.php"?>
    <div class="loader" id="loader"></div>
    <!-- Start Statistics Section -->
    <section class="statistics">
        <h1>Dashboard</h1>
        <div class="boxs">
            <div class="posts-box">
                <span id="total-posts">0</span>
                <span>Total Posts</span>
            </div>
            <div class="comments-box">
                <span id="total-comments">0</span>
                <span>Comments</span>
            </div>
            <div class="views-box">
                <span id="total-views">0</span>
                <span>Views</span>
            </div>
        </div>
    </section>
    <!-- End Statistics Section -->
    <!-- Start Recent Posts Section -->
    <section class="recent-posts">
        <h3>Recent Posts</h3>
        <div class="all-posts" id="all-posts">
            
        </div>
    </section>
    <!-- End Recent Posts Section -->
    <!-- SweetAlert -->
    <script type="module" src="../assets/js/dashboard.js"></script>
    <script>

        // Delete Post 
        function deletePost(post_id) {
            console.log(post_id);
            if(confirm("Do you want to delete the post?")){
                fetch("../api/post/",{
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": "Bearer " + sessionStorage.getItem("token")
                    },
                    body: JSON.stringify({
                        'id': post_id
                    })
                }).then(()=>{location.reload()});
            }
        }
        </script>

</body>

</html>