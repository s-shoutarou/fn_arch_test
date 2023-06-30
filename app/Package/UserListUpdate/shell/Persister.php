<?php

namespace App\Package\UserListUpdate\shell;

use AuditManager;
use App\Package\UserListUpdate\core\entity\FileContent;
use App\Package\UserListUpdate\core\command\FileUpdate;

class Persister
{
    /**
     * @param string $directory_name 処理対象ディレクトリ
     * @return array<FileContent> $file_contents FileContentをまとめた配列
     */
    public function readDirectory(string $directory_name): array
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

    /**
     * @param string $directory_name 処理対象ディレクトリ
     * @param FileUpdate $update 処理対象ファイルに関する情報を持つオブジェクト
     */
    public function applyUpdate(string $directory_name, FileUpdate $update)
    {
        $stream = fopen($directory_name.$update->file_name, "w");
        fwrite($stream, $update->new_content);
        fclose($stream);
    }
}
