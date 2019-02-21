<?php

namespace app\controllers;

use Yii;
use app\models\Expedientes;
use app\models\ExpedientesSearch;
use app\models\AyudasExpedientes;
use app\models\Ayudas;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ExpedientesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ExpedientesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Expedientes();

        if ($model->load(Yii::$app->request->post())) {
            $model->monto_total = 0;
            $model->estado = 1;
            $model->fecha_alta = Date('Y-m-d');
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_expediente]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_expediente]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionAyudas($id)
    {
        $model = new Expedientes();
        $ayuda = Ayudas::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            $ayudasExpedientesModel = new AyudasExpedientes();
            $ayudasExpedientesModel->id_ayuda = $id;

            // trae el id_expediente como numero. no sé por qué
            $idExpediente = $model->numero;

            $ayudasExpedientesModel->id_expediente = $idExpediente;
            $ayudasExpedientesModel->save();

            $expedienteToActualizar = Expedientes::findOne($idExpediente);
            $expedienteToActualizar->monto_total = $expedienteToActualizar->monto_total + $ayuda->monto;
            $expedienteToActualizar->save();

            return $this->redirect(['index']);
        } else {
            return $this->render('ayudas', [
                'model' => $model,
                'ayuda' => $ayuda,
            ]);
        }

    }

    protected function findModel($id)
    {
        if (($model = Expedientes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
