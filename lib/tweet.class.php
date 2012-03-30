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

    function create() {
        if ( (!isset($_POST['tweet'])) || ($_POST['tweet'] == '') ) {
            $this->showError(2);
        }

        $status = htmlentities($_POST['tweet']);
        $reply_to = ctype_digit($_POST['in-reply-to']) ? $_POST['in-reply-to'] : '';

        $code = $this->tmhOAuth->request('POST', $this->tmhOAuth->url('1/statuses/update'), array(
          'status' => $status,
          'in_reply_to_status_id' => $reply_to
        ));

        if ($code == 200) {
            header('Location: '.config('base_path'));
        } else {
            $this->showError(3);
        }
    }
}
