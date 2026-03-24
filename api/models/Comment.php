<?php
// Include Database File
require_once __DIR__.'/../config/database.php';
// Include Validation File
require_once __DIR__.'/../includes/validator.php';

class Comment {

    private $response = [
        'status' => null,
        'data' => null,
        'message' => null
    ];
    private $db;
    private $validation;
    public $id;
    public $content;
    public $user_id;
    public $post_id;

    public function __construct()
 {
        $this->db = ( new Database() )->connect_db();
        $this->validation = new Validator();

    }

    public function addComment() {
        if ( $this->validation->textValidation( $this->content )[ 'status' ] ) {
            $this->content = $this->validation->textValidation( $this->content )[ 'data' ];
            $stmt = $this->db->prepare( 'INSERT INTO comments(comment, user_id, post_id) VALUES(:comment, :user_id, :post_id)' );
            $stmt->bindParam( ':comment', $this->content );
            $stmt->bindParam( ':user_id', $this->user_id );
            $stmt->bindParam( ':post_id', $this->post_id );
            if ( $stmt->execute() ) {
                $this->response[ 'status' ] = true;
                $this->response[ 'message' ] = 'The comment was added successfully.';
                return $this->response;
            } else {
                $this->response[ 'status' ] = false;
                $this->response[ 'message' ] = 'Try again later.';
                return $this->response;
            }
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = $this->validation->textValidation( $this->content )[ 'message' ];
            return $this->response;
        }
    }

    public function deleteComment() {
        $stmt = $this->db->prepare( 'DELETE FROM comments WHERE id = :id AND user_id = :user_id' );
        $stmt->bindParam( ':id', $this->id );
        $stmt->bindParam( ':user_id', $this->user_id );
        if ( $stmt->execute() ) {
            $this->response[ 'status' ] = true;
            $this->response[ 'message' ] = 'Deleted Successfuly!!!';
            return $this->response;
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = 'Try again later.';
            return $this->response;
        }
    }

    public function getPostComments() {
        $stmt = $this->db->prepare( 'SELECT comments.* , users.username FROM comments LEFT JOIN users ON users.id = comments.user_id WHERE comments.post_id = :post_id' );
        $stmt->bindParam( ':post_id', $this->post_id );
        if ( $stmt->execute() ) {
            $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
            $this->response[ 'status' ] = true;
            $this->response[ 'data' ] = $result;
            return $this->response;
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = 'Try again later.';
            return $this->response;
        }
    }

    public function getPostCommentsCount() {
        $stmt = $this->db->prepare( 'SELECT COUNT(*) as comment_count FROM comments WHERE comments.post_id = :post_id;' );
        $stmt->bindParam( ':post_id', $this->post_id );
        if ( $stmt->execute() ) {
            $result = $stmt->fetch( PDO::FETCH_ASSOC );
            if ( is_array( $result ) ) {
                $this->response[ 'status' ] = true;
                $this->response[ 'data' ] = $result;
                return $this->response;
            } else {
                $this->response[ 'status' ] = false;
                $this->response[ 'message' ] = 'Not Found!';
                return $this->response;

            }
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = 'Try Again Later!';
            return $this->response;

        }
    }
}

?>