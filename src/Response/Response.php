<?php

namespace Dbout\WcAjax\Response;

/**
 * Class Response
 * @package Dbout\WcAjax\Response
 */
class Response implements ResponseInterface
{

    /**
     * Http status code
     * @var int
     */
    protected $code;

    /**
     * @var array
     */
    protected $results = [];

    /**
     * @var null|string
     */
    protected $error;

    /**
     * WpAjaxResponse constructor.
     * @param int $code
     * @param array $data
     */
    public function __construct(int $code = 400, array $data = [])
    {
        $this->setData($data);
        $this->setCode($code);
    }

    /**
     * @param int $code
     * @return $this
     */
    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->results = $data;
        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function addData(array $data): self
    {
        $this->results = array_merge($this->results, $data);
        return $this;
    }

    /**
     * @param string|null $message
     * @return $this
     */
    public function setError(?string $message): self
    {
        $this->error = $message;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::STATUS => [
                self::CODE =>   $this->getCode(),
                self::ERROR =>  $this->error,
            ],
            self::RESULTS => $this->results,
        ];
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->results;
    }

    /**
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }

}