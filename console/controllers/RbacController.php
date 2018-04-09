<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
/**
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 */
class RbacController extends Controller {


    public function actionInit() {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Создадим роли админа и менеджера новостей
        $admin = $auth->createRole('admin');
        $tenant = $auth->createRole('tenant');          // Арендаторы
        $manager = $auth->createRole('manager');        // Менеджеры
        $accountant = $auth->createRole('accountant');  // Бухгалтеры

        // запишем их в БД
        $auth->add($admin);
        $auth->add($tenant);
        $auth->add($manager);
        $auth->add($accountant);

        // Создаем разрешения. Доступ Арендатора
        $accessTenant = $auth->createPermission('accessTenant');
        $accessTenant->description = 'Доступ Арендатора';

        // Создаем разрешения. Доступ Менеджера
        $accessManager = $auth->createPermission('accessMarketing');
        $accessManager->description = 'Доступ Менеджера';

        // Создаем разрешения. Доступ Бухгалтера
        $accessAccountant = $auth->createPermission('accessAccountant');
        $accessAccountant->description = 'Доступ Бухгалтера';


        // Создаем разрешения. Доступ Админ
        $accessAdministration = $auth->createPermission('accessAdministration');
        $accessAdministration->description = 'Доступ Админ';

        // Запишем эти разрешения в БД
        $auth->add($accessTenant);
        $auth->add($accessManager);
        $auth->add($accessAccountant);
        $auth->add($accessAdministration);


        // Теперь добавим наследования.


        // Роли «Арендаторы» присваиваем разрешение «Доступ Арендатора»
        $auth->addChild($tenant,$accessTenant);

        // Роли «Менеджер» присваиваем разрешение «Доступ Менеджера»
        $auth->addChild($manager, $accessManager);

        // Роли «Бухгалтер» присваиваем разрешение «Доступ Бухгалтера»
        $auth->addChild($accountant, $accessAccountant);


        // админ наследует роль менеджера. Он же админ, должен уметь всё! :D
        $auth->addChild($admin, $accessTenant);

        // Еще админ имеет собственное разрешение - «Доступ к разделу админимтрирования»
        $auth->addChild($admin, $accessManager);

        // Еще админ имеет собственное разрешение - «Доступ к разделу админимтрирования»
        $auth->addChild($admin, $accessAccountant);

        // Еще админ имеет собственное разрешение - «Доступ к разделу админимтрирования»
        $auth->addChild($admin, $accessAdministration);


        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1);

        // Назначаем роль Арендатор пользователю с ID 2
        $auth->assign($tenant, 2);

        // Назначаем роль Менеджер пользователю с ID 3
        $auth->assign($manager, 3);

        // Назначаем роль Бухгалтер пользователю с ID 4
        $auth->assign($accountant, 4);
    }
}

