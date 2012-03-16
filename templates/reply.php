<?php
$mentioned_users = '';
foreach($entities['user_mentions'] as $user) {
    $mentioned_users .= '<a ';
    $mentioned_users .= config('base_path').'';
}
?>