<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "observaciones".
 *
 * @property integer $id_observacion
 * @property integer $id_ayuda
 * @property string $descripcion
 * @property integer $id_usuario
 * @property string $fecha_observacion
 */
class Observaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'observaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ayuda', 'descripcion', 'id_usuario', 'fecha_observacion'], 'required'],
            [['id_ayuda', 'id_usuario'], 'integer'],
            [['fecha_observacion'], 'safe'],
            [['descripcion'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_observacion' => 'Id Observacion',
            'id_ayuda' => 'Id Ayuda',
            'descripcion' => 'Descripcion',
            'id_usuario' => 'Id Usuario',
            'fecha_observacion' => 'Fecha Observacion',
        ];
    }
}
