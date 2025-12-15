<?php
declare(strict_types=1);

namespace common\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Project]].
 *
 * @see Project
 */
class ProjectQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Project[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Project|array|null
     */
    public function one($db = null): Project| array | null
    {
        return parent::one($db);
    }
}
