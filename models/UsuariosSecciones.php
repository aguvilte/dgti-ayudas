<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios_secciones".
 *
 * @property integer $id_usuario
 * @property integer $id_seccion
 */
class UsuariosSecciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios_secciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_seccion'], 'required'],
            [['id_usuario', 'id_seccion'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_usuario' => 'Id Usuario',
            'id_seccion' => 'Id Seccion',
        ];
    }
}
