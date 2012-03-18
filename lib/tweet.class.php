<?php

class tweet extends Twt
{
    function view($id = false)
    {
        if ($id) {
            $code = $this->tmhOAuth->request('GET', $this->tmhOAuth->url('1/statuses/show'), array(
                'id' => $id,
                'include_entities' => true
            ));
            if ($code == 200) {
                $tweet = json_decode($this->tmhOAuth->response['response'], true);
                $data['tweet'] = $tweet;
                $this->render($data, 'tweet');
                return($tweet);
            } else {
                //tmhUtilities::pr($this->tmhOAuth->response);
                $this->showError($code);
            }
        }
    }

    function reply($id) {
        $tweet = $this->view($id); //render and get tweet

        $data['tweet'] = $tweet;
        $data['page_title'] = 'reply to ';
        $data['id'] = $id;
        $data['entities'] = $tweet['entities'];

        $this->render($data, 'reply');
    }
}
