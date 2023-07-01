<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Package\UserListUpdate\core\AuditManager;
use App\Package\UserListUpdate\core\entity\FileContent;
use DateTime;

use function PHPUnit\Framework\assertEquals;

class UserListUpdateTest extends TestCase
{
    /**
     * audit_n.txtファイルが存在しない場合の挙動を確認
     */
    public function test_a_new_file_is_created_no_file(): void
    {
        $sut = new AuditManager(3);
        $files = [];

        //テスト対象システム => system under testを略して$sut
        $update = $sut->AddRecord(
            $files,
            "syu",
            new DateTime("2023-06-22 18:00:00")
        );

        assertEquals("audit_1.txt", $update->file_name);
        assertEquals("syu;2023/06/22 18:00:00\r\n", $update->new_content);
    }

    /**
     * 上限に指定した行数以上の書き込みがある場合に新しいファイルを作成するかをテスト
     */
    public function test_a_new_file_is_created_when_the_current_file_overflows(): void
    {
        $sut = new AuditManager(3);
        $files = [
            new FileContent("audit_1.txt", []),
            new FileContent(
                "audit_2.txt",
                [
                    "kitutaka;2023/06/22 16:30:00",
                    "wajima;2023/06/22 16:40:00",
                    "yokozeki;2023/06/22 16:50:00"
                ]
            )
        ];

        $update = $sut->AddRecord(
            $files,
            "syu",
            new DateTime("2023-06-22 18:00:00")
        );

        assertEquals("audit_3.txt", $update->file_name);
        assertEquals("syu;2023/06/22 18:00:00\r\n", $update->new_content);
    }
}
