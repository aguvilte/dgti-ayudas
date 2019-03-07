<?php

namespace app\controllers;

use Yii;
use app\components\RegistroMovimientos;
use app\models\Ayudas;
use app\models\Beneficiarios;
use app\models\BeneficiariosSearch;
use app\models\Usuarios;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class BeneficiariosController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'create',
                    'historial',
                    'index',
                    'pdf_historial',
                    'update',
                    'updatepdfcuil',
                    'updatepdfdni',
                    'view',
                ],
                'rules' => [
                    [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['view','updatepdfdni','updatepdfcuil','update','index','historial','create','historial','pdf_historial'],
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
                        'actions' => ['view','updatepdfdni','updatepdfcuil','update','index','historial','create'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Usuarios::isBeneficiarios(Yii::$app->user->identity->id);
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new BeneficiariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize = 20;

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
        /*Se valida antes de crear que no exista un beneficiario con el mismo DNI*/
        $model = new Beneficiarios();

        if ($model->load(Yii::$app->request->post())) {
            $documento = $model->documento;
            $beneficiario = Beneficiarios::find()
                ->where(['documento' => $documento])
                ->one();

            if ($beneficiario != NULL) {
                if ($beneficiario->estado == 1) {
                    throw new NotFoundHttpException('Ya existe un beneficiario con el DNI ingresado');
                } 
                else {
                    // $Beneficiario = $this->findModel($Beneficiario->id_beneficiario);
                    $beneficiario->estado = 1;
                    $beneficiario->save();

                    RegistroMovimientos::registrarMovimiento(1, 'REACTIVACIÓN', $beneficiario->id_beneficiario);

                    return $this->render('mensaje_exito', [
                        'id' => $beneficiario->id_beneficiario,
                    ]);
                }
            }

            else {
                //$nombrePdf = $model->documento;
                $nombrePdf = str_replace("/", "-", $model->documento);
                $model->file = UploadedFile::getInstance($model, 'file');

                if(!empty($model->file)) {
                    /*Guardamos pdf en carpeta uploads*/ 
                    $model->file->saveAs('uploads/Pdf-DNI/' . $nombrePdf . '.' . $model->file->extension);

                    /*Le asignamos en la db la ruta donde esta el pdf*/ 
                    $model->pdf_dni = 'uploads/Pdf-DNI/' . $nombrePdf . '.' . $model->file->extension;
                }

                $nombrePdf1 = str_replace("/", "-", $model->documento);
                $model->file1 = UploadedFile::getInstance($model, 'file1');

                if(!empty($model->file1)) {
                    $model->file1->saveAs('uploads/Pdf-CUIL/' . $nombrePdf1 . '.' . $model->file1->extension);
                    $model->pdf_cuil = 'uploads/Pdf-CUIL/' . $nombrePdf1 . '.' . $model->file1->extension;
                }

                $model->save();

                RegistroMovimientos::registrarMovimiento(1, 'CREACIÓN', $model->id_beneficiario);

                return $this->redirect(['view', 'id' => $model->id_beneficiario]);
            }
        }
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            RegistroMovimientos::registrarMovimiento(1, 'ACTUALIZACIÓN', $model->id_beneficiario);

            return $this->redirect(['view', 'id' => $model->id_beneficiario]);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdatepdfdni($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $nombrePdf = str_replace("/", "-", $model->documento);
            $nombrePdf = $model->id_beneficiario . '-' . $nombrePdf;
            $model->file = UploadedFile::getInstance($model, 'file');

            if(!empty($model->file)){
                /*Guardamos pdf en carpeta uploads*/
                $model->file->saveAs('uploads/Pdf-DNI/' . $nombrePdf . '.' . $model->file->extension);

                /*Le asignamos en la db la ruta donde esta el pdf*/
                $model->pdf_dni = 'uploads/Pdf-DNI/' . $nombrePdf . '.' . $model->file->extension;

                //ACTUALIZAMOS EL PDF
                $pdf_dni = $model->pdf_dni;
                $id_beneficiario = $model->id_beneficiario;

                $condition = [
                    'and',
                    ['=', 'id_beneficiario', $id_beneficiario],
                ];

                Beneficiarios::updateAll(['pdf_dni' => $pdf_dni],$condition);

                return $this->redirect(['view', 'id' => $model->id_beneficiario]);

            } else {
                throw new NotFoundHttpException('Seleccione un archivo');
            }
        } else {
            return $this->render('updatepdfdni', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdatepdfcuil($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $nombrePdf1 = str_replace("/","-", $model->documento);
            $nombrePdf1 = $model->id_beneficiario . '-' . $nombrePdf1;
            $model->file1 = UploadedFile::getInstance($model,'file1');

            if (!empty($model->file1)) {
                $model->file1->saveAs('uploads/Pdf-CUIL/' . $nombrePdf1 . '.' . $model->file1->extension);
                $model->pdf_cuil = 'uploads/Pdf-CUIL/' . $nombrePdf1 . '.' . $model->file1->extension;

                $pdf_cuil = $model->pdf_cuil;
                $id_beneficiario = $model->id_beneficiario;

                $condition = [
                    'and',
                    ['=', 'id_beneficiario', $id_beneficiario],
                ];

                Beneficiarios::updateAll(['pdf_cuil' => $pdf_cuil],$condition);

                return $this->redirect(['view', 'id' => $model->id_beneficiario]);

            } else {
                throw new NotFoundHttpException('Seleccione un archivo');
            }

        } else {
            return $this->render('updatepdfcuil', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionDelete($id)
    {
        $persona = Beneficiarios::find()
            ->where(['id_beneficiario' => $id])
            ->one();

        $countIniciadas= Ayudas::find()
            ->where(['id_tipo' => $id])
            ->andwhere(['id_estado' => 1])
            ->count();

        $countEnproceso= Ayudas::find()
            ->where(['id_tipo' => $id])
            ->andwhere(['id_estado' => 2])
            ->count();
                    
        if ($countIniciadas>0 or $countEnproceso>0) {
            throw new NotFoundHttpException('No puede eliminar esta persona. Cuenta con ayudas iniciadas o en proceso.');
        } else {
            $persona->estado=0;
            $persona->save();
            
            RegistroMovimientos::registrarMovimiento(1, 'ELIMINACIÓN', $persona->id_beneficiario);    
        }
        
        return $this->redirect(['index']);
    }

    public function actionHistorial($id)
    { 
      //ESTA ACCION NO SE UTILIZA
        $ayudas = Ayudas::find()
            ->where(['id_beneficiario' => $id])
            ->orderBy(['id_ayuda' => SORT_DESC])
            ->all();

        $persona= Beneficiarios::find()
            ->where(['id_beneficiario' => $id])
            ->one();

        $countayudas = Ayudas::find()
            ->where(['id_beneficiario' => $id])
            ->count();

        if($countayudas > 0) {
            return $this->render('historial', [
                'ayudas' => $ayudas,
                'persona' => $persona,
            ]);
        } else {
            throw new NotFoundHttpException('El Beneficiario seleccionado no posee Registros de Ayudas.');
        }
    }

    public function actionPdf_historial($id)
    {
        //ESTA ACCION NO SE UTILIZA
        /*BUSCO SI TIENE AL MENOS UN BENEFICIO*/
        $countAyudas = Ayudas::find()
            ->where(['id_beneficiario' => $id])
            ->count();

        /*BUSCO DATOS DEL BENEFICIO*/
        $ayudas = Ayudas::find()
            ->where(['id_beneficiario' => $id])
            ->all();

        return $this->render('pdf_historial', [
            'ayudas' => $ayudas,
            'id' => $id,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Beneficiarios::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
