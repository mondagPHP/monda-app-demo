<?php
namespace tests\softDelete\make;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

class CreateTestTables extends Migration
{
    /** @var Builder $schema */
    private $schema;

    public function __construct($schema)
    {
        $this->schema = $schema;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->schema->create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('body')->nullable();
            $table->integer('author_id')->default(0);

            $table->timestamp('deleted_at')->nullable();

            $table->timestamps();
        });

        $this->schema->create('posts_trash', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('body')->nullable();
            $table->integer('author_id')->default(0);

            $table->timestamp('deleted_at')->nullable();

            $table->timestamps();
        });

        $this->schema->create('authors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();

            $table->timestamp('deleted_at')->nullable();

            $table->timestamps();
        });

        $this->schema->create('authors_trash', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();

            $table->timestamp('deleted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('posts');
        $this->schema->dropIfExists('posts_trash');
        $this->schema->dropIfExists('authors');
        $this->schema->dropIfExists('authors_trash');
    }
}
