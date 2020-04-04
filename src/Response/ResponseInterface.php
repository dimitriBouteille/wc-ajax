<?php


namespace Dbout\WcAjax\Response;

/**
 * Interface ResponseInterface
 * @package Dbout\WcAjax\Response
 */
interface ResponseInterface
{

    const CODE = 'code';
    const RESULTS = 'results';
    const ERROR = 'error';
    const STATUS = 'status';

    /**
     * Transform object to array
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Get http status code
     * ie: 404, 200, ..
     *
     * @return int
     */
    public function getCode(): int;

}