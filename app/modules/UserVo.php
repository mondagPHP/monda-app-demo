<?php

namespace app\modules;

use framework\vo\RequestVoInterface;

/**
 * Class UserVo
 * @package app\modules
 */
class UserVo implements RequestVoInterface
{
    private $name;
    private $age;

    public function valid(): array
    {
        return [UserValid::class, 'edit'];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age): void
    {
        $this->age = $age;
    }
}
