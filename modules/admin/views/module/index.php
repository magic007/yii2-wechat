<?php

use yii\helpers\Html;
use yii\grid\GridView;
use callmez\wechat\models\Module;
use callmez\wechat\modules\admin\widgets\AdminPanel;

$this->title = '模块管理';
$this->params['breadcrumbs'][] = $this->title;
$wechat = Yii::$app->getModule('wechat');
?>
<?php AdminPanel::begin(['options' => ['class' => 'addon-module-index']]) ?>
    <p class="text-right">
        <?php if ($wechat->canCreateModule()) : ?>
            <?= Html::a('我要设计新模块', ["/{$wechat->giiModuleName}/{$wechat->giiGeneratorName}", ['class' => 'btn bt']]) ?>
        <?php else: ?>
            <?= Html::a('想设计新模块?', 'http://github.com/callmez/yii2-wechat') ?>
        <?php endif ?>
    </p>
    <?= GridView::widget([
        'tableOptions' => ['class' => 'table table-hover'],
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'id',
            [
                'attribute' => 'type',
                'format' => 'html',
                'value' => function ($model) use ($models) {
                    return Html::tag('span', Module::$types[$model->type], [
                        'class' => 'label label-' . ($model->type == Module::TYPE_CORE ? 'danger' : 'info')
                    ]);
                },
            ],
            'version',
            [
                'attribute' => 'author',
                'format' => 'html',
                'value' => function ($model) {
                    $author = $model->author ?: '匿名';
                    return $model->site ? Html::a($author, $model->site) : Html::encode($author) ;
                },
                'options' => [
                    'width' => 80
                ]
            ],
            'ability',
            [
                'header' => '安装状态',
                'format' => 'html',
                'value' => function ($model) use ($models) {
                    $installed = $model->getIsInstalled();
                    return Html::tag('span', $installed ? '已安装' : '未安装', [
                        'class' => 'label label-' . ($installed ? 'warning' : 'success')
                    ]);
                },
            ],
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{install}',
                'buttons' => [
                    'install' => function ($url, $model, $key) use ($models) {
                        if ($model->getIsInstalled()) {
                            return Html::a('卸载模块', ['uninstall', 'id' => $model->id], ['data-confirm' => '确定要卸载此模块?']);
                        } else {
                            return Html::a('安装模块', ['install', 'id' => $model->id]);
                        }
                    }
                ]
            ],
        ],
    ]); ?>
<?php AdminPanel::end() ?>
