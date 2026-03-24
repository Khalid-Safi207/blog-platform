<?php
// Include Database File
require_once __DIR__.'/../config/database.php';
// Include Validation File
require_once __DIR__.'/../includes/validator.php';

class Post {
    private $response = [
        'status' => null,
        'data' => null,
        'message' => null
    ];
    private $db;
    private $validation;

    public $id;
    public $user_id;
    public $title;
    public $content;
    public $views;

    public function __construct()
 {
        $this->db = ( new Database() )->connect_db();
        $this->validation = new Validator();

    }

    public function getAllPosts() {
        $stmt = $this->db->prepare( 'SELECT users.username, posts.id, title, content, user_id, views FROM posts LEFT JOIN users ON posts.user_id = users.id' );
        if ( $stmt->execute() ) {
            $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
            $this->response[ 'status' ] = true;
            $this->response[ 'data' ] = $result;
            $this->response[ 'message' ] = 'These are all the posts.';
            return $this->response;
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'data' ] = null;
            $this->response[ 'message' ] = 'The posts could not be retrieved, please try again later.';
            return $this->response;
        }
    }

    public function getPost() {
        $stmt = $this->db->prepare( 'SELECT users.username, posts.* FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.id = :post_id' );
        $stmt->bindParam( ':post_id', $this->id );
        $stmt->execute();
        $result = $stmt->fetch( PDO::FETCH_ASSOC );
        if ( is_array( $result ) ) {
            $this->response[ 'status' ] = true;
            $this->response[ 'data' ] = $result;
            return $this->response;
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = 'Not Found';
            return $this->response;
        }
    }

    public function getPostByUserId() {
        $stmt = $this->db->prepare( 'SELECT id, title, content, user_id, views, created_at FROM posts WHERE user_id = :user_id' );
        $stmt->bindParam( ':user_id', $this->user_id );
        if ( $stmt->execute() ) {
            $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
            if ( count( $result ) > 0 ) {
                $this->response[ 'status' ] = true;
                $this->response[ 'data' ] = $result;
                $this->response[ 'message' ] = 'These are all the posts.';
                return $this->response;
            } else {
                $this->response[ 'status' ] = false;
                $this->response[ 'data' ] = null;
                $this->response[ 'message' ] = 'Not Found.';
                return $this->response;
            }
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'data' ] = null;
            $this->response[ 'message' ] = 'The posts could not be retrieved, please try again later.';
            return $this->response;
        }
    }

    public function createPost() {
        $title_status = $this->validation->textValidation( $this->title )[ 'status' ];
        $content_status = $this->validation->textValidation( $this->content )[ 'status' ];
        if ( $title_status ) {
            if ( $content_status ) {
                $this->title = $this->validation->textValidation( $this->title )[ 'data' ];
                $this->content = $this->validation->textValidation( $this->content )[ 'data' ];

                $stmt = $this->db->prepare( 'INSERT INTO posts(title, content, user_id) VALUES(:title, :content, :user_id)' );
                $stmt->bindParam( ':title', $this->title );
                $stmt->bindParam( ':content', $this->content );
                $stmt->bindParam( ':user_id', $this->user_id );
                if ( $stmt->execute() ) {
                    $this->response[ 'status' ] = true;
                    $this->response[ 'message' ] = 'The new post has been successfully created!';
                    return $this->response;
                } else {
                    $this->response[ 'status' ] = false;
                    $this->response[ 'message' ] = 'The new post was not Successfuly Created!';
                    return $this->response;
                }
            } else {
                $this->response[ 'status' ] = false;
                $this->response[ 'message' ] = $this->validation->textValidation( $this->content )[ 'message' ];
                return $this->response;

            }
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = $this->validation->textValidation( $this->title )[ 'message' ];
            return $this->response;

        }
    }

    public function updatePost() {
        $stmt = $this->db->prepare( 'SELECT user_id FROM posts WHERE id= :id' );
        $stmt->bindParam( ':id', $this->id );
        $stmt->execute();
        $result = $stmt->fetch( PDO::FETCH_ASSOC );
        if ( $result[ 'user_id' ] == $this->user_id ) {
            $title_status = $this->validation->textValidation( $this->title )[ 'status' ];
            $content_status = $this->validation->textValidation( $this->content )[ 'status' ];
            if ( $title_status ) {
                if ( $content_status ) {
                    $this->title = $this->validation->textValidation( $this->title )[ 'data' ];
                    $this->content = $this->validation->textValidation( $this->content )[ 'data' ];

                    $stmt = $this->db->prepare( 'UPDATE posts SET title= :title, content= :content WHERE id= :id AND user_id = :user_id' );
                    $stmt->bindParam( ':id', $this->id );
                    $stmt->bindParam( ':user_id', $this->user_id );
                    $stmt->bindParam( ':title', $this->title );
                    $stmt->bindParam( ':content', $this->content );
                    if ( $stmt->execute() ) {
                        $this->response[ 'status' ] = true;
                        $this->response[ 'message' ] = 'The post has been successfully edited!';
                        return $this->response;
                    } else {
                        $this->response[ 'status' ] = false;
                        $this->response[ 'message' ] = 'The post was not successfully edited!';
                        return $this->response;
                    }
                } else {
                    $this->response[ 'status' ] = false;
                    $this->response[ 'message' ] = $this->validation->textValidation( $this->content )[ 'message' ];
                    return $this->response;

                }

            } else {
                $this->response[ 'status' ] = false;
                $this->response[ 'message' ] = $this->validation->textValidation( $this->title )[ 'message' ];
                return $this->response;

            }
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = 'Forbidden!!';
            return $this->response;
        }
    }

    public function updateView() {
        $stmt = $this->db->prepare( 'UPDATE posts SET views = views + 1 WHERE id= :id' );
        $stmt->bindParam( ':id', $this->id );
        if ( $stmt->execute() ) {
            $this->response[ 'status' ] = true;
            return $this->response;
        }
    }

    public function deletePost() {
        $stmt = $this->db->prepare( 'SELECT user_id FROM posts WHERE id= :id' );
        $stmt->bindParam( ':id', $this->id );
        $stmt->execute();
        $result = $stmt->fetch( PDO::FETCH_ASSOC );
        if ( $result[ 'user_id' ] == $this->user_id ) {
            $stmt = $this->db->prepare( 'DELETE FROM posts WHERE id= :id' );
            $stmt->bindParam( ':id', $this->id );
            if ( $stmt->execute() ) {
                $this->response[ 'status' ] = true;
                $this->response[ 'message' ] = 'The post has been successfully deleted!';
                return $this->response;
            } else {
                $this->response[ 'status' ] = false;
                $this->response[ 'message' ] = 'The post was not successfully deleted!';
                return $this->response;
            }

        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = 'Forbidden!!';
            return $this->response;
        }
    }

}

?>
