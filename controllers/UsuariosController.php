<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Rol;
use app\models\Secciones;
use app\models\UsuariosSecciones;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
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
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuarios model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
       $UsuariosSecciones = UsuariosSecciones::find()
                          ->where(['id_usuario'=>$id])
                          ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'UsuariosSecciones' => $UsuariosSecciones,
        ]);
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id,$documento)
    {
      $model = new Usuarios();

      $roles=Rol::find()->all();

      $secciones=Secciones::find()->all();

      if ($model->load(Yii::$app->request->post())) {

            //if (!empty($_POST['id_rol']) AND !empty($_POST['id_seccion'])) {
            if (!empty($_POST['id_rol'])) {
            
                if ($_POST['id_rol']!= 1  AND empty($_POST['id_seccion'])) {
                     throw new NotFoundHttpException('Error.! Seleccione al menos una Sección.');
                }else{ 
                    
                /*OBTENEMOS Y GUARDAMOS LA ULTIMA FECHA DE ACCESO*/
                date_default_timezone_set('America/Argentina/Buenos_Aires');
                $ultimo_acceso_fecha=date('d-m-Y h:i:s');
                $model->ultimo_acceso_fecha=$ultimo_acceso_fecha;

                /*CORROBORAMOS QUE NO SE PUEDAN CREAR DOS USUARIOS IGUALES*/
                $UsuariosCount = Usuarios::find()
                                    ->where(['username'=>$model->username])
                                    ->count();

                 if($UsuariosCount>0)
                  {
                    throw new NotFoundHttpException('Error.! Ya existe un Usuario con ese Nombre de Usuario.');
                  }

                /*CORROBORAMOS QUE NO SE PUEDAN CREAR DOS USUARIOS PARA UNA MISMA PERSONA*/
                $UsuariosExistCount = Usuarios::find()
                                  ->where(['id_persona'=>$model->id_persona])
                                  ->count();

                if($UsuariosExistCount>0)
                  {
                    throw new NotFoundHttpException('Error.! Ya existe un Usuario creado para el Nº de Documento seleccionado.');
                  }

                /*SI SALEN LAS VALIDACIONES OKEY GUARDAMOS EL USUARIO*/
                    
                 if ($_POST['id_rol']!= 1  AND !empty($_POST['id_seccion'])) {    
                     
                    $model->id_rol=$_POST['id_rol'];
                    $idsecciones = $_POST['id_seccion'];
                    $model->save();

                    for($i=0; $i < count($idsecciones); $i++){
                        //echo "seleccionados " . $idsecciones[$i] . "<br/>";
                        $UsuariosSecciones = new UsuariosSecciones;
                        $UsuariosSecciones->id_usuario = $model->id;
                        $UsuariosSecciones->id_seccion = $idsecciones[$i];
                        $UsuariosSecciones->insert();
                    }

                    $UsuariosSecciones = UsuariosSecciones::find()
                                        ->where(['id_usuario'=>$model->id])
                                        ->all();
                     
                    return $this->redirect(['view', 'id' => $model->id,'UsuariosSecciones' => $UsuariosSecciones]);
                     
                     
                }else{   
                     $model->id_rol=$_POST['id_rol']; 
                     $model->save();
                     
                     return $this->redirect(['view', 'id' => $model->id]);
                    
                }                       
                
             }    
                
          }else {
            throw new NotFoundHttpException('Error.! Seleccione al menos un Rol.');
          }
        } else {
            return $this->render('create', [
                'model' => $model,
                'id' => $id,
                'documento' => $documento,
                'roles' => $roles,
                'secciones' => $secciones,
            ]);
        }
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $roles=Rol::find()->all();

        $secciones=Secciones::find()->all();
        
        if ($model->load(Yii::$app->request->post())) {
          if ($_POST['id_rol']!= 1  AND empty($_POST['id_seccion'])) {
             throw new NotFoundHttpException('Error.! Seleccione al menos una Sección.');
           }else{ 
              
             UsuariosSecciones::deleteAll(['id_usuario' =>$model->id]); 
              
             $model->id_rol=$_POST['id_rol'];
             $idsecciones = $_POST['id_seccion'];
              

             for($i=0; $i < count($idsecciones); $i++){
                  //echo "seleccionados " . $idsecciones[$i] . "<br/>";
                  $UsuariosSecciones = new UsuariosSecciones;
                  $UsuariosSecciones->id_usuario = $model->id;
                  $UsuariosSecciones->id_seccion = $idsecciones[$i];
                  $UsuariosSecciones->insert(); 
             }

             $UsuariosSecciones = UsuariosSecciones::find()
                                  ->where(['id_usuario'=>$model->id])
                                  ->all();
                     
              return $this->redirect(['view', 'id' => $model->id,'UsuariosSecciones' => $UsuariosSecciones]);
               
           }
        } else {
            return $this->render('update', [
                'model' => $model,
                'roles' => $roles,
                'secciones' => $secciones,
            ]);
        }
    }

    /**
     * Deletes an existing Usuarios model.
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
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
