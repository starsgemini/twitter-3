<div id="main-nav">
    <nav class="top-bar">
        <section>
            <ul class="right">
                <li><a href="/">Timeline</a></li>
                <li><a href="/login/logout/">Logout</a></li>
                <li><a href="#">(api limit- <?php echo $rate_data['remaining_hits'] . '/' . $rate_data['hourly_limit']; ?>)</a></li>
                <li class="toggle-topbar"><a href="#"></a></li>
            </ul>
        </section>
    </nav>
</div>