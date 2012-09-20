<?php include('common/main_menu.php');

//TODO: get ban info and other stuff from here
$following = $relationship['relationship']['target']['following'];
$followed_by = $relationship['relationship']['target']['followed_by'];

$follow_verb = $following ? 'Unfollow' : 'Follow';
?>

<div class="user-utils">
    <ul>
        <li>
            <a href="/user/<?php echo strtolower($follow_verb); ?>/">
                <?php echo $follow_verb;  ?> <span class="followback-info">&mdash; <?php echo $user; echo $followed_by ? ' is' : ' is not' ?> following you</span>
            </a>
        </li>
    </ul>
</div>

<div class="reply-form compose">
    <form action="<?php echo App\config('base_path'); ?>t/create" method="post">
        <textarea name="tweet" id="tweet-content">@<?php echo $user;  ?> </textarea>
        <input type="hidden" name="in-reply-to" value="">
        <input type="submit" value="Tweet" />
    </form>
</div>

<div class="timeline">
    <?php
    foreach ($tweets as $tweet) { ?>
        <div class="tweet">
            <?php include('common/tweet-body.php'); ?>
        </div>
        <?php
    } ?>
</div>