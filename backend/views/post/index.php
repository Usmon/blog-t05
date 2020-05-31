<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['id' => 'post-index-pjax']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'author_id',
                'value' => 'author.username'
            ],
            'title',
            'short',
            'content:ntext',
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="glyphicon glyphicon-pencil" aria-hidden="true"></i>', $url, ['class' => 'btn-update']);
                    }
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
<!-- Modal for edit form -->
<?php
    Modal::begin([
        'id' => 'post_edit_modal',
        'header' => 'Edit',
        'size' => Modal::SIZE_LARGE,
    ]);
   
   Modal::end();
?>
