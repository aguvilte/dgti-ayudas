<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Expedientes;

/**
 * ExpedientesSearch represents the model behind the search form about `app\models\Expedientes`.
 */
class ExpedientesSearch extends Expedientes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_expediente', 'estado'], 'integer'],
            [['numero', 'fecha_alta', 'fecha_cierre'], 'safe'],
            [['monto_total'], 'number'],
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
        $query = Expedientes::find();

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
            'id_expediente' => $this->id_expediente,
            'monto_total' => $this->monto_total,
            'estado' => $this->estado,
            'fecha_alta' => $this->fecha_alta,
            'fecha_cierre' => $this->fecha_cierre,
        ]);

        $query->andFilterWhere(['like', 'numero', $this->numero]);

        return $dataProvider;
    }
}
