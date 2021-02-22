<?php

namespace tests\softDelete;

use Illuminate\Database\Eloquent\Model;

use tests\softDelete\model\Posts;

class SoftDeletesTest extends TestBase
{
    public function testDefault(): void
    {
        // sql
        $sql = Posts::query()->where('author_id', '>', 0)->sql();

        $this->assertEquals(
            'select * from `posts` where `author_id` > 0',
            $sql
        );
    }

    public function testOnlyTrashed(): void
    {
        // sql
        $sql = Posts::onlyTrashed()->where('author_id', '>', 0)->sql();

        $this->assertEquals(
            'select * from `posts_trash` where `author_id` > 0',
            $sql
        );

        $sql = Posts::onlyTrashed()->whereHas('author')->sql();

        $this->assertEquals(
            'select * from `posts_trash` where exists (select * from `authors` where `posts_trash`.`author_id` = `authors`.`id`)',
            $sql
        );
    }

    public function testWithTrashed(): void
    {
        // 单表查询
        $sql = Posts::withTrashed()
            ->where('author_id', '>', 0)
            ->offset(5)
            ->limit(5)
            ->toSql();

        $this->assertEquals(
            '(select * from `posts` where `author_id` > ?) union (select * from `posts_trash` as `posts` where `author_id` > ?) limit 5 offset 5',
            $sql
        );

        // whereHas 子查询
        $q = Posts::withTrashed()
            ->whereHas('author')
            ->where('author_id', '>', 0)
            ->offset(5)
            ->limit(5);
        $sql = $q->toSql();

        $this->assertEquals(
            '(select * from `posts` where exists (select * from `authors` where `posts`.`author_id` = `authors`.`id`) and `author_id` > ?) union (select * from `posts_trash` as `posts` where exists (select * from `authors` where `posts`.`author_id` = `authors`.`id`) and `author_id` > ?) limit 5 offset 5',
            $sql
        );

        $models = $q->get();

        $this->assertEquals(5, $models->count());

        // paginate
        $paginator = Posts::withTrashed()
            ->whereHas('author')
            ->where('author_id', '>', 0)
            ->paginate(5);

        $this->assertEquals(5, $paginator->getCollection()->count());
        $this->assertEquals(50, $paginator->total()); // 总数50
    }

    public function testDelete(): void
    {
        $count = 5;

        $total = Posts::count();

        $deleted = Posts::query()->limit($count)->get()->each->delete();

        // 删除成功后表名应该会发生响应变化
        $deleted->each(function (Model $model) {
            $this->assertEquals($model->getTable(), $model->getTrashedTable());
            $this->assertEquals(true, $model->canDelete);
        });

        $this->assertEquals(0, Posts::query()->whereIn('id', $deleted->pluck('id'))->count());
        $this->assertEquals(Posts::onlyTrashed()->whereIn('id', $deleted->pluck('id'))->count(), $count);
        $this->assertEquals(Posts::count(), $total - $count);

        // 强制删除
        $deleted->each(function (Model $model) {
            $model->delete();
        });

        $this->assertEquals(0, Posts::query()->whereIn('id', $deleted->pluck('id'))->count());
        $this->assertEquals(0, Posts::onlyTrashed()->whereIn('id', $deleted->pluck('id'))->count());
        $this->assertEquals($total - $count, Posts::count());
        $this->assertEquals(0, Posts::onlyTrashed()->count());
    }

    public function testBuilderDelete(): void
    {
        $count = 5;
        $total = Posts::count();

        // 批量软删
        Posts::query()->limit($count)->delete();

        $this->assertEquals(Posts::onlyTrashed()->count(), $count);
        $this->assertEquals(Posts::count(), $total - $count);

        // 批量硬删
        Posts::onlyTrashed()->limit($count)->delete();

        $this->assertEquals(0, Posts::onlyTrashed()->count());
        $this->assertEquals(Posts::count(), $total - $count);
    }

    public function testForceDelete(): void
    {
        $count = 5;

        $total = Posts::count();

        // 直接 forceDelete 删除
        $deleted = Posts::query()->limit($count)->get()->each->forceDelete();

        $this->assertEquals(0, Posts::query()->whereIn('id', $deleted->pluck('id'))->count());
        $this->assertEquals(0, Posts::onlyTrashed()->whereIn('id', $deleted->pluck('id'))->count());
        $this->assertEquals(Posts::count(), $total - $count);

        // 先查后删
        Posts::query()->limit($count)->get()->each->delete();

        // 强制删除
        Posts::onlyTrashed()->get()->each->delete();

        $this->assertEquals(Posts::count(), $total - 10);
        $this->assertEquals(0, Posts::onlyTrashed()->count());
    }

    public function testRestore(): void
    {
        $count = 5;

        $deleted = Posts::query()->limit($count)->get()->each->delete();

        // 判断删除是否成功
        $this->assertEquals(0, Posts::query()->whereIn('id', $deleted->pluck('id'))->count());
        $this->assertEquals($count, Posts::onlyTrashed()->whereIn('id', $deleted->pluck('id'))->count());
        $posts = $deleted->each(function (Model $model) {
            $this->assertEquals($model->getTable(), $model->getTrashedTable());
            $this->assertEquals(true, $model->canDelete);

            // 还原
            $model->restore();
        });
        // 判断数量
        $this->assertEquals($count, Posts::query()->whereIn('id', $posts->pluck('id'))->count());
        $this->assertEquals(0, Posts::onlyTrashed()->whereIn('id', $posts->pluck('id'))->count());

        $posts->each(function (Model $model) {
            $this->assertEquals($model->getTable(), $model->getOriginalTable());
            $this->assertEquals(false, $model->canDelete);
        });
    }
}
