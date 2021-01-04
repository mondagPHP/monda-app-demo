<?php
namespace app\modules;


use framework\vo\RequestVoInterface;

class UserVo3 implements RequestVoInterface
{
    private $name;
    private $age;

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

    /**
     * 验证器
     * @return string
     */
    public function getRequestValidator(): string
    {
        return UserValid::class;
    }

    /**
     * @return string
     * 场景
     */
    public function getRequestScene(): string
    {
        return 'edit';
    }
}
