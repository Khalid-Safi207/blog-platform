<?php
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../services/JWTService.php';

class AuthController {
    private $user;
    private $jwt;
    private $secret;

    public function __construct()
 {

        $this->user = new User();
        $this->jwt = new JWTService();
    }

    public function register() {
        $data = json_decode( file_get_contents( 'php://input' ), true );
        $this->user->username = $data[ 'username' ];
        $this->user->email = $data[ 'email' ];
        $this->user->password = $data[ 'password' ];
        if ( $this->user->findUserByEmail()[ 'status' ] ) {
            $result = $this->user->createUser();
            $this->sendResponse( $result );
        } else {
            $this->sendResponse( $this->user->findUserByEmail() );
        }
    }

    public function login() {
        $data = json_decode( file_get_contents( 'php://input' ), true );
        $this->user->email = $data[ 'email' ];
        $this->user->password = $data[ 'password' ];
        if ( !$this->user->findUserByEmail()[ 'status' ] ) {
            $result = $this->user->getUser();
            if ( is_array( $result[ 'data' ] ) ) {
                $token = $this->jwt->generateToken( $result[ 'data' ][ 'id' ] );
                $this->sendResponse( [ 'user'=>$result[ 'data' ], 'token'=> $token ] );
            } else {
                $this->sendResponse( $result = $this->user->getUser() );

            }
        } else {
            $this->sendResponse( ['status'=>false , "message"=>"This email address is not being used by anyone."]  );
        }
    }

    public function update(){
        $user = AuthMiddleware::check();
        $data = json_decode( file_get_contents( 'php://input' ), true );
        $this->user->username = $data['username'];
        $this->user->email = $data['email'];
        $this->user->password = $data['password'];
        $this->user->id = $user->user_id;
        $result = $this->user->updateUser();
        $this->sendResponse($result);
    }


    public function sendResponse( $response ) {
        header( 'Content-Type: application/json' );
        echo json_encode( $response );
        exit();
    }
}

?>