<?php

namespace app\modules;


use framework\vo\RequestVoInterface;

class UserVo2 implements RequestVoInterface
{
    private $name;
    private $age;

    public function getRequestValidator(): string
    {
        return '';
    }

    public function getRequestScene(): string
    {
        return '';
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
