<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Observaciones;

/**
 * ObservacionesSearch represents the model behind the search form about `app\models\Observaciones`.
 */
class ObservacionesSearch extends Observaciones
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_observacion', 'id_ayuda', 'id_usuario'], 'integer'],
            [['descripcion', 'fecha_observacion'], 'safe'],
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
        $query = Observaciones::find();

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
            'id_observacion' => $this->id_observacion,
            'id_ayuda' => $this->id_ayuda,
            'id_usuario' => $this->id_usuario,
            'fecha_observacion' => $this->fecha_observacion,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
