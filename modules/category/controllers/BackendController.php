<?php

namespace app\modules\category\controllers;

use app\modules\category\forms\CategoryForm;
use app\modules\category\helpers\CategoryHelper;
use app\modules\category\models\CategorySearch;
use app\modules\category\repositories\CategoryRepository;
use app\modules\category\services\CategoryService;
use DomainException;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class BackendController extends Controller
{
	private $categories;
	private $service;

	public function __construct(
		$id,
		$module,
		CategoryRepository $categories,
		CategoryService $service,
		$config = []
	)
	{
		parent::__construct($id, $module, $config);
		$this->categories = $categories;
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
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', compact('dataProvider', 'searchModel'));
    }

    public function actionCreate()
    {
	    $categoryForm = new CategoryForm();

	    if ($categoryForm->load(Yii::$app->request->post()) && $categoryForm->validate()) {
		    try {
			    $category = $this->service->create($categoryForm);
			    return $this->redirect(['update', 'id' => $category->id]);
		    } catch (DomainException $e) {
			    Yii::$app->errorHandler->logException($e);
			    Yii::$app->session->setFlash('error', $e->getMessage());
		    }
	    }

        [$dropDownArray, $dropDownOptionsArray] = CategoryHelper::generateDropDownArrays();

        return $this->render('create', compact('categoryForm', 'dropDownArray', 'dropDownOptionsArray'));
    }

    public function actionUpdate($id)
    {
        $category = $this->categories->get($id);
	    $categoryForm = new CategoryForm($category);

        if ($categoryForm->load(Yii::$app->request->post()) && $categoryForm->validate()) {
	        try {
		        $this->service->edit($category->id, $categoryForm);
		        return $this->refresh();
	        } catch (DomainException $e) {
		        Yii::$app->errorHandler->logException($e);
		        Yii::$app->session->setFlash('error', $e->getMessage());
	        }
        }

        [$dropDownArray, $dropDownOptionsArray] = CategoryHelper::generateDropDownArrays($category);

        return $this->render('update', compact('category', 'categoryForm', 'dropDownArray', 'dropDownOptionsArray'));
    }

    public function actionDelete($id)
    {
	    $category = $this->categories->get($id);

	    try {
	    	$this->service->delete($category->id);
	    } catch (DomainException $e) {
		    Yii::$app->errorHandler->logException($e);
		    Yii::$app->session->setFlash('error', $e->getMessage());
	    }

        return $this->redirect(['index']);
    }

    public function actionMoveUp($id)
    {
	    $category = $this->categories->get($id);

	    try {
	    	$this->service->moveUp($category->id);
	    } catch (DomainException $e) {
		    Yii::$app->errorHandler->logException($e);
		    Yii::$app->session->setFlash('error', $e->getMessage());
	    }

	    return $this->redirect(['index']);
    }

    public function actionMoveDown($id)
    {
	    $category = $this->categories->get($id);

	    try {
		    $this->service->moveDown($category->id);
	    } catch (DomainException $e) {
		    Yii::$app->errorHandler->logException($e);
		    Yii::$app->session->setFlash('error', $e->getMessage());
	    }

	    return $this->redirect(['index']);
    }
}
