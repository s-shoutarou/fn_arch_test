<?php

namespace App\Package\UserListUpdate\core\entity;

class FileContent
{
    public function __construct(public readonly string $file_name, public readonly array $lines)
    {
    }
}
