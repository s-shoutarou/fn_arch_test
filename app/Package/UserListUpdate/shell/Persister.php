<?php

namespace App\Package\UserListUpdate\shell;

use AuditManager;
use App\Package\UserListUpdate\core\entity\FileContent;
use App\Package\UserListUpdate\core\command\FileUpdate;

class Persister
{
    public function readDirectory(string $directory_name)
    {
        $files = glob($directory_name.'/*.txt');
        $file_contents = [];
        foreach ($files as $key => $val) {
            $file_contents[] = new FileContent(
                $val,
                file($val)
            );
        }
        return $file_contents;
    }

    public function applyUpdate(string $directory_name, FileUpdate $update)
    {
        $stream = fopen($directory_name.$update->file_name, "w");
        fwrite($stream, $update->new_content);
        fclose($stream);
    }
}
