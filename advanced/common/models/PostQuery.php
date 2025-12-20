<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[\common\models\Post]].
 *
 * @see Post
 */
class PostQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Post[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Post|array|null
     */
    public function one($db = null): array|Post|null
    {
        return parent::one($db);
    }
}
