<?php namespace Butler\Services;

class ButlerPusher
{
    /**
     * @var string
     */
    private $api_url;

    /**
     * @var string
     */
    private $app_id;

    /**
     * @var string
     */
    private $app_key;

    /**
     * @var string
     */
    private $app_secret;

    /**
     * @param string $api_url
     * @param string $app_id
     * @param string $app_key
     * @param string $app_secret
     */
    function __construct($api_url, $app_id, $app_key, $app_secret)
    {
        $this->app_id = $app_id;
        $this->app_key = $app_key;
        $this->app_secret = $app_secret;
        $this->api_url = $api_url;
    }

    /**
     * @param $event
     * @param $channel
     * @param array $data
     * @throws \Exception
     */
    public function publish($event, $channel, array $data)
    {
        $data['event'] = $event;
        $data['channel'] = $channel;

        $content = json_encode($data);
        $hash = hash_hmac('sha256', $content, $this->app_secret);

        $headers = [
            'Accept: application/json',
            'X-Public: ' . $this->app_key,
            'X-Hash: ' . $hash,
        ];

        $response = $this->makePostRequest($headers, $content);
        dd($response);
        if ($response === 'ERROR') {
            throw new \Exception('Invalid API Call');
        }
    }

    /**
     * @param $headers
     * @param $content
     * @return mixed
     */
    private function makePostRequest($headers, $content)
    {
        $ch = curl_init($this->api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
