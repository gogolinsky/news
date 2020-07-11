<?php

namespace app\modules\news\models;

use yii\data\ActiveDataProvider;

class NewsSearch extends News
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            ['title', 'string', 'max' => 255],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => self::find(),
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        if (!$this->load($params) || !$this->validate()) {
            return $dataProvider;
        }

        $dataProvider->query->andFilterWhere(['id' => $this->id]);
        $dataProvider->query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
