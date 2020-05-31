<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\repository\PostRepository;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update', 'delete', 'view'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update', 'delete', 'view'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $id = Yii::$app->request->get('id');
                            if (Yii::$app->user->can('admin') || PostRepository::isAuthor($id)) {
                                return true;
                            }

                            return false;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('admin')) {
            $dataProvider = PostRepository::list(10);
        }
        else {
            $dataProvider = PostRepository::list(10, Yii::$app->user->id);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => PostRepository::getOne($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = PostRepository::makeModel();

        if (PostRepository::create(Yii::$app->request->post())) {
            return $this->redirect(['post/index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = PostRepository::getOne($id);

        if (Yii::$app->request->isAjax && !Yii::$app->request->post()) {
            return $this->renderPartial('update', [
                'model' => $model,
            ]);
        } 

        if (PostRepository::update($id, Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                return json_encode(true);
            }

            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        PostRepository::delete($id);

        return $this->redirect(['index']);
    }
}
