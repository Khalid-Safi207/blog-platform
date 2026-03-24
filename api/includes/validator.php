<?php

class Validator {

    private $response = [
        'status'=>'',
        'data'=>'',
        'message'=> ''
    ];

    public function emailValidation( $email ) {
        $email = trim( $email );
        $email = strip_tags( $email );
        if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
            $this->response[ 'status' ] = true;
            $this->response[ 'data' ] = $email;
            return $this->response;
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = 'This email address is invalid.';
            return $this->response;
        }
    }

    public function usernameValidation( $username ) {
        $username = trim( $username );
        $username = strip_tags( $username );
        if ( !empty( $username ) && strlen( $username ) > 2 && strlen( $username ) < 16 ) {
            $this->response[ 'status' ] = true;
            $this->response[ 'data' ] = $username;
            return $this->response;
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = 'The username must be longer than 2 characters and shorter than 16 characters.';
            return $this->response;
        }
    }

    public function passwordValidation( $password ) {
        $password = trim( $password );
        $password = strip_tags( $password );
        if ( !empty( $password ) && strlen( $password ) >= 8 && strlen( $password ) <= 16 ) {
            if ( preg_match( '/[a-z]/', $password ) && preg_match( '/[A-Z]/', $password ) && preg_match( '/\d/', $password ) ) {
                $this->response[ 'status' ] = true;
                $this->response[ 'data' ] = $password;
                return $this->response;
            } else {
                $this->response[ 'status' ] = false;
                $this->response[ 'message' ] = 'The password must contain uppercase letters, lowercase letters, and numbers.';
                return $this->response;
            }
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = 'The password must be greater than or equal to 8 characters and less than or equal to 16 characters.';
            return $this->response;
        }

    }

    public function textValidation( $text ) {
        if (!empty($text)) {
            $text = trim( $text );
            $text = strip_tags( $text );
            $this->response[ 'status' ] = true;
            $this->response[ 'data' ] = $text;
            return $this->response;
        } else {
            $this->response[ 'status' ] = false;
            $this->response[ 'message' ] = 'The input cannot be left empty.';
            return $this->response;
        }
    }
}

?>