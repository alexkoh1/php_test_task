<?php

namespace App\Service;

interface SendRequestServiceInterface
{
    /**
     * @param string $url
     * @return mixed
     */
    public function sendRequest();
}