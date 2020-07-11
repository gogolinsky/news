<?php

namespace app\modules\news\controllers;

use app\modules\news\forms\NewsForm;
use app\modules\news\models\NewsSearch;
use app\modules\news\repositories\NewsRepository;
use app\modules\news\services\NewsService;
use DomainException;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class BackendController extends Controller
{
	private $news;
	private $service;

	public function __construct(
		$id,
		$module,
		NewsRepository $news,
		NewsService $service,
		$config = []
	)
	{
		parent::__construct($id, $module, $config);
		$this->news = $news;
		$this->service = $service;
	}

	public function behaviors(): array
	{
		return [
			[
				'class' => VerbFilter::class,
				'actions' => [
					'delete' => ['POST', 'DELETE'],
				],
			],
		];
	}

	public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', compact('dataProvider', 'searchModel'));
    }

    public function actionCreate()
    {
	    $newsForm = new NewsForm();

	    if ($newsForm->load(Yii::$app->request->post()) && $newsForm->validate()) {
		    try {
			    $news = $this->service->create($newsForm);
			    return $this->redirect(['update', 'id' => $news->id]);
		    } catch (DomainException $e) {
			    Yii::$app->errorHandler->logException($e);
			    Yii::$app->session->setFlash('error', $e->getMessage());
		    }
	    }
	    return $this->render('create', compact('newsForm'));
    }

    public function actionUpdate($id)
    {
	    $news = $this->news->get($id);
	    $newsForm = new NewsForm($news);

	    if ($newsForm->load(Yii::$app->request->post()) && $newsForm->validate()) {
		    try {
			    $this->service->edit($news->id, $newsForm);
			    return $this->refresh();
		    } catch (DomainException $e) {
			    Yii::$app->errorHandler->logException($e);
			    Yii::$app->session->setFlash('error', $e->getMessage());
		    }
	    }

	    return $this->render('update', compact('newsForm', 'news'));
    }

    public function actionDelete($id)
    {
	    $news = $this->news->get($id);

	    try {
		    $this->service->delete($news->id);
	    } catch (DomainException $e) {
		    Yii::$app->errorHandler->logException($e);
		    Yii::$app->session->setFlash('error', $e->getMessage());
	    }

        return $this->redirect(['index']);
    }
}
