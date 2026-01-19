<?php

namespace frontend\controllers;

use common\models\Orders;
use common\models\OrderItem;
use common\models\search\OrdersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\search\ItemsSearch;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\Response;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Orders models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionNumber()
    {
        $model = new Orders();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['create', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('number', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionCreate($id)
    {
        $searchModel = new ItemsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        // DataProvider for order items filtered by order_id
        $orderItemsProvider = new ActiveDataProvider([
            'query' => \common\models\OrderItem::find()
                ->andWhere(['order_id' => $id])
        ]);

        return $this->render('create', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProvider2' => $orderItemsProvider,
            'orderId' => $id,
        ]);
    }

    public function actionAddItem()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $orderId = Yii::$app->request->post('orderId');
        $itemId  = Yii::$app->request->post('itemId');

        if (!$orderId || !$itemId) {
            return ['success' => false, 'message' => 'Missing parameters'];
        }

        $item = \common\models\Items::findOne($itemId); // the product/item
        if (!$item || $item->quantity <= 0) {
            return ['success' => false, 'message' => 'Item out of stock'];
        }

        $orderItem = OrderItem::findOne([
            'order_id' => $orderId,
            'item_id' => $itemId,
        ]);

        if ($orderItem) {
            if ($item->quantity < 1) {
                return ['success' => false, 'message' => 'Cannot add more, stock depleted'];
            }
            $orderItem->quantity++;
        } else {
            $orderItem = new OrderItem([
                'order_id' => $orderId,
                'item_id' => $itemId,
                'quantity' => 1,
            ]);
        }

        if ($orderItem->save()) {
            // decrease stock in Items table
            $item->quantity--;
            $item->save(false);

            return [
                'success' => true,
                'itemId' => $itemId,
                'quantity' => $orderItem->quantity,
                'stock' => $item->quantity
            ];
        }

        return ['success' => false, 'errors' => $orderItem->errors];
    }






    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
