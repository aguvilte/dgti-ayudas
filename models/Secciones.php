<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "secciones".
 *
 * @property integer $id_seccion
 * @property string $nombre
 * @property integer $id_rol
 */
class Secciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'secciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'id_rol'], 'required'],
            [['id_rol'], 'integer'],
            [['nombre'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_seccion' => 'Id Seccion',
            'nombre' => 'Nombre',
            'id_rol' => 'Id Rol',
        ];
    }
}
