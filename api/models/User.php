<?php
// Include Database File
require_once __DIR__.'/../config/database.php';
// Include Validation File
require_once __DIR__.'/../includes/validator.php';

class User {
    private $db;
    private $validation;

    private $response = [
        'status'=>null,
        'data'=>null,
        'message'=> null
    ];
    public $id;
    public $username;
    public $email;
    public $password;

    public function __construct()
 {
        $this->db = ( new Database() )->connect_db();
        $this->validation = new Validator();
    }

    public function createUser() {
        if ( $this->validation->usernameValidation( $this->username )[ 'status' ] ) {
            if ( $this->validation->emailValidation( $this->email )[ 'status' ] ) {
                if ( $this->validation->passwordValidation( $this->password )[ 'status' ] ) {

                    $this->username = $this->validation->usernameValidation( $this->username )[ 'data' ];
                    $this->email = $this->validation->emailValidation( $this->email )[ 'data' ];
                    $this->password = $this->validation->passwordValidation( $this->password )[ 'data' ];

                    $this->password = password_hash( $this->password, PASSWORD_DEFAULT );
                    $stmt = $this->db->prepare( 'INSERT INTO users(username, email, password) VALUES(:username, :email, :password)' );
                    $stmt->bindParam( ':username', $this->username );
                    $stmt->bindParam( ':email', $this->email );
                    $stmt->bindParam( ':password', $this->password );
                    if ( $stmt->execute() ) {
                        $this->response[ 'status' ] = true;
                        $this->response[ 'message' ] = 'New user information has been successfully saved.';
                        return $this->response;
                    } else {
                        $this->response[ 'status' ] = false;
                        $this->response[ 'message' ] = "The new user's information has not been saved. Please try again later.";
                        return $this->response;
                    }
                } else {
                    $this->response[ 'status' ] = false;
                    $this->response[ 'message' ] = $this->validation->passwordValidation( $this->password )[ 'message' ];
                    return $this->response;
                }

            } else {
                $this->response[ 'status' ] = false;
                $this->response[ 'message' ] = $this->validation->emailValidation( $this->email )[ 'message' ];
                return $this->response;
            }

        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = $this->validation->usernameValidation( $this->username )[ 'message' ];
            return $this->response;
        }
    }

    public function findUserByEmail() {
        if ( $this->validation->emailValidation( $this->email )[ 'status' ] ) {
            $this->email = $this->validation->emailValidation( $this->email )[ 'data' ];
            $stmt = $this->db->prepare( 'SELECT email, password FROM users WHERE email = :email' );
            $stmt->bindParam( ':email', $this->email );
            if ( $stmt->execute() ) {
                $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
                if ( count( $result ) == 0 ) {
                    $this->response[ 'status' ] = true;
                    $this->response[ 'message' ] = 'This email address is not being used by anyone.';
                    return $this->response;
                } else {
                    $this->response[ 'status' ] = false;
                    $this->response[ 'message' ] = 'This email address has already been used.';
                    return $this->response;
                }
            } else {
                $this->response[ 'status' ] = false;
                $this->response[ 'message' ] = 'Error In Execution Code';
                return $this->response;
            }
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = $this->validation->emailValidation( $this->email )[ 'message' ];
            return $this->response;
        }

    }

    public function getUser() {
        if ( $this->validation->emailValidation( $this->email )[ 'status' ] ) {
            if ( $this->validation->passwordValidation( $this->password )[ 'status' ] ) {

                $this->email = $this->validation->emailValidation( $this->email )[ 'data' ];
                $this->password = $this->validation->passwordValidation( $this->password )[ 'data' ];

                $stmt = $this->db->prepare( 'SELECT id, username, email, password FROM users WHERE email= :email' );
                $stmt->bindParam( ':email', $this->email );

                if ( $stmt->execute() ) {
                    $result = $stmt->fetch( PDO::FETCH_ASSOC );

                    if ( !$result ) {
                        $this->response[ 'status' ] = false;
                        $this->response[ 'message' ] = 'User not found.';
                        return $this->response;
                    }

                    if ( password_verify( $this->password, $result[ 'password' ] ) ) {
                        $this->response[ 'status' ] = true;
                        $this->response[ 'data' ] = $result;
                        $this->response[ 'message' ] = 'Login successful.';
                        return $this->response;
                    } else {
                        $this->response[ 'status' ] = false;
                        $this->response[ 'message' ] = 'The password or email address is incorrect.';
                        return $this->response;
                    }
                } else {
                    $this->response[ 'status' ] = false;
                    $this->response[ 'message' ] = 'The password or email address is incorrect.';
                    return $this->response;
                }
            } else {
                $this->response[ 'status' ] = false;
                $this->response[ 'message' ] = $this->validation->passwordValidation( $this->password )[ 'message' ];
                return $this->response;
            }

        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = $this->validation->emailValidation( $this->email )[ 'message' ];
            return $this->response;
        }
    }

    public function updateUser() {
        if ( $this->validation->emailValidation( $this->email )[ 'status' ] ) {
            if ( $this->validation->passwordValidation( $this->password )[ 'status' ] ) {
                if ( $this->validation->textValidation( $this->username )[ 'status' ] ) {
                    $stmt = $this->db->prepare( 'UPDATE users SET username = :username, email = :email, password = :password WHERE id = :user_id' );
                    $stmt->bindParam( ':username', $this->username );
                    $stmt->bindParam( ':email', $this->email );
                    $hashed_password = password_hash( $this->password, PASSWORD_DEFAULT );
                    $stmt->bindParam( ':password', $hashed_password );
                    $stmt->bindParam( ':user_id', $this->id );
                    if ( $stmt->execute() ) {
                        $this->response[ 'status' ] = true;
                        $this->response[ 'message' ] = 'Your information has been updated.';
                        return $this->response;
                    } else {
                        $this->response[ 'status' ] = false;
                        $this->response[ 'message' ] = 'Your information has not been updated.';
                        return $this->response;
                    }
                } else {
                    $this->response[ 'status' ] = false;
                    $this->response[ 'message' ] = $this->validation->textValidation( $this->username )[ 'message' ];
                    return $this->response;
                }
            } else {
                $this->response[ 'status' ] = false;
                $this->response[ 'message' ] = $this->validation->passwordValidation( $this->password )[ 'message' ];
                return $this->response;
            }
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = $this->validation->emailValidation( $this->email )[ 'message' ];
            return $this->response;
        }
    }

}

?>