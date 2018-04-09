<?php
namespace common\modules\rbac\access;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;

$this->title = 'Редактирование роли: '. $role->name;
?>

<?php
if (!empty($error)) {
    ?>
    <div class="error-summary">
        <?php
        echo implode('<br>', $error);
        ?>
    </div>
    <?php
}
?>

<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content content-boxed">
        <!-- Header Tiles -->
        <div class="row">
            <div class="col-sm-6 col-md-3">

            </div>
            <div class="col-sm-6 col-md-9">

            </div>
        </div>
        <!-- END Header Tiles -->

        <!-- All Products -->
        <div class="block">
            <div class="block-header bg-gray-lighter">
                <div class="row items-push">
                    <div class="col-sm-4">
                        <h1 class="page-heading">
                            <?= $this->title ?>
                        </h1>
                    </div>
                    <div class="col-sm-8 text-right hidden-xs">
                        <ol class="breadcrumb push-10-t">
                            <?php echo Breadcrumbs::widget(['links' => [
                                [
                                    'template' => "<li><a class=\"link-effect\">{link}</a></li>\n",
                                    'label' => 'Управление ролями', 'url' => ['role']
                                ],

                                $this->title
                            ]]); ?>
                        </ol>
                    </div>
                </div>

            </div>
            <div class="block-content">
                <?php $form = ActiveForm::begin(); ?>

                <div class="form-group">
                    <?= Html::label('Название роли'); ?>
                    <?= Html::textInput('name', $role->name); ?>
                </div>

                <div class="form-group">
                    <?= Html::label('Текстовое описание'); ?>
                    <?= Html::textInput('description', $role->description); ?>
                </div>

                <div class="form-group">
                    <?= Html::label('Разрешенные доступы'); ?>
                    <?= Html::checkboxList('permissions', $role_permit, $permissions, ['separator' => '<br>']); ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <!-- END All Products -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->