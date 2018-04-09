<?php
namespace common\modules\rbac\views\access;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\Links */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Новое правило';
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
                                        'label' => Yii::t('app', 'Правила доступа'), 'url' => ['permission']
                                    ],
                                    $this->title
                                ]]); ?>
                            </ol>
                        </div>
                        <div class="col-sm-12">
                            <h3 class="page-heading">
                                <?= Html::encode($this->title) ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <?php
            if (!empty($error)) {
                ?>
                <div>
                    <?php
                    echo implode('<br>', $error);
                    ?>
                </div>
                <?php
            }
            ?>

        </div>
        <div class="col-lg-12">
            <div class="block">
                <?php $form = ActiveForm::begin(); ?>

                <div class="form-group">
                    <?= Html::label('Текстовое описание'); ?>
                    <?= Html::textInput('description'); ?>
                </div>

                <div class="form-group">
                    <?= Html::label('Разрешенный доступ'); ?>
                    <?= Html::textInput('name'); ?>
                    <?=Yii::t('db_rbac', '<br>* Формат: <strong>module/controller/action</strong><br><strong>site/article</strong> - доступ к странице "site/article"<br><strong>site</strong> - доступ к любым action контроллера "site"');?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>



    </section>
</main>


