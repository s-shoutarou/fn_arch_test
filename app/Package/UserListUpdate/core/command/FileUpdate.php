<?php

namespace App\Package\UserListUpdate\core\command;

class FileUpdate
{
    public function __construct(public readonly string $file_name, public readonly string $new_content)
    {
    }

}
