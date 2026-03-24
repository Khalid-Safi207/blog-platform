<?php
require_once __DIR__.'/../models/Post.php';
require_once __DIR__.'/../middleware/AuthMiddleware.php';

class PostController {
    private $post;

    public function __construct()
 {
        $this->post = new Post();
    }

    public function readAllPosts() {
        $user = AuthMiddleware::check();
        $result = $this->post->getAllPosts();
        $this->sendResponse( $result );
    }

    public function readPostsByUserId( ) {
        $user = AuthMiddleware::check();
        $this->post->user_id = $user->user_id;
        $result = $this->post->getPostByUserId();
        $this->sendResponse( $result );
    }
    public function readOnePost($id){
        $user = AuthMiddleware::check();
        $this->post->id = $id;
        $result = $this->post->getPost();
        $this->sendResponse( $result );
    }
    public function createNewPost() {
        $data = json_decode( file_get_contents( 'php://input' ), true );
        $user = AuthMiddleware::check();
        $this->post->title = $data[ 'title' ];
        $this->post->content = $data[ 'content' ];
        $this->post->user_id = $user->user_id;
        $result = $this->post->createPost();
        $this->sendResponse( $result );
    }

    public function updatePost() {
        $data = json_decode( file_get_contents( 'php://input' ), true );
        $user = AuthMiddleware::check();
        $this->post->user_id = $user->user_id;
        $this->post->id = $data[ 'id' ];
        $this->post->title = $data[ 'title' ];
        $this->post->content = $data[ 'content' ];
        $result = $this->post->updatePost();
        $this->sendResponse( $result );
    }

    public function updateView() {
        $user = AuthMiddleware::check();
        $data = json_decode( file_get_contents( 'php://input' ), true );
        $this->post->id = $data[ 'id' ];
        $result = $this->post->updateView();
        $this->sendResponse( $result );
    }

    public function deletePost() {
        $user = AuthMiddleware::check();
        $data = json_decode( file_get_contents( 'php://input' ), true );
        $this->post->id = $data[ 'id' ];
        $this->post->user_id = $user->user_id;
        $result = $this->post->deletePost();
        $this->sendResponse( $result );
    }

    public function sendResponse( $response ) {
        header( 'Content-Type: application/json' );
        echo json_encode( $response );
        exit();
    }
}

?>