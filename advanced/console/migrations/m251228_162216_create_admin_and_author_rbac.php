<?php

use common\rules\AuthorRule;
use console\controllers\RbacController;
use yii\db\Migration;

class m251228_162216_create_admin_and_author_rbac extends Migration
{
    /**
     * {@inheritdoc}
     * @throws Throwable
     */
    public function safeUp(): void
    {
        $auth = Yii::$app->authManager;
        $adminRole = $auth->createRole(RbacController::ROLE_ADMIN);
        $adminRole->description = 'Administrator role with full access';
        $auth->add($adminRole);

        $authorRole = $auth->createRole(RbacController::ROLE_AUTHOR);
        $authorRole->description = 'Author role with can update and delete own content';
        $auth->add($authorRole);

        /* Rules */
        $ruleExists = $auth->getRule('isAuthor');
        if ($ruleExists) {
            $auth->remove($ruleExists);
        }
        $rule = new AuthorRule();
        $auth->add($rule);

        /* Own Content Permissions */
        $updateOwn = $auth->createPermission('updateOwnRecord');
        $updateOwn->description = 'Update own record';
        $updateOwn->ruleName = $rule->name;
        $auth->add($updateOwn);

        $deleteOwn = $auth->createPermission('deleteOwnRecord');
        $deleteOwn->description = 'Delete own record';
        $deleteOwn->ruleName = $rule->name;
        $auth->add($deleteOwn);

        /* Admin permissions */
        $updateAny = $auth->createPermission('updateRecord');
        $updateAny->description = 'Update any record';
        $auth->add($updateAny);

        $deleteAny = $auth->createPermission('deleteRecord');
        $deleteAny->description = 'Delete any record';
        $auth->add($deleteAny);

        /* Hierarchy */
        $auth->addChild($updateOwn, $updateAny);
        $auth->addChild($deleteOwn, $deleteAny);

        $auth->addChild($adminRole, $updateAny);
        $auth->addChild($adminRole, $deleteAny);

        $auth->addChild($authorRole, $updateOwn);
        $auth->addChild($authorRole, $deleteOwn);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $auth = Yii::$app->authManager;

        // Get all items first
        $adminRole = $auth->getRole(RbacController::ROLE_ADMIN);
        $authorRole = $auth->getRole(RbacController::ROLE_AUTHOR);
        $updateAny = $auth->getPermission('updateRecord');
        $deleteAny = $auth->getPermission('deleteRecord');
        $updateOwn = $auth->getPermission('updateOwnRecord');
        $deleteOwn = $auth->getPermission('deleteOwnRecord');

        // Remove all user assignments for these roles first
        if ($adminRole) {
            $assignments = $auth->getUserIdsByRole(RbacController::ROLE_ADMIN);
            foreach ($assignments as $userId) {
                $auth->revoke($adminRole, $userId);
            }
        }
        if ($authorRole) {
            $assignments = $auth->getUserIdsByRole(RbacController::ROLE_AUTHOR);
            foreach ($assignments as $userId) {
                $auth->revoke($authorRole, $userId);
            }
        }

        // Remove child relationships (reverse order of creation)
        if ($authorRole && $deleteOwn) {
            $auth->removeChild($authorRole, $deleteOwn);
        }
        if ($authorRole && $updateOwn) {
            $auth->removeChild($authorRole, $updateOwn);
        }

        if ($adminRole && $deleteAny) {
            $auth->removeChild($adminRole, $deleteAny);
        }
        if ($adminRole && $updateAny) {
            $auth->removeChild($adminRole, $updateAny);
        }

        // Now remove roles, permissions, and rules
        if ($adminRole) {
            $auth->remove($adminRole);
        }
        if ($authorRole) {
            $auth->remove($authorRole);
        }
        if ($updateAny) {
            $auth->remove($updateAny);
        }
        if ($deleteAny) {
            $auth->remove($deleteAny);
        }
        if ($updateOwn) {
            $auth->remove($updateOwn);
        }
        if ($deleteOwn) {
            $auth->remove($deleteOwn);
        }

        $rule = $auth->getRule('isAuthor');
        if ($rule) {
            $auth->remove($rule);
        }
    }
}
