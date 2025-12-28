<?php
declare(strict_types=1);

namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;

class RbacController extends Controller
{
    const ROLE_ADMIN = 'admin';
    const ROLE_AUTHOR = 'author';


    public function getHelpSummary(): string
    {
        return 'Manage Role Base Access Control from console.';
    }

    public function getActionHelpSummary($action): string
    {
        $descriptions = [
            'create-role'       => 'Create role, given the role name and description (string : required, string<"description note"> : required).',
            'create-permission' => 'Create permission, given the permission name and description (string : required, string<"description note"> : required).',
            'create-rule'       => 'Create rule, given the rule name and full class name (string : required, string<"full class name"> : required).',

            'assign-permission-to-role' => 'Assign permission to role, given the permission name and role name (string : required, string : required).',
            'assign-rule-to-permission' => 'Assign rule to permission, given the rule name and permission name (string : required, string : required).',

            'remove-permission-from-role' => 'Remove permission from role, given the permission name and role name (string : required, string : required).',
            'remove-rule-from-permission' => 'Remove rule from permission, given the rule name and permission name (string : required, string : required).',

            'delete-role'       => 'Delete role, given the role name (string : required). Also it will remove all assigned children/parent.',
            'delete-permission' => 'Delete permission, given the permission name (string : required). Also it will remove all assigned children/parent.',
            'delete-rule'       => 'Delete rule, given the rule name (string : required). Also it will remove all assigned to permissions.',
        ];

        return $descriptions[$action->id] ?? '';
    }

    /**
     * @throws \Throwable
     */
    public function actionCreateRole(string $roleName, string $description): void
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        if ($role) {
            Console::output("Role $roleName already exists.");
            return;
        }

        $role = $auth->createRole($roleName);
        $role->description = $description;
        $auth->add($role);

        Console::output("Successfully created role: $roleName");
    }

    /**
     * @throws \Throwable
     */
    public function actionCreatePermission(string $permissionName, string $description): void
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($permissionName);

        if (!empty($permission)) {
            Console::output("Permission $permissionName already exists.");
            return;
        }

        $permission = $auth->createPermission($permissionName);
        $permission->description =  $description;
        $auth->add($permission);

        Console::output("Successfully created permission: $permissionName");
    }

    /**
     * @throws \Exception
     */
    public function actionCreateRule(string $ruleName, string $ruleFullClassName): void
    {
        $auth = Yii::$app->authManager;
        $rule = $auth->getRule($ruleName);
        if ($rule) {
            Console::output("Rule $ruleName already exists.");
            return;
        }

        if(!class_exists($ruleFullClassName)) {
            Console::output("Rule Class  $ruleFullClassName does not exist.");
            return;
        }

        $rule = new $ruleFullClassName();
        $auth->add($rule);
        Console::output("Successfully created rule: $ruleName");
    }

    /**
     * @throws \Throwable
     */
    public function actionAssignPermissionToRole(string $permissionName, string $roleName): void
    {
        $auth = Yii::$app->authManager;

        $permission = $auth->getPermission($permissionName);
        if (!$permission) {
            Console::output("Permission $permissionName does not exist.");
            return;
        }

        $role = $auth->getRole($roleName);
        if (!$role) {
            Console::output("Role $roleName does not exist.");
            return;
        }

        $auth->addChild($role, $permission);

        Console::output("Successfully assigned permission $permissionName to role $roleName");
    }

    /**
     * @throws \Exception
     */
    public function actionAssignRuleToPermission(string $ruleName, string $permissionName): void
    {
        $auth = Yii::$app->authManager;

        $rule = $auth->getRule($ruleName);
        if (!$rule) {
            Console::output("Rule $ruleName does not exist.");
            return;
        }

        $permission = $auth->getPermission($permissionName);
        if (!$permission) {
            Console::output("Permission $permissionName does not exist.");
            return;
        }

        $permission->ruleName = $rule->name;
        $auth->update($permissionName, $permission);

        Console::output("Successfully assigned rule $ruleName to permission $permissionName");
    }

    public function actionRemovePermissionFromRole(string $permissionName, string $roleName): void
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($permissionName);
        if (!$permission) {
            Console::output("Permission $permissionName does not exist.");
            return;
        }
        $role = $auth->getRole($roleName);
        if (!$role) {
            Console::output("Role $roleName does not exist.");
            return;
        }
        $auth->removeChild($role, $permission);
        Console::output("Successfully removed permission $permissionName from role $roleName");
    }

    /**
     * @throws \Throwable
     */
    public function actionRemoveRuleFromPermission(string $ruleName, string $permissionName): void
    {
        $auth = Yii::$app->authManager;
        $rule = $auth->getRule($ruleName);
        if (!$rule) {
            Console::output("Rule $ruleName does not exist.");
            return;
        }
        $permission = $auth->getPermission($permissionName);
        if (!$permission) {
            Console::output("Permission $permissionName does not exist.");
            return;
        }
        if ($permission->ruleName !== $rule->name) {
            Console::output("Permission $permissionName is not associated with rule $ruleName.");
            return;
        }
        $permission->ruleName = null;
        $auth->update($permissionName, $permission);
        Console::output("Successfully removed rule $ruleName from permission $permissionName");
    }

    public function actionDeletePermission(string $permissionName): void
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($permissionName);
        if (!$permission) {
            Console::output("Permission $permissionName does not exist.");
            return;
        }

        $auth->remove($permission);
        Console::output("Successfully deleted permission: $permissionName");
    }

    public function actionDeleteRole(string $roleName): void
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        if (!$role) {
            Console::output("Role $roleName does not exist.");
            return;
        }

        $auth->remove($role);
        Console::output("Successfully deleted role: $roleName");
    }

    public function actionDeleteRule(string $ruleName): void
    {
        $auth = Yii::$app->authManager;
        $rule = $auth->getRule($ruleName);
        if (!$rule) {
            Console::output("Rule $ruleName does not exist.");
            return;
        }

        $auth->remove($rule);
        Console::output("Successfully deleted rule: $ruleName");
    }
}
