
<?php

function create_posts()
{
    for ($i = 0; $i < 50; $i++) {
        $model = new \tests\softDelete\model\Posts([
            'title' => 'post' . $i,
            'body' => 'postText' . $i,
            'author_id' => $i + 1,
        ]);

        $model->save();

        $author = new \tests\softDelete\model\Authors([
            'name' => 'tom' . $i,
        ]);

        $author->save();
    }
}
