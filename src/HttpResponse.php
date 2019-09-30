<?php


namespace App;


class HttpResponse
{
    private $contentType;

    private $body;

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param mixed $contentType
     */
    public function setContentType($contentType): void
    {
        $this->contentType = $contentType;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return HttpResponse
     */
    public function setBody($body): self
    {
        $this->body = $body;

        return $this;
    }
}