<?php

namespace app\controllers;

use Yii;
use app\components\RegistroMovimientos;
use app\models\Areas;
use app\models\Ayudas;
use app\models\Observaciones;
use app\models\ObservacionesSearch;
use app\models\Referentes;
use app\models\TiposAyudas;
use app\models\Devoluciones;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ObservacionesController extends Controller
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
        $searchModel = new ObservacionesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {

        $observaciones = Observaciones::find()
            ->where(['id_ayuda' => $id])
            ->orderBy(['id_observacion' => SORT_DESC])
            ->all();

        $Devoluciones = Devoluciones::find()
            ->where(['id_ayuda' => $id])
            ->orderBy(['id_devolucion' => SORT_DESC])
            ->all();

        $model = Ayudas::find()
            ->where(['id_ayuda' => $id])
            ->one();

        return $this->render('view', [
            'observaciones' => $observaciones,
            'Devoluciones' => $Devoluciones,
            'model' => $model,
        ]);
    }

    public function actionCreate($id)
    {
        $model = new Observaciones();

        if ($model->load(Yii::$app->request->post())) {

            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fecha = Date('Y-m-d');
            $model->fecha_observacion = $fecha;
            $model->id_ayuda = $id;

            if (!Yii::$app->user->isGuest) {
               $usuario_activo = Yii::$app->user->identity->id;
            }

            $model->id_usuario = $usuario_activo;
            $model->save();

            RegistroMovimientos::registrarMovimiento(3, 'OBSERVACION', $model->id_ayuda);

            $observaciones = Observaciones::find()
                ->where(['id_ayuda' => $id])
                ->orderBy(['id_observacion' => SORT_DESC])
                ->all();

            $model = Ayudas::find()
                ->where(['id_ayuda' => $id])
                ->one();

            return $this->redirect(['view', 'id' => $model->id_ayuda]);
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
            return $this->redirect(['view', 'id' => $model->id_observacion]);
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

    protected function findModel($id)
    {
        if (($model = Observaciones::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
