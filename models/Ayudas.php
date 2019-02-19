<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ayudas".
 *
 * @property integer $id_ayuda
 * @property string $tipo
 * @property integer $estado
 * @property integer $entrega_dni
 * @property integer $entrega_cuil
 * @property string $asunto
 * @property string $monto
 * @property string $fecha_nota
 * @property string $fecha_entrada
 * @property string $fecha_pago
 * @property string $doc_adjunta
 * @property string $area
 * @property string $encargado
 * @property string $pdf_doc_adjunta
 * @property string $pdf_nota
 * @property string $pdf_gestor
 * @property string $pdf_domicilio
 * @property integer $id_persona
 */
class Ayudas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public $file1;
    public $file2;
    public $file3;

    public static function tableName()
    {
        return 'ayudas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_estado', 'id_persona','id_tipo','entrega_dni', 'entrega_cuil'], 'integer'],
            [['fecha_entrada', 'id_persona', 'id_tipo', 'monto','id_estado'], 'required'],
             [['fecha_nota', 'fecha_entrada', 'fecha_pago'], 'safe'],
            [['monto'], 'string', 'max' => 45],
            [['asunto', 'area', 'encargado'], 'string', 'max' => 100],
            [['file','file1','file2','file3'],'file'],
            [['id_persona'], 'exist', 'skipOnError' => true, 'targetClass' => Beneficiarios::className(), 'targetAttribute' => ['id_persona' => 'id_persona']],
            [['doc_adjunta', 'pdf_doc_adjunta', 'pdf_nota', 'pdf_gestor', 'pdf_domicilio'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ayuda' => 'Id Ayuda',
            'id_tipo' => 'Tipo de Ayuda',
            'id_estado' => 'Estado del Trámite',
            'entrega_dni' => 'Entrega Dni',
            'entrega_cuil' => 'Entrega Cuil',
            'asunto' => 'Asunto',
            'monto' => 'Monto',
            'fecha_nota' => 'Fecha Nota',
            'fecha_entrada' => 'Fecha Entrada',
            'fecha_pago' => 'Fecha Pago',
            'doc_adjunta' => 'Documentación Adjunta',
            'area' => 'Área',
            'encargado' => 'Encargado del Área',
            'file' => 'Pdf Documentación Adjunta',
            'file1' => 'Pdf Gestor',
            'file2' => 'Pdf Nota',
            'file3' => 'Pdf Domicilio',
            'id_persona' => 'Id Persona',
        ];
    }

    public function getIdBeneficiarios()
    {
        return $this->hasOne(Beneficiarios::className(), ['id_persona' => 'id_persona']);
    }
}
