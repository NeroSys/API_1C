<?php
namespace common\modules\rbac\user;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;

$this->title = 'Управление правами доступа';
?>

<!-- Main Container -->
<main id="main-container">
    <!-- Hero Content -->
    <section class="content content-boxed">
        <div class="row">
            <div class="col-lg-12">
                <div class="block-header bg-gray-lighter">
                    <div class="row items-push">

                        <div class="col-sm-12 text-right hidden-xs">
                            <ol class="breadcrumb push-10-t">
                                <?php echo Breadcrumbs::widget(['links' => [
                                    [
                                        'template' => "<li><a class=\"link-effect\">{link}</a></li>\n",
                                        'label' => Yii::t('app', 'Пользователи'), 'url' => ['/user/index']
                                    ],
                                    [
                                        'template' => "<li><a class=\"link-effect\">{link}</a></li>\n",
                                        'label' =>  $user->getUserName(), 'url' => ['/user/view', 'id' => $user->id]]
                                    ],
                                    $this->title
                                ]); ?>
                            </ol>
                        </div>
                        <div class="col-sm-12">
                            <h3 class="page-heading">
                                <?='Управление ролями пользователя';?> <?= $user->getUserName(); ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">

            <?php $form = ActiveForm::begin(['action' => ["update", 'id' => $user->getId()]]); ?>

            <?= Html::checkboxList('roles', $user_permit, $roles, ['separator' => '<br>']); ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </section>
</main>

