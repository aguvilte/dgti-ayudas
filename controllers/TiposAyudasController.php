<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\TiposAyudas;
use app\models\TiposAyudasSearch;
use yii\web\Controller;
use app\models\Usuarios;
use app\models\Ayudas;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\RegistroMovimientos;

/**
 * TiposAyudasController implements the CRUD actions for TiposAyudas model.
 */
class TiposAyudasController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
              return [
                  'access' => [
                      'class' => AccessControl::className(),
                      'only' => ['view','update','index','create'],
                      'rules' => [
                        [
                            //El administrador tiene permisos sobre las siguientes acciones
                            'actions' => ['view','update','index','create'],
                            //Esta propiedad establece que tiene permisos
                            'allow' => true,
                            //Usuarios autenticados, el signo ? es para invitados
                            'roles' => ['@'],
                            //Este método nos permite crear un filtro sobre la identidad del usuario
                            //y así establecer si tiene permisos o no
                            'matchCallback' => function ($rule, $action) {
                                //Llamada al método que comprueba si es un administrador
                                return Usuarios::isUserAdmin(Yii::$app->user->identity->id);
                            },
                        ],
                        [
                            //Los usuarios simples tienen permisos sobre las siguientes acciones
                            'actions' => ['view','update','index','create'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                               return Usuarios::isTiposAyudas(Yii::$app->user->identity->id);
                           },
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
     * Lists all TiposAyudas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TiposAyudasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TiposAyudas model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TiposAyudas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TiposAyudas();

        if ($model->load(Yii::$app->request->post())) {
            $model->estado=1;
            $model->save();

            RegistroMovimientos::registrarMovimiento(4, 'CREACION', $model->id_tipo);
            return $this->redirect(['/tipos-ayudas/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TiposAyudas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            RegistroMovimientos::registrarMovimiento(4, 'ACTUALIZACION', $model->id_tipo);

            return $this->redirect(['view', 'id' => $model->id_tipo]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TiposAyudas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $tipo = TiposAyudas::findOne($id);

        $CountIniciadas= Ayudas::find()
                    ->where(['id_tipo'=>$id])
                    ->andwhere(['id_estado'=>1])
                    ->count();

        $CountEnproceso= Ayudas::find()
                    ->where(['id_tipo'=>$id])
                    ->andwhere(['id_estado'=>2])
                    ->count();
        if($CountIniciadas>0 or $CountEnproceso>0)
        {
            throw new NotFoundHttpException('Eliminación inválida. Existen ayudas de este tipo iniciadas o en proceso.');
        }else {
        $tipo->estado=0;
        $tipo->save();

        RegistroMovimientos::registrarMovimiento(4, 'ELIMINACION', $tipo->id_tipo);
        }
        return $this->redirect(['/tipos-ayudas/index']);
    }

    /**
     * Finds the TiposAyudas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TiposAyudas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TiposAyudas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
