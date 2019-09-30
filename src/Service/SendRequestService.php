<?php


namespace App\Service;


class SendRequestService implements SendRequestServiceInterface
{
    /**
     * @var string
     */
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @param string $url
     * @return int
     */
    public function sendRequest(): int
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://google.com');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        $data = curl_getinfo($ch);
        curl_close($ch);

        return $data['http_code'];
    }
}