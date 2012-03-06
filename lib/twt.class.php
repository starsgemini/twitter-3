<?php
class Twt
{    
    function __construct($controller) {
        $this->currentPage = $controller;
        $this->preDispatch();

        $this->tmhOAuth = new tmhOAuth(array(
            'consumer_key' => config('consumer_key'),
            'consumer_secret' => config('consumer_secret')
        ));
    }

    function checkUser() {
        if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
            $this->user = ORM::for_table('twt_users')->where('id', $_COOKIE['id'])->find_one();

            $tempUser = new stdClass();
            $tempUser->handle = $this->user->handle;
            $tempUser->agent = substr($_SERVER['HTTP_USER_AGENT'], 0, 150);
            $tempUser->id = $_COOKIE['id'];
            $this->generateUserHash($tempUser);

            if ( ($tempUser->sess_hash == $this->user->sess_hash ) && ( $this->user->sess_hash == $_COOKIE['hash']) ) {
                return true;
            }
        }
        //echo 'false'; die();
        return false;
    }

    function preDispatch() {
        $allowed_pages = array('login');
        if (in_array($this->currentPage, $allowed_pages)){
            return true;
        } else if (!$this->checkUser()) {
            header('Location: '.config('base_path').'login');
        }

    }

    function updateUser()
        {
            $this->user->agent = substr($_SERVER['HTTP_USER_AGENT'], 0, 150);
            $this->generateUserHash($this->user);
            $this->user->save();

            setcookie('id', $this->user->id, config('cookie_expiry'), '/');
            setcookie('hash', $this->user->sess_hash, config('cookie_expiry'), '/');
    }

    function generateUserHash($user) {
        $user->sess_hash = sha1($user->handle.$user->agent.config('salt').$user->id);
    }

    function showError($err) {
        echo $err;
        die();
    }
}
