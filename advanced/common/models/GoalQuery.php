<?php
declare(strict_types=1);

namespace common\models;

/**
 * This is the ActiveQuery class for [[Goal]].
 *
 * @see Goal
 */
class GoalQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @return Goal[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return Goal|array|null
     */
    public function one($db = null): Goal|array|null
    {
        return parent::one($db);
    }
}
