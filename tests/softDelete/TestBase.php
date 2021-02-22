<?php
namespace tests\softDelete;

use Dotenv\Dotenv;
use framework\Container;
use framework\db\Connection;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent;
use Illuminate\Database\Query;
use PHPUnit\Framework\TestCase;
use tests\softDelete\make\CreateTestTables;

abstract class TestBase extends TestCase
{
    private $schema;

    protected function setUp(): void
    {
        parent::setUp();
        Dotenv::create(BASE_PATH, 'env_dev')->load();
        Container::getContainer();
        Connection::fireConnection();

        $this->schema = Manager::connection('default')->getSchemaBuilder();

        $this->migrateTestTables();

        include_once __DIR__ . '/make/factory.php';

        create_posts();

        $this->extendQueryBuilder();
    }

    protected function tearDown(): void
    {
        (new CreateTestTables($this->schema))->down();

        parent::tearDown();
    }

    public function migrateTestTables()
    {
        (new CreateTestTables($this->schema))->up();
    }

    protected function extendQueryBuilder()
    {
        Eloquent\Builder::macro('sql', function () {
            return $this->query->sql();
        });
        Query\Builder::macro('sql', function () {
            $bindings = $this->getBindings();

            return sprintf(str_replace('?', '%s', $this->toSql()), ...$bindings);
        });
    }
}
