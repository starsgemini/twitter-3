<?php
namespace App;
use Idiorm\ORM as ORM;

class login extends Twt
{
    function index()
    {
        $callback = 'http://twitter.local/login/auth';
        $params = array(
            'oauth_callback' => $callback
        );

        $code = $this->tmhOAuth->request('POST', $this->tmhOAuth->url('oauth/request_token', ''), $params);

        if ($code == 200) {
            $oauth = $this->tmhOAuth->extract_params($this->tmhOAuth->response['response']);
            $_SESSION['oauth'] = $oauth;

            $data['authURL'] = $this->tmhOAuth->url("oauth/authorize", '') . "?oauth_token={$oauth['oauth_token']}";
            $data['pageTitle'] = 'Sign In';
            $this->render($data, 'login');
        } else {
            $this->showError('Twitter is unresponsive :/');
        }
    }

    function auth() { //on callback from twitter
        if (isset($_REQUEST['oauth_verifier'])) {
            $this->tmhOAuth->config['user_token'] = $_SESSION['oauth']['oauth_token'];
            $this->tmhOAuth->config['user_secret'] = $_SESSION['oauth']['oauth_token_secret']; //temp token

            $code = $this->tmhOAuth->request('POST', $this->tmhOAuth->url('oauth/access_token', ''), array(
                'oauth_verifier' => $_REQUEST['oauth_verifier']
            ));

            if ($code == 200) {
                $_SESSION['access_token'] = $this->tmhOAuth->extract_params($this->tmhOAuth->response['response']); //new, permanent token!
                unset($_SESSION['oauth']);

                $this->createUser();

            } else {
                $this->showError('something went wrong');
            }
        }
    }

    function createUser() {
        $this->tmhOAuth->config['user_token'] = $_SESSION['access_token']['oauth_token'];
        $this->tmhOAuth->config['user_secret'] = $_SESSION['access_token']['oauth_token_secret'];
        $code = $this->tmhOAuth->request('GET', $this->tmhOAuth->url('1.1/account/verify_credentials'));

        if ($code == 200) {
            $response = json_decode($this->tmhOAuth->response['response']);

            //look for existing user
            $this->user = ORM::for_table('twt_users')->where('handle', $response->screen_name)->find_one();

            if ( ! $this->user) {
                $this->user = ORM::for_table('twt_users')->create();
                $this->user->handle = $response->screen_name;
                $this->user->token = $_SESSION['access_token']['oauth_token'];
                $this->user->secret = $_SESSION['access_token']['oauth_token_secret'];
                $this->user->save();
            }

            $this->updateUser();
            header('Location: '.config('base_path'));
        } else {
            $this->showError('whoops. Expired token?');
        }

        unset($_SESSION['access_token']);
    }

    function logout() {
        $this->user->delete;

        setcookie('id', '', time() - 3600, '/');
        setcookie('hash', '', time() - 3600, '/');
        header('Location: '.config('base_path'));
    }
}
