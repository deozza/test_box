<?php


namespace App\Service\Utils\UseCaseResults;

use App\Service\Utils\UseCaseResults\Types\Error;
use App\Service\Utils\UseCaseResults\Types\ResultTypeAbstract;
use App\Service\Utils\UseCaseResults\Types\Success;

class Result
{
    /**
     * @var Success|null
     */
    public $success = null;

    /**
     * @var Error[]
     */
    public $errors = [];

    /**
     * @param string $type
     * @param int $code
     * @return Result
     */
    public function setSuccess(string $type, int $code): Result{
        $this->success = new Success($type, $code);
        return $this;
    }

    /**
     * @param string $type
     * @param int $code
     * @return Result
     */
    public function addError(string $type, int $code): Result{
        $this->errors[] = new Error($type, $code);
        return $this;
    }

    public function isSuccessful(): bool{
        return (!empty($this->success) && count($this->errors) === 0);
    }
}