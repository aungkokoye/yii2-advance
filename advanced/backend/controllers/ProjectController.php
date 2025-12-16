<?php
declare(strict_types=1);

namespace backend\controllers;

use common\models\Project;
use backend\models\ProjectSearch;
use common\models\ProjectImage;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete'                => ['POST'],
                        'delete-project-image'  => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Project models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws Exception
     * @throws \Throwable
     */
    public function actionCreate(): string|Response
    {
        $model = new Project();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->uploadedFile = UploadedFile::getInstance($model, 'uploadedFile');
            if ($model->save()) {
                $model->uploadImage();
                Yii::$app->session->setFlash('success', 'Project created successfully.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
     * @throws NotFoundHttpException|Exception if the model cannot be found
     * @throws \Throwable
     */
    public function actionUpdate(int $id): string|Response
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->uploadedFile = UploadedFile::getInstance($model, 'uploadedFile');
            if($model->save()) {
                $model->uploadImage();
                Yii::$app->session->setFlash('success', 'Project updated successfully.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException| Exception|\Throwable if the model cannot be found
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', 'Project deleted successfully.');

        return $this->redirect(['index']);
    }

    /**
     * Deletes a project image via AJAX.
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDeleteProjectImage(): Response
    {
        /** Krajee FileInput plugin delete Ajax event sends key as delete file key, not id */
        $image = ProjectImage::findOne(['id' => $this->request->post('key')]);
        if(!$image) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested image file does not exist.'));
        }

        /** https://plugins.krajee.com/file-input/plugin-options#deleteUrl */
        if ($image->file->delete()) {
            return $this->asJson(null);
        }

        return $this->asJson(['error' => true]);
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Project
    {
        if (($model = Project::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
