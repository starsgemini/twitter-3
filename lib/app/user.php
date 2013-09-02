<?php
/*
 * User profile display.
 * No connection at all to the current user object.
 * I need to plan these things better
 *
 */
namespace App;

class user extends Twt
{
    function index()
    {
        header('Location: ' . config('base_path'));
    }

    function view($user)
    {
        $user = htmlspecialchars($user);
        $code = $this->tmhOAuth->request('GET', $this->tmhOAuth->url('1.1/statuses/user_timeline'), array(
            'screen_name' => $user,
            'count' => 20,
        ));

        if ($code == 200) {
            $data['tweets'] = json_decode($this->tmhOAuth->response['response'], true);
            $data['page_title'] = $user.'\'s tweets';
            $data['user'] = $user;

            $data['relationship'] = $this->getRelationship($this->user->handle, $user);

            $this->render($data, 'user-timeline');
        } else {
            $this->showError(5);
        }
    }

    function getRelationship($user, $target)
    {
        $code = $this->tmhOAuth->request('GET', $this->tmhOAuth->url('1.1/friendships/show'), array(
            'source_screen_name' => $user,
            'target_screen_name' => $target,
        ));

        if ($code == 200) {
            return json_decode($this->tmhOAuth->response['response'], true);
        } else {
            $this->showError(6);
        }
    }
}
