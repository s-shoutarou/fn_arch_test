<?php

namespace App\Package\UserListUpdate\core;

use DateTime;
use App\Package\UserListUpdate\core\command\FileUpdate;

class AuditManager
{
    public function __construct(private int $intmax_entries_per_file)
    {
    }

    public function AddRecord($files, string $visitor_name, DateTime $time_of_visit)
    {
        ksort($files);
        $new_record = $visitor_name . ";" . $time_of_visit->format('Y/m/d H:i:s')."\r\n";

        $current_file_index = count($files);
        $current_array_last_index = $current_file_index - 1;

        $lines = $files[$current_array_last_index]->lines;

        if($current_file_index === 0) {
            return new FileUpdate("audit_1.txt", $new_record);
        }

        if(count($lines) < $this->intmax_entries_per_file) {
            $lines[] = $new_record;
            $new_content = implode($lines);
            return new FileUpdate(basename($files[$current_array_last_index]->file_name), $new_content);
        } else {
            $new_file_name_index = $current_file_index + 1;
            $new_name = "audit_".$new_file_name_index.".txt";
            return new FileUpdate($new_name, $new_record);
        }
    }
}
