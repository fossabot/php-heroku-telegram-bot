<?php
class telegram
{
    private $uri = 'https://api.telegram.org/bot';
    private $bot_token;

    public function __construct($bot_token)
    {
        $this->bot_token = $bot_token;
    }

    public function __call($name, $args)
    {
        return $this->call($name, count($args) === 0 ? [] : $args[0]);
    }

    public function call($method, $params = array())
    {
        $handle = curl_init($this->uri.$this->bot_token);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($handle);

        return ($response) ? json_decode($response, true) : false;
    }

}