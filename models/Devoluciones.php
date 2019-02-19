<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "devoluciones".
 *
 * @property integer $id_devolucion
 * @property integer $id_usuario
 * @property integer $id_ayuda
 * @property integer $descripción
 * @property string $fecha
 */
class Devoluciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'devoluciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_ayuda', 'descripcion', 'fecha'], 'required'],
            [['id_usuario', 'id_ayuda'], 'integer'],
            [['descripcion'], 'string', 'max' => 250],
            [['fecha'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_devolucion' => 'Id Devolucion',
            'id_usuario' => 'Id Usuario',
            'id_ayuda' => 'Id Ayuda',
            'descripcion' => 'Descripcion',
            'fecha' => 'Fecha de la devolucion',
        ];
    }
}
