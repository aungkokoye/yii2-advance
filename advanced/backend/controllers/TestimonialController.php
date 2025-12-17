<?php
declare(strict_types=1);

namespace backend\controllers;

use common\models\File;
use common\models\Project;
use common\models\ProjectImage;
use common\models\Testimonial;
use backend\models\TestimonialSearch;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TestimonialController implements the CRUD actions for Testimonial model.
 *
 * @property-read array $projectDropdownData
 */
class TestimonialController extends Controller
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
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Testimonial models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new TestimonialSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'projects'      => ArrayHelper::map(Project::find()->all(), 'id', 'name'),
        ]);
    }

    /**
     * Displays a single Testimonial model.
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
     * Creates a new Testimonial model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws Exception
     * @throws \Throwable
     */
    public function actionCreate(): string|Response
    {
        $model = new Testimonial();

        if ($this->request->isPost && $model->load($this->request->post()) ) {
            $model->uploadImageFile();
            if ($model->uploadImage()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->project_id = $this->request->get('project_id');
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'projectsDropdownData' => $this->getProjectDropdownData(),
        ]);
    }

    /**
     * Updates an existing Testimonial model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
     * @throws NotFoundHttpException|Exception if the model cannot be found
     * @throws \Throwable
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->uploadImageFile();
            if ($model->uploadImage() && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'projectsDropdownData' => $this->getProjectDropdownData(),
        ]);
    }

    /**
     *  Deletes an existing Testimonial model.
     *  If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @throws StaleObjectException
     * @throws \Throwable
     * @throws NotFoundHttpException
     */
    public function actionDeleteImage(): Response
    {
        $image = File::findOne(['id' => $this->request->post('key')]);
        if(!$image) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested image file does not exist.'));
        }

        if ($image->delete()) {
            return $this->asJson(null);
        }

        return $this->asJson(['error' => true]);
    }

    /**
     * Finds the Testimonial model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Testimonial the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Testimonial
    {
        if (($model = Testimonial::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    private function getProjectDropdownData(): array
    {
        return ArrayHelper::map(Project::find()->all(), 'id', 'name');
    }
}
