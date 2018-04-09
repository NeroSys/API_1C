<?php
namespace common\modules\rbac\views\access;

use Yii;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

$this->title = 'Управление ролями';
?>

<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content content-boxed">
        <!-- Header Tiles -->
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <?= Html::a(Yii::t('app', 'Добавить роль'), ['add-role'], ['class' => 'btn btn-block btn-primary push-10']) ?>
            </div>
            <div class="col-sm-6 col-md-9">

            </div>
        </div>
        <!-- END Header Tiles -->
        <?php
        $dataProvider = new ArrayDataProvider([
            'allModels' => Yii::$app->authManager->getRoles(),
            'sort' => [
                'attributes' => ['name', 'description'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        ?>
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
                                $this->title
                            ]]); ?>
                        </ol>
                    </div>
                </div>

            </div>
            <div class="block-content">
                <?=GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'class'     => DataColumn::className(),
                            'attribute' => 'name',
                            'label'     => 'Роль'
                        ],
                        [
                            'class'     => DataColumn::className(),
                            'attribute' => 'description',
                            'label'     => 'Описание'
                        ],
                        [
                            'class'     => DataColumn::className(),
                            'label'     => 'Разрешенные доступы',
                            'format'    => ['html'],
                            'value'     => function($data) { return implode('<br>',array_keys(ArrayHelper::map(Yii::$app->authManager->getPermissionsByRole($data->name), 'description', 'description')));}
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                            'buttons' =>
                                [
                                    'update' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['update-role', 'name' => $model->name]), [
                                            'title' => 'Обновить',
                                            'data-pjax' => '0',
                                        ]); },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete-role','name' => $model->name]), [
                                            'title' => 'Удалить',
                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                        ]);
                                    }
                                ]
                        ],
                    ]
                ]);?>
            </div>
        </div>
        <!-- END All Products -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->

