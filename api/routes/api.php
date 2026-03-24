<?php
require_once __DIR__.'/../controllers/AuthController.php';
require_once __DIR__.'/../controllers/PostController.php';
require_once __DIR__.'/../controllers/CommentController.php';

$auth_controller = new AuthController();
$post_controller = new PostController();
$comment_controller = new CommentController();

$uri = parse_url( $_SERVER[ 'REQUEST_URI' ], PHP_URL_PATH );
$uri_parts = explode( '/', trim( $uri, '/' ) );

if ( $uri_parts[ 0 ] === 'blog_platform' ) {
    array_shift( $uri_parts );
}

$method = $_SERVER[ 'REQUEST_METHOD' ];

if ( isset( $uri_parts[ 0 ] ) && $uri_parts[ 0 ] == 'api' ) {
    if ( isset( $uri_parts[ 1 ] ) && $uri_parts[ 1 ] == 'auth' ) {
        if ( isset( $uri_parts[ 2 ] ) && $uri_parts[ 2 ] == 'register' ) {

            switch( $method ) {
                case 'POST':
                $auth_controller->register();
                break;
            }
        }
        if ( isset( $uri_parts[ 2 ] ) && $uri_parts[ 2 ] == 'login' ) {

            switch( $method ) {
                case 'POST':
                $auth_controller->login();
                break;
            }
        }
        if ( isset( $uri_parts[ 2 ] ) && $uri_parts[ 2 ] == 'update' ) {

            switch( $method ) {
                case 'PUT':
                $auth_controller->update();
                break;
            }
        }
    }
    if ( isset( $uri_parts[ 1 ] ) && $uri_parts[ 1 ] == 'post' ) {
        $id = isset( $uri_parts[ 2 ] ) ? ( int )$uri_parts[ 2 ] : null;

        switch( $method ) {
            case 'GET':
              $post_controller->readAllPosts();
            break;

            case 'POST':
            $post_controller->createNewPost();
            break;

            case 'PUT':
            $post_controller->updatePost();
            break;

            case 'PATCH':
            $post_controller->updateView();
            break;

            case 'DELETE':
            $post_controller->deletePost();
            break;

        }
    }

    if ( isset( $uri_parts[ 1 ] ) && $uri_parts[ 1 ] == 'comment' ) {
        $id = isset( $uri_parts[ 2 ] ) ? ( int )$uri_parts[ 2 ] : null;
        switch( $method ) {
            case 'POST':
            $comment_controller->createComment();
            break;
            case 'GET':
            $comment_controller->getPostComments( $id );
            break;
            case 'DELETE':
            $comment_controller->deleteComment( $id );
            break;
        }
    }

    if ( isset( $uri_parts[ 1 ] ) && $uri_parts[ 1 ] == 'onepost' ) {
        $id = isset( $uri_parts[ 2 ] ) ? ( int )$uri_parts[ 2 ] : null;
        if ( $method == 'GET' ) {
            $post_controller->readOnePost( $id );

        }
    }
    if(isset( $uri_parts[ 1 ] ) && $uri_parts[ 1 ] == 'allposts'){
        if($method == "GET"){
            $post_controller->readPostsByUserId();
        }
    }
    if(isset( $uri_parts[ 1 ] ) && $uri_parts[ 1 ] == 'commentsCount'){
        $id = isset( $uri_parts[ 2 ] ) ? ( int )$uri_parts[ 2 ] : null;
        if($method == "GET"){
                $comment_controller->getPostCommentsCount($id);
        }
    }
}

?>
