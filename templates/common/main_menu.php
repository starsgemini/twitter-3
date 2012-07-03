<div id="main-nav">
    <ul>
        <li><a href="/">Timeline</a></li>
        <li><a href="/login/logout/">Logout</a></li>
        <li>| api limit- <?php echo $rate_data['remaining_hits'].'/'.$rate_data['hourly_limit']; ?></li>
    </ul>
</div>