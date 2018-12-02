<?php
require 'telegram.php';

$bot_token = getenv('TELEGRAM_BOT_TOKEN');
$app_name = getenv('HEROKU_APP_NAME');

$uri = $_SERVER['REQUEST_URI'];
switch($uri)
{
    case '/'.$bot_token:
    {
        $result = request();
        $telegram->parse($result);
        break;
    }
    case '/getWebhook':
    {
        $result = $telegram->getWebhookInfo();
        dump($result);
        break;
    }
    case '/setWebhook':
    {
        $bot_webhook = "https://" . $app_name . '.herokuapp.com/' . $bot_token;
        $params = array(
            'url' => $bot_webhook
        );
        $result = $telegram->setWebhook($params);
        dump($result);
        break;
    }
    case '/unsetWebhook':
    {
        $method = 'setWebhook';
        $params = array(
            'url' => null
        );
        $result = $telegram->setWebhook($params);
        dump($result);
        break;
    }
    default:
    {
        echo 'ok';
    }
}
function request()
{
	$postdata = file_get_contents("php://input");
	$json = json_decode($postdata, true);
	if($json)
		return $json;
	return $postdata;
}
function dump($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}