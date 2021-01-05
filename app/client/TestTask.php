<?php
namespace app\client;

use app\modules\User;
use framework\task\ITask;

class TestTask implements ITask
{
    public function run(): void
    {
        echo User::query()->count();
        echo 111;
    }
}
