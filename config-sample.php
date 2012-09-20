<?php
namespace App;
use Idiorm\ORM as ORM;

ORM::configure('mysql:host=DBHOST;dbname=DBNAME');
ORM::configure('username', 'USER');
ORM::configure('password', 'PASS');

global $config;

$config['routes'][''] = 'timeline';
$config['routes']['t'] = 'tweet';
$config['routes']['u'] = 'user';
$config['routes']['login'] = 'login';

$config['default_controller'] = 'index';

$config['salt'] = 'SOMEHASHTHATYOULIKE';
$config['base_path'] = '/'; //replace with actual base url

$config['consumer_key'] = 'GET FROM THE TWITTER API';
$config['consumer_secret'] = 'AGAIN, TWITTER API';

$config['session_update_interval'] = 300; // time in seconds between renewals of the session
$config['cookie_expiry'] = time() + (60 * 60 * 24 * 30);

$config['ERRORS'][404] = 'four oh four';
$config['ERRORS'][2] = 'empty tweet?';
$config['ERRORS'][3] = 'couldn\'t post tweet. wtfbbq';
$config['ERRORS'][5] = 'can\'t get user tweets';
$config['ERRORS'][6] = 'stumped getting friendship info';

function config($key) {
    global $config;
    return $config[$key];
}