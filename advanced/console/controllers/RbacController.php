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
            'create-role'       => 'Create role, given the role name and description (string : required, string<"description note"> : optional).',
            'create-permission' => 'Create permission, given the permission name and description (string : required, string<"description note"> : optional).',

            'assign-permission-to-role' => 'Assign permission to role, given the permission name and role name (string : required, string : required).',
            'remove-permission-from-role' => 'Remove permission from role, given the permission name and role name (string : required, string : required).',
            'delete-permission' => 'Delete permission, given the permission name (string : required). Also it will remove all assigned children/parent.',
            'delete-role' => 'Delete role, given the role name (string : required). Also it will remove all assigned children/parent.',
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
}
