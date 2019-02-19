<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Personas;
use app\models\PersonasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Usuarios;

/**
 * PersonasController implements the CRUD actions for Personas model.
 */
class PersonasController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','update','create'],
                'rules' => [
                  [
                      //El administrador tiene permisos sobre las siguientes acciones
                      'actions' => ['index','view','update','create'],
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
     * Lists all Personas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Personas model.
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
     * Creates a new Personas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Personas();

        if ($model->load(Yii::$app->request->post())) {

          //VALIDAMOS QUE NO SE PUEDAN CREAR DOS PERSONAS IGUALES POR DNI

          $Personas = Personas::find()
                          ->where(['documento'=>$model->documento])
                          ->count();

          if($Personas>0)
          {
            throw new NotFoundHttpException('Error.! Ya existe registrada una persona con el mismo numero de DNI.');
          }else {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_persona]);
          }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Personas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_persona]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Personas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //VALIDAMOS ANTES DE BORRAR QUE NO TENGA NINGUN USUARIO ASOCIADO
        $Usuarios = Usuarios::find()
                      ->where(['id_persona'=>$id])
                      ->count();

        if ($Usuarios>0) {
          throw new NotFoundHttpException('Error.! La persona no puede ser borrada ya que actualmente tiene un Usuario asociado.');
        }else {
          $this->findModel($id)->delete();

          return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Personas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Personas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Personas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
