<?php


namespace App\Service\Utils\UseCaseResults\Types;


class Error extends ResultTypeAbstract
{
    /**
     * @var string $type
     */
    public $type;

    /**
     * @var int $code
     */
    public $code;

    public function __construct(string $type, int $code){
        $this->type = $type;
        $this->code = $code;
    }

}