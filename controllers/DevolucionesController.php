<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Devoluciones;
use app\models\DevolucionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Usuarios;
use app\models\Ayudas;
use app\components\RegistroMovimientos;

/**
 * DevolucionesController implements the CRUD actions for Devoluciones model.
 */
class DevolucionesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
              return [
                  'access' => [
                      'class' => AccessControl::className(),
                      'only' => ['view','update','index','create','mensaje_exito'],
                      'rules' => [
                        [
                            //El administrador tiene permisos sobre las siguientes acciones
                            'actions' => ['view','update','index','create','mensaje_exito'],
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
                            'actions' => ['view','update','index','create','mensaje_exito'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                               return Usuarios::isDevoluciones(Yii::$app->user->identity->id);
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
     * Lists all Devoluciones models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DevolucionesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Devoluciones model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $Devoluciones = Devoluciones::find()
                    ->where(['id_ayuda'=>$id])
                    ->OrderBy(['id_devolucion'=> SORT_DESC])
                    ->all();

        return $this->render('view', [
            'Devoluciones' => $Devoluciones,
        ]);
    }

    /**
     * Creates a new Devoluciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Devoluciones();

        if ($model->load(Yii::$app->request->post())) {

            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fecha = Date('Y-m-d');
            $model->fecha=$fecha;
            $model->id_ayuda=$id;

            if (!Yii::$app->user->isGuest)
              {
               $usuario_activo=Yii::$app->user->identity->id;
              }
              $model->id_usuario=$usuario_activo;

            $model->save();

            $ayuda = Ayudas::find()
                    ->where(['id_ayuda'=>$id])
                    ->one();

            $ayuda->id_estado=4;

            $ayuda->save();

            RegistroMovimientos::registrarMovimiento(3, 'DEVOLUCION', $ayuda->id_ayuda);
            return $this->redirect(['mensaje_exito']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionMensaje_exito()
    {
      return $this->render('mensaje_exito');
    }

    /**
     * Updates an existing Devoluciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_devolucion]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Devoluciones model.
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
     * Finds the Devoluciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Devoluciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Devoluciones::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
