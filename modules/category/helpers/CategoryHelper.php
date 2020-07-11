<?php

namespace app\modules\category\helpers;

use app\modules\category\models\Category;

class CategoryHelper
{
    /**
     * @param null|Category $model
     * @return array
     */
    public static function generateDropDownArrays($model = null)
    {
        /** @var Category[] $categories */
        $categories = Category::find()->orderBy(['lft' => SORT_ASC])->all();
        $dropDownArray = [];
        $dropDownOptionsArray = ['encodeSpaces' => false];

        foreach ($categories as $item) {
            $dropDownArray[$item->id] = $item->getNestedTitle();

            if (null !== $model && $item->id === $model->id) {
                $dropDownOptionsArray['options'][$item->id]['disabled'] = true;
            }
        }

        return [$dropDownArray, $dropDownOptionsArray];
    }

    public static function getCategoryIds(Category $category)
    {
        $result = $category->children()->select('id')->column();
        $result[] = $category->id;

        return $result;
    }
}