<?php
namespace app\task;

use framework\task\ITask;

class TestTask implements ITask
{
    public function run(): void
    {
        echo 111;
    }
}
