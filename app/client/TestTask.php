<?php

namespace app\client;

use app\modules\User;
use framework\task\ITask;

class TestTask implements ITask
{
    public function run(): void
    {
        $a = User::query()
            ->orderBy('created_at', 'desc')
            ->paginate(2);

        var_dump($a);
    }
}
