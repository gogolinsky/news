<?php

namespace app\modules\category\controllers;

use app\modules\category\repositories\CategoryRepository;
use app\modules\news\formatters\NewsFormatter;
use app\modules\news\repositories\NewsRepository;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class FrontendController extends Controller
{
	private $categories;
	private $news;
	private $formatter;

	public function __construct(
		$id,
		$module,
		CategoryRepository $categories,
		NewsRepository $news,
		NewsFormatter $formatter,
		$config = []
	)
	{
		parent::__construct($id, $module, $config);
		$this->categories = $categories;
		$this->news = $news;
		$this->formatter = $formatter;
	}

	public function actionTree()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;

		return $this->categories->getTree();
	}

	public function actionIndex()
    {
	    $news = $this->news->getAll();
    	Yii::$app->response->format = Response::FORMAT_JSON;

	    return $this->formatter->elements($news);
    }

	public function actionView($id)
    {
    	$category = $this->categories->get($id);
    	$ids = $this->categories->getNestedIds($category->id);
    	$news = $this->news->getForCategory($ids);
    	Yii::$app->response->format = Response::FORMAT_JSON;

    	return $this->formatter->elements($news);
    }
}
