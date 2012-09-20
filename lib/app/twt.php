<?php
namespace App;
use Idiorm\ORM as ORM;

class Twt
{    
    function __construct($controller) {
        $this->tmhOAuth = new \tmh\tmhOAuth(array(
            'consumer_key' => config('consumer_key'),
            'consumer_secret' => config('consumer_secret')
        ));

        $this->currentPage = $controller;
        $this->preDispatch();

        //TODO: grab this from user options
        date_default_timezone_set('Asia/Colombo');
    }

    function checkUser() {
        if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
            $this->user = ORM::for_table('twt_users')->where('id', $_COOKIE['id'])->find_one();

            $tempUser = new \stdClass();
            $tempUser->handle = $this->user->handle;
            $tempUser->agent = substr($_SERVER['HTTP_USER_AGENT'], 0, 150);
            $tempUser->id = $_COOKIE['id'];
            $this->generateUserHash($tempUser);

            if ( ($tempUser->sess_hash == $this->user->sess_hash ) && ( $this->user->sess_hash == $_COOKIE['hash']) ) {
                $this->tmhOAuth->config['user_token'] = $this->user->token;
                $this->tmhOAuth->config['user_secret'] = $this->user->secret;
                return true;
            }
        }

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
        $errors = config('ERRORS');
        if ( isset($errors[$err]) ) {
            echo $errors[$err];
        } else {
            echo $err;
        }

        die();
    }

    function getRequestLimit() {
        $code = $this->tmhOAuth->request('GET', $this->tmhOAuth->url('1/account/rate_limit_status'), array(
        ));

        if ($code == 200) {
            $rate = json_decode($this->tmhOAuth->response['response'], true);
            return $rate;
        } else {
            return false;
        }
    }

    //data[pageTitle] is html page title
    function render($data, $layout = 'default') {
        if (is_array($data)) {
            extract($data);
        }

        $rate_data = $this->getRequestLimit();

        include('templates/common/header.php');
        if (file_exists('templates/'.$layout.'.php')) {
            include('templates/'.$layout.'.php');
        }
        include('templates/common/footer.php');
    }
}
