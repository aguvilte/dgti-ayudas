<?php

namespace app\controllers;

use Yii;
use app\models\Observaciones;
use app\models\ObservacionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Ayudas;
use app\models\TiposAyudas;
use app\models\Areas;
use app\models\Referentes;
use app\components\RegistroMovimientos;



/**
 * ObservacionesController implements the CRUD actions for Observaciones model.
 */
class ObservacionesController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all Observaciones models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ObservacionesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Observaciones model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $Observaciones = Observaciones::find()
                    ->where(['id_ayuda'=>$id])
                    ->OrderBy(['id_observacion'=> SORT_DESC])
                    ->all();

        $model = Ayudas::find()
                    ->where(['id_ayuda'=>$id])
                    ->one();

        return $this->render('view', [
            'Observaciones' => $Observaciones,
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Observaciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
         $model = new Observaciones();

        if ($model->load(Yii::$app->request->post())) {

            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fecha = Date('Y-m-d');
            $model->fecha_observacion=$fecha;
            $model->id_ayuda=$id;

            if (!Yii::$app->user->isGuest)
              {
               $usuario_activo=Yii::$app->user->identity->id;
              }
              $model->id_usuario=$usuario_activo;

            $model->save();

            RegistroMovimientos::registrarMovimiento(3, 'OBSERVACION', $model->id_ayuda);

            $Observaciones = Observaciones::find()
                    ->where(['id_ayuda'=>$id])
                    ->OrderBy(['id_observacion'=> SORT_DESC])
                    ->all();

             $model = Ayudas::find()
                    ->where(['id_ayuda'=>$id])
                    ->one();

            return $this->render('view', [
            'Observaciones' => $Observaciones,
            'model' => $model,
        ]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Observaciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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

    /**
     * Deletes an existing Observaciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Observaciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Observaciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Observaciones::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
