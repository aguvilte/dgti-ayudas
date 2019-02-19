<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\Beneficiarios;
use app\models\Ayudas;
use app\models\AyudasSearch;
use app\models\TiposAyudas;
use app\models\Estados;
use app\models\Usuarios;
use app\models\Devoluciones;

/**
 * BeneficioController implements the CRUD actions for Beneficio model.
 */
class ListadoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','excel_general_ayudas','excel_iniciados','excel_en_proceso','excel_inconvenientes','excel_pagadas'],
                'rules' => [
                  [
                      //El administrador tiene permisos sobre las siguientes acciones
                      'actions' => ['index','excel_general_ayudas','excel_iniciados','excel_en_proceso','excel_inconvenientes','excel_pagadas'],
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
                      'actions' => ['index','excel_general_ayudas','excel_iniciados','excel_en_proceso','excel_inconvenientes','excel_pagadas'],
                      'allow' => true,
                      'roles' => ['@'],
                      'matchCallback' => function ($rule, $action) {
                         return Usuarios::isListado(Yii::$app->user->identity->id);
                     },
                   ],
              ],
            ],
        ];
    }
    

    /**
     * Lists all Beneficio models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
      }

    public function actionExcel_general_ayudas()
        {

              $ayudas = Ayudas::find()
                          ->orderBy(['id_ayuda'=>SORT_DESC])   
                          ->all();

              $filename = 'Informe General de Ayudas-'.Date('YmdGis').'.xls';
              header("Content-type: application/vnd-ms-excel");
              header("Content-Disposition: attachment; filename=".$filename);
              echo '<table border="1" width="100%">
                  <thead>
                      <tr>
                          <th></th>
                          <th>Apellido y Nombre</th>
                          <th>Documento</th>
                          <th>Tipo Ayuda</th>
                          <th>Estado</th>
                          <th>Monto</th>
                          <th>Area</th>
                          <th>Fecha de Pago</th>
                          <th>Fecha de Entrada</th>
                          <th>Fecha de Nota</th>

                      </tr>
                  </thead>';
                  $i=0;
                  foreach($ayudas as $ayuda){
                    $i++;

                    /*BUSCO DATOS DEL Beneficiario*/
                    $idpersona=$ayuda->id_persona;

                    $persona = Beneficiarios::find()
                                ->where(['id_persona'=>$idpersona])
                                ->one();


                    $tipoayuda = TiposAyudas::findOne($ayuda->id_tipo);
                    if ($tipoayuda !== null) {
                    $tipoayuda=$tipoayuda->nombre;
                    } else {
                       $tipoayuda='';
                    } 

                    $estado = Estados::findOne($ayuda->id_estado);
                    if ($estado !== null) {
                    $estado=$estado->nombre;
                    } else {
                       $estado='';
                     }
                    

                    echo '
                        <tr>
                            <td>'.$i.'</td>
                            <td>'.$persona['apeynom'].'</td>
                            <td>'.$persona['documento'].'</td>
                            <td>'.$tipoayuda.'</td>
                            <td>'.$estado.'</td>
                            <td>'.$ayuda['monto'].'</td>
                            <td>'.$ayuda['area'].'</td>
                            <td>'.$ayuda['fecha_pago'].'</td>
                            <td>'.$ayuda['fecha_entrada'].'</td>
                            <td>'.$ayuda['fecha_nota'].'</td>
                        </tr>
                    ';
                  }
              echo '</table>';
        }

    public function actionExcel_iniciados()
        {

              $ayudas = Ayudas::find()
                          ->where(['id_estado'=>1])
                          ->orderBy(['id_ayuda'=>SORT_DESC])   
                          ->all();

              $filename = 'Informe General de Ayudas Iniciadas-'.Date('YmdGis').'.xls';
              header("Content-type: application/vnd-ms-excel");
              header("Content-Disposition: attachment; filename=".$filename);
              echo '<table border="1" width="100%">
                  <thead>
                      <tr>
                          <th></th>
                          <th>Apellido y Nombre</th>
                          <th>Documento</th>
                          <th>Tipo Ayuda</th>
                          <th>Estado</th>
                          <th>Monto</th>
                          <th>Area</th>
                          <th>Fecha de Pago</th>
                          <th>Fecha de Entrada</th>
                          <th>Fecha de Nota</th>

                      </tr>
                  </thead>';
                  $i=0;
                  foreach($ayudas as $ayuda){
                    $i++;

                    /*BUSCO DATOS DEL Beneficiario*/
                    $idpersona=$ayuda->id_persona;

                    $persona = Beneficiarios::find()
                                ->where(['id_persona'=>$idpersona])
                                ->one();


                    $tipoayuda = TiposAyudas::findOne($ayuda->id_tipo);
                    if ($tipoayuda !== null) {
                    $tipoayuda=$tipoayuda->nombre;
                    } else {
                       $tipoayuda='';
                    } 

                    $estado = Estados::findOne($ayuda->id_estado);
                    if ($estado !== null) {
                    $estado=$estado->nombre;
                    } else {
                       $estado='';
                     }
                    

                    echo '
                        <tr>
                            <td>'.$i.'</td>
                            <td>'.$persona['apeynom'].'</td>
                            <td>'.$persona['documento'].'</td>
                            <td>'.$tipoayuda.'</td>
                            <td>'.$estado.'</td>
                            <td>'.$ayuda['monto'].'</td>
                            <td>'.$ayuda['area'].'</td>
                            <td>'.$ayuda['fecha_pago'].'</td>
                            <td>'.$ayuda['fecha_entrada'].'</td>
                            <td>'.$ayuda['fecha_nota'].'</td>
                        </tr>
                    ';
                  }
              echo '</table>';
        }

    public function actionExcel_en_proceso()
        {

              $ayudas = Ayudas::find()
                          ->where(['id_estado'=>2])
                          ->orderBy(['id_ayuda'=>SORT_DESC])   
                          ->all();

              $filename = 'Informe General de Ayudas En Proceso-'.Date('YmdGis').'.xls';
              header("Content-type: application/vnd-ms-excel");
              header("Content-Disposition: attachment; filename=".$filename);
              echo '<table border="1" width="100%">
                  <thead>
                      <tr>
                          <th></th>
                          <th>Apellido y Nombre</th>
                          <th>Documento</th>
                          <th>Tipo Ayuda</th>
                          <th>Estado</th>
                          <th>Monto</th>
                          <th>Area</th>
                          <th>Fecha de Pago</th>
                          <th>Fecha de Entrada</th>
                          <th>Fecha de Nota</th>

                      </tr>
                  </thead>';
                  $i=0;
                  foreach($ayudas as $ayuda){
                    $i++;

                    /*BUSCO DATOS DEL Beneficiario*/
                    $idpersona=$ayuda->id_persona;

                    $persona = Beneficiarios::find()
                                ->where(['id_persona'=>$idpersona])
                                ->one();


                    $tipoayuda = TiposAyudas::findOne($ayuda->id_tipo);
                    if ($tipoayuda !== null) {
                    $tipoayuda=$tipoayuda->nombre;
                    } else {
                       $tipoayuda='';
                    } 

                    $estado = Estados::findOne($ayuda->id_estado);
                    if ($estado !== null) {
                    $estado=$estado->nombre;
                    } else {
                       $estado='';
                     }
                    

                    echo '
                        <tr>
                            <td>'.$i.'</td>
                            <td>'.$persona['apeynom'].'</td>
                            <td>'.$persona['documento'].'</td>
                            <td>'.$tipoayuda.'</td>
                            <td>'.$estado.'</td>
                            <td>'.$ayuda['monto'].'</td>
                            <td>'.$ayuda['area'].'</td>
                            <td>'.$ayuda['fecha_pago'].'</td>
                            <td>'.$ayuda['fecha_entrada'].'</td>
                            <td>'.$ayuda['fecha_nota'].'</td>
                        </tr>
                    ';
                  }
              echo '</table>';
        }

    public function actionExcel_inconvenientes()
        {
              
              $ayudas = Ayudas::find()
                          ->orderBy(['id_ayuda'=>SORT_DESC])   
                          ->all();

              $filename = 'Informe General de Ayudas que tuvieron Inconvenientes-'.Date('YmdGis').'.xls';
              header("Content-type: application/vnd-ms-excel");
              header("Content-Disposition: attachment; filename=".$filename);
              echo '<table border="1" width="100%">
                  <thead>
                      <tr>
                          <th></th>
                          <th>Apellido y Nombre</th>
                          <th>Documento</th>
                          <th>Tipo Ayuda</th>
                          <th>Estado</th>
                          <th>Monto</th>
                          <th>Area</th>
                          <th>Fecha de Pago</th>
                          <th>Fecha de Entrada</th>
                          <th>Fecha de Nota</th>

                      </tr>
                  </thead>';
                  $i=0;
                  foreach($ayudas as $ayuda){

                        $CountDevoluciones = Devoluciones::find()
                                          ->where(['id_ayuda'=>$ayuda->id_ayuda])
                                          ->count();
                  if($CountDevoluciones>0)
                  {
                    $i++;
                    
                    /*BUSCO DATOS DEL Beneficiario*/
                    $idpersona=$ayuda->id_persona;

                    $persona = Beneficiarios::find()
                                ->where(['id_persona'=>$idpersona])
                                ->one();


                    $tipoayuda = TiposAyudas::findOne($ayuda->id_tipo);
                    if ($tipoayuda !== null) {
                    $tipoayuda=$tipoayuda->nombre;
                    } else {
                       $tipoayuda='';
                    } 

                    $estado = Estados::findOne($ayuda->id_estado);
                    if ($estado !== null) {
                    $estado=$estado->nombre;
                    } else {
                       $estado='';
                     }
                    

                    echo '
                        <tr>
                            <td>'.$i.'</td>
                            <td>'.$persona['apeynom'].'</td>
                            <td>'.$persona['documento'].'</td>
                            <td>'.$tipoayuda.'</td>
                            <td>'.$estado.'</td>
                            <td>'.$ayuda['monto'].'</td>
                            <td>'.$ayuda['area'].'</td>
                            <td>'.$ayuda['fecha_pago'].'</td>
                            <td>'.$ayuda['fecha_entrada'].'</td>
                            <td>'.$ayuda['fecha_nota'].'</td>
                        </tr>
                    ';
                  }
                }
              echo '</table>';
        }


    public function actionExcel_pagadas()
        {

              $ayudas = Ayudas::find()
                          ->where(['id_estado'=>3])
                          ->orderBy(['id_ayuda'=>SORT_DESC])   
                          ->all();

              $filename = 'Informe General de Ayudas Pagadas-'.Date('YmdGis').'.xls';
              header("Content-type: application/vnd-ms-excel");
              header("Content-Disposition: attachment; filename=".$filename);
              echo '<table border="1" width="100%">
                  <thead>
                      <tr>
                          <th></th>
                          <th>Apellido y Nombre</th>
                          <th>Documento</th>
                          <th>Tipo Ayuda</th>
                          <th>Estado</th>
                          <th>Monto</th>
                          <th>Area</th>
                          <th>Fecha de Pago</th>
                          <th>Fecha de Entrada</th>
                          <th>Fecha de Nota</th>

                      </tr>
                  </thead>';
                  $i=0;
                  foreach($ayudas as $ayuda){
                    $i++;

                    /*BUSCO DATOS DEL Beneficiario*/
                    $idpersona=$ayuda->id_persona;

                    $persona = Beneficiarios::find()
                                ->where(['id_persona'=>$idpersona])
                                ->one();


                    $tipoayuda = TiposAyudas::findOne($ayuda->id_tipo);
                    if ($tipoayuda !== null) {
                    $tipoayuda=$tipoayuda->nombre;
                    } else {
                       $tipoayuda='';
                    } 

                    $estado = Estados::findOne($ayuda->id_estado);
                    if ($estado !== null) {
                    $estado=$estado->nombre;
                    } else {
                       $estado='';
                     }
                    

                    echo '
                        <tr>
                            <td>'.$i.'</td>
                            <td>'.$persona['apeynom'].'</td>
                            <td>'.$persona['documento'].'</td>
                            <td>'.$tipoayuda.'</td>
                            <td>'.$estado.'</td>
                            <td>'.$ayuda['monto'].'</td>
                            <td>'.$ayuda['area'].'</td>
                            <td>'.$ayuda['fecha_pago'].'</td>
                            <td>'.$ayuda['fecha_entrada'].'</td>
                            <td>'.$ayuda['fecha_nota'].'</td>
                        </tr>
                    ';
                  }
              echo '</table>';
        }
}

