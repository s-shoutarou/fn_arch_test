<?php

namespace App\Package\UserListUpdate;

use App\Package\UserListUpdate\core\AuditManager;
use App\Package\UserListUpdate\shell\Persister;
use DateTime;

class ApplicationService
{
    private readonly AuditManager $audit_manager;
    private readonly Persister $persister;

    public function __construct(private readonly string $directory_name, int $max_entries_per_file = 3)
    {
        $this->persister = new Persister();
        $this->audit_manager =  new AuditManager($max_entries_per_file);
    }

    public function addRecord(string $visitor_name, DateTime $time_of_visit): void
    {
        $files = $this->persister->readDirectory($this->directory_name);
        $update = $this->audit_manager->AddRecord($files, $visitor_name, $time_of_visit);
        $this->persister->ApplyUpdate($this->directory_name, $update);
    }
}
