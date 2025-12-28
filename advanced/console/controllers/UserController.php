<?php
declare(strict_types=1);

namespace console\controllers;

use common\models\User;
use Yii;
use yii\helpers\Console;
use yii\console\Controller;

class UserController extends Controller
{
    public function getHelpSummary(): string
    {
        return 'Manage user Role Base Access Control from console.';
    }

    public function getActionHelpSummary($action): string
    {
        $descriptions = [
            'assign-role' => 'Assign role to user, given the user ID and role name (int : required, string : required).',
        ];

        return $descriptions[$action->id] ?? '';
    }

    /**
     * @throws \Exception
     */
    public function actionAssignRole(int $userId, string $roleName): void
    {
        $user = User::findOne($userId);
        if (!$user) {
            Console::output("User with ID $userId not found.");
            return;
        }

        $auth = Yii::$app->authManager;

        $role = $auth->getRole($roleName);
        if (!$role) {
            Console::output("Role $roleName does not exist.");
            return;
        }

        $assignment = $auth->getAssignment($roleName, $userId);
        if ($assignment) {
            Console::output("User ID $userId already has the role '$roleName'.");
            return;
        }

        $auth->assign($auth->getRole($roleName), $userId);

        Console::output("Assign $roleName role to user ID: $userId");
    }

}
