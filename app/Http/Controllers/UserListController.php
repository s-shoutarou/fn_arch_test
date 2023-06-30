<?php

namespace App\Http\Controllers;

use App\Package\UserListUpdate\ApplicationService;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;

class UserListController
{
    /**
     * @param Request $request
     *
     * storage/app配下audit_n.txtの作成もしくはアップデート
     */
    public function update(Request $request)
    {
        //Controllerは極力フロントエンドからサービスクラスへの入力の受け渡し
        //およびフロントエンドへの出力の受け渡し以外のロジックを実装しない

        $file_directory = storage_path("app/"); // サービスクラス内で極力Laravelに依存した記述を避けたい

        (new ApplicationService($file_directory))->addRecord(
            $request->session()->get("name") ?? "test",
            new DateTime(timezone: new DateTimeZone('Asia/Tokyo'))
            //new DateTime("now", new DateTimeZone('Asia/Tokyo'))
        );
    }
}
