<?php
namespace App;

class Timeline extends Twt
{
    function index() {
        $data['tweets'] = $this->getTweets();
        $data['page_title'] = 'timeline';
        $this->render($data, 'timeline');
    }

    function getTweets() {
        $code = $this->tmhOAuth->request('GET', $this->tmhOAuth->url('1/statuses/home_timeline'), array(
          'include_entities' => '1',
          'include_rts'      => '1',
          'count'            => 20,
        ));

        if ($code == 200) {
            $tweets = json_decode($this->tmhOAuth->response['response'], true);
            return $tweets;
        } else {
            $this->showError('can\'t get user tweets');
        }
    }

}
