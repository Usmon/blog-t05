<?php

namespace common\repository;

use Yii;
use Exception;
use common\interfaces\IRepository;
use common\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use common\traits\DateFormat;

/**
 * Class for Post repository
 */
class PostRepository implements IRepository
{
    use DateFormat;

    /**
     * @inheritdoc
     */
    public static function getOne($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @inheritdoc
     */
    public static function delete($id)
    {
        return self::getOne($id)->delete();
    }

    /**
     * @inheritdoc
     */
    public static function list($page_size = 10)
    {
        return new ActiveDataProvider([
            'query' => Post::find(),
            'pagination' => [
                'pageSize' => $page_size,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function makeModel()
    {
        return new Post([
            'author_id' => Yii::$app->user->id,
            'created_at' => self::nowExpression(),
            'updated_at' => self::nowExpression(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function create($params)
    {
        $model = self::makeModel();
        $model->load($params);
        
        return $model->save();
    }

    /**
     * @inheritdoc
     */
    public static function update($id, $params)
    {
        $model = self::getOne($id);
        $model->updated_at = self::nowExpression();
        
        if ($model->load($params) && $model->save()) {
            return true;
        }
        
        return false;
    }
}