<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Devoluciones;

/**
 * DevolucionesSearch represents the model behind the search form about `app\models\Devoluciones`.
 */
class DevolucionesSearch extends Devoluciones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_devolucion', 'id_usuario', 'id_ayuda'], 'integer'],
            [['fecha', 'descripcion'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Devoluciones::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_devolucion' => $this->id_devolucion,
            'id_usuario' => $this->id_usuario,
            'id_ayuda' => $this->id_ayuda,
            'descripcion' => $this->descripcion,
            'fecha' => $this->fecha,
        ]);

        return $dataProvider;
    }
}
