<?php

namespace app\modules\category\models;

use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
	use NestedSetsQueryTrait;
}
