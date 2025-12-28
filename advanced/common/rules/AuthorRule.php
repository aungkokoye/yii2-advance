<?php

namespace common\rules;

use yii\rbac\Item;
use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params): bool
    {
        if (!isset($params['model'])) {
            return false;
        }

        return isset($params['model']->created_by)
            && (int)$params['model']->created_by === $user;
    }
}
