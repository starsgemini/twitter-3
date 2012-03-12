<?php

class Timeline extends Twt
{
    function index() {
        $data['tweets'] = $this->getTweets();
        $data['pageTitle'] = 'timeline';
        $this->render($data, 'timeline');
    }

    function getTweets() {
        $code = $this->tmhOAuth->request('GET', $this->tmhOAuth->url('1/statuses/friends_timeline'), array(
          'include_entities' => '1',
          'include_rts'      => '1',
          'count'            => 30,
        ));

        if ($code == 200) {
            $tweets = json_decode($this->tmhOAuth->response['response'], true);
            return $tweets;
        } else {
            $this->showError('can\'t get user tweets');
        }
    }

}
