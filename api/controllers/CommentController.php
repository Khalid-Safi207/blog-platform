<?php
require_once __DIR__.'/../models/Comment.php';
require_once __DIR__.'/../middleware/AuthMiddleware.php';

class CommentController {
    private $comment;

    public function __construct()
 {
        $this->comment = new Comment();
    }

    public function createComment() {
        $data = json_decode( file_get_contents( 'php://input' ), true );
        $user = AuthMiddleware::check();
        $this->comment->content = $data[ 'comment' ];
        $this->comment->post_id = $data[ 'post_id' ];
        $this->comment->user_id = $user->user_id;
        $result = $this->comment->addComment();
        $this->sendResponse( $result );
    }

    public function deleteComment( $id ) {
        $user = AuthMiddleware::check();
        $this->comment->id = $id;
        $this->comment->user_id = $user->user_id;
        $result = $this->comment->deleteComment();
        $this->sendResponse( $result );
    }

    public function getPostComments( $post_id ) {
        $user = AuthMiddleware::check();
        $this->comment->post_id = $post_id;
        $result = $this->comment->getPostComments();
        $this->sendResponse( $result );
    }
    public function getPostCommentsCount($post_id){
        $user = AuthMiddleware::check();
        $this->comment->post_id = $post_id;
        $result = $this->comment->getPostCommentsCount();
        $this->sendResponse( $result );
    }

    public function sendResponse( $response ) {
        header( 'Content-Type: application/json' );
        echo json_encode($response);
        exit();
    }
}
?>