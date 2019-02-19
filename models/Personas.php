<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "personas".
 *
 * @property integer $id_persona
 * @property integer $documento
 * @property string $apellido
 * @property string $nombre
 * @property integer $sexo
 * @property string $fecha_nacimiento
 * @property string $telefono
 * @property string $profesion
 */
class Personas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'personas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['documento', 'apellido', 'nombre', 'sexo'], 'required'],
            [['documento', 'sexo'], 'integer'],
            [['apellido', 'nombre', 'profesion','correo'], 'string', 'max' => 100],
            [['fecha_nacimiento', 'telefono'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_persona' => 'Id Persona',
            'documento' => 'Documento',
            'apellido' => 'Apellido',
            'nombre' => 'Nombre',
            'sexo' => 'Sexo',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'telefono' => 'Telefono',
            'profesion' => 'Profesion',
            'correo' => 'Correo',
        ];
    }
}
