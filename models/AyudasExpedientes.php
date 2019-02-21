<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ayudas_expedientes".
 *
 * @property integer $id
 * @property integer $id_ayuda
 * @property integer $id_expediente
 */
class AyudasExpedientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ayudas_expedientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ayuda', 'id_expediente'], 'required'],
            [['id_ayuda', 'id_expediente'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ayuda' => 'Id Ayuda',
            'id_expediente' => 'Id Expediente',
        ];
    }
}
