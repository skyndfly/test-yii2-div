<?php
namespace app\services\request\dto;
class RequestCreateDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $message
    ) {
    }
}