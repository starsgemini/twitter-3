<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
</head>
<body>
<?php


$code = $tmhOAuth->request('GET', $tmhOAuth->url('1/statuses/home_timeline'), array(
  'include_entities' => '1',
  'include_rts'      => '1',
  'screen_name'      => $resp->screen_name,
  'count'            => 20,
));

if ($code == 200) {
  $timeline = json_decode($tmhOAuth->response['response'], true);
  foreach ($timeline as $tweet) :
    $entified_tweet = tmhUtilities::entify($tweet);
    $is_retweet = isset($tweet['retweeted_status']);

    $diff = time() - strtotime($tweet['created_at']);
    if ($diff < 60*60)
      $created_at = floor($diff/60) . ' minutes ago';
    elseif ($diff < 60*60*24)
      $created_at = floor($diff/(60*60)) . ' hours ago';
    else
      $created_at = date('d M', strtotime($tweet['created_at']));

    $permalink  = str_replace(
      array(
        '%screen_name%',
        '%id%',
        '%created_at%'
      ),
      array(
        $tweet['user']['screen_name'],
        $tweet['id_str'],
        $created_at,
      ),
      '<a href="http://twitter.com/%screen_name%/%id%">%created_at%</a>'
    );

  ?>
  <div id="<?php echo $tweet['id_str']; ?>" style="margin-bottom: 1em">
    <span>ID: <?php echo $tweet['id_str']; ?></span><br>
    <span>Orig: <?php echo $tweet['text']; ?></span><br>
    <span>Entitied: <?php echo $entified_tweet ?></span><br>
    <small><?php echo $permalink ?><?php if ($is_retweet) : ?>is retweet<?php endif; ?>
    <span>via <?php echo $tweet['source']?></span></small>
  </div>
<?php
  endforeach;
} else {
  tmhUtilities::pr($tmhOAuth->response);
}
?>
</body>
</html>