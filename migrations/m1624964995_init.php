<?php
namespace migrations;

use tachyon\db\Migration;

/**
 * @author imndsu@gmail.com
 * @copyright (c) 2021 IMND
 */
class m1624964995_init extends Migration
{
    public function run(): void
    {
        if ($query = file_get_contents(__DIR__ . '\dump.sql')) {
            $this->db->query($query);
        }
    }
}
