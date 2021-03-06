<?php
require 'app.php';
require 'telegram.php';

define('TELEGRAM_BOT_API_URI', 'https://api.telegram.org/bot');

$bot_token = getenv('TELEGRAM_BOT_TOKEN');
$app_name = getenv('HEROKU_APP_NAME');

$uri = $_SERVER['REQUEST_URI'];
switch($uri)
{
    case '/'.$bot_token:
    {
        $telegram = new TelegramBot($bot_token);
        $telegram->request();
        break;
    }
    case '/getMe':
    {
        if ( app::access($bot_token) ){
            $telegram = new TelegramBot($bot_token);
            $result = $telegram->getMe();
            app::dump($result);
        }
        break;
    }
    case '/getWebhook':
    {
        if ( app::access($bot_token) ){
            $telegram = new TelegramBot($bot_token);
            $result = $telegram->getWebhookInfo();
            app::dump($result);
        }
        break;
    }
    case '/setWebhook':
    {
        if ( app::access($bot_token) ){
            $bot_webhook = "https://" . $app_name . '.herokuapp.com/' . $bot_token;
            $telegram_url = TELEGRAM_BOT_API_URI.$bot_token;
            $result = file_get_contents($telegram_url.'/setWebhook?url=' . $bot_webhook);
            app::dump($result);
        }
        break;
    }
    case '/unsetWebhook':
    {
        if ( app::access($bot_token) ){
            $params = array(
                'url' => null
            );
            $telegram = new TelegramBot($bot_token);
            $result = $telegram->setWebhook($params);
            app::dump($result);
        }
        break;
    }
    default:
    {
        if ( app::access($bot_token) ){
            echo 'ACCESS GRANTED';
        } else {
            echo 'ok';
        }
    }
}