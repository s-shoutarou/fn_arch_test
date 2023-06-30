<?php

namespace App\Http\Controllers;

use App\Package\UserListUpdate\ApplicationService;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;

class UserListController
{
    public function update(Request $request)
    {
        $file_directory = storage_path("app/");
        (new ApplicationService($file_directory))->addRecord(
            $request->session()->get("name") ?? "test",
            new DateTime(timezone: new DateTimeZone('Asia/Tokyo'))
        );
    }
}
