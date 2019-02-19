<?php

namespace app\models;
use yii\data\ActiveDataProvider;

use Yii;

/**
 * This is the model class for table "beneficiarios".
 *
 * @property integer $id_persona
 * @property string $apeynom
 * @property integer $documento
 * @property string $cuil
 * @property string $fecha_nacimiento
 * @property string $lugar_nacimiento
 * @property string $domicilio
 * @property string $telefono_celular
 * @property string $telefono_fijo
 * @property integer $estado
 * @property string $pdf_cuil
 * @property string $pdf_dni
 */
class Beneficiarios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public $file1;

    public static function tableName()
    {
        return 'beneficiarios';

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apeynom', 'documento'], 'required'],
            [['documento', 'estado'], 'integer'],
            [['apeynom', 'domicilio'], 'string', 'max' => 100],
            [['cuil'], 'string', 'max' => 15],
            [['file','file1'],'file'],
            [['fecha_nacimiento', 'telefono_celular', 'telefono_fijo'], 'string', 'max' => 45],
            [['lugar_nacimiento', 'pdf_cuil', 'pdf_dni'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_persona' => 'Id Persona',
            'apeynom' => 'Nombre y apellido',
            'documento' => 'DNI',
            'cuil' => 'CUIL',
            'fecha_nacimiento' => 'Fecha de nacimiento',
            'lugar_nacimiento' => 'Lugar de nacimiento',
            'domicilio' => 'Domicilio',
            'telefono_celular' => 'Teléfono celular',
            'telefono_fijo' => 'Teléfono fijo',
            'estado' => 'Estado',
            'file' => 'Archivo PDF de DNI',
            'file1' => 'Archivo PDF de CUIL',
        ];
    }

    public function getAyudas()
    {
        return $this->hasMany(Ayudas::className(), ['id_beneficiario' => 'id_beneficiario']);
    }

    public static function getAllAyudas($id) {

        $query = Ayudas::find()->where(['id_beneficiario' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;

    }
}
