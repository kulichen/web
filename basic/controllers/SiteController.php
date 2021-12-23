<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\UploadImage;
use app\models\Images;
use app\models\Tableimg;
use app\models\Users;
use app\models\EditImages;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', ['model' => $model]);
    }

    public function actionSingup()
    {
        $model = new Users();
        if($model->load(Yii::$app->request->post()))
        {
            if(Users::findOne(['username' => $model->username])) {
                $model->username = '';
                $model->password = '';
                Yii::$app->session->setFlash('error', "Login is busy!");
                return $this->render('singup',['model'=>$model]);
            } else {
                $model->password = md5($model->password);
                $model->save();
                return $this->redirect(['login',$model]);  
            }   
        }
        return $this->render('singup',['model'=>$model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionUpload()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', "You need to login!");
            return $this->redirect(['/site/login']);
        }

        $model = new UploadImage();
        //var_dump(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post())) {
            $model->path = UploadedFile::getInstance($model, 'path');
            $model->caption = Yii::$app->request->post()['UploadImage']['caption'];
            //var_dump(Yii::$app->request->post()['UploadImage']['caption']);
            //$outT = UploadedFile::getInstance($model, 'path') . Yii::$app->request->post('caption');
            //Yii::$app->session->setFlash('error', 'asds' . $outT . 'asas');
            //var_dump($model->path->baseName);
            //die();
            //return;

            //return $this->render('upload', ['model' => $model]);
            if ($model->upload()) {
                // file is uploaded successfully
                return $this->redirect(['/site/gallery']);
                //return $this->render('upload', ['model' => $model]);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
    

    public function actionGallery()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', "You need to login!");
            return $this->redirect(['/site/login']);
        }

        $query = Images::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 6]);

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();


        return $this->render('gallery', ['models' => $models, 'pages' => $pages]);
    }

    public function actionEditimage()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', "You need to login!");
            return $this->redirect(['/site/login']);
        }

        $id_images = Yii::$app->request->get('id_images');
        $name = Yii::$app->request->get('name');
        $image_valid = Images::find()->where(['id_images' => $id_images]);

        if ($id_images == NULL) {
            Yii::$app->session->setFlash('error', 'ID is NULL!');
            return $this->redirect(['/site/gallery']);
        } 

        if (!$image_valid->exists()) {
            return $this->redirect(['/site/gallery']);
        } 

        //$model = new EditImages();
        //$image = Images::findOne($id_images);
        $model = Images::findOne($id_images);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->update()) {
                Yii::$app->session->setFlash('success', "Done!");
                return $this->redirect(['/site/gallery']);
            } else {
                if ($name = 'deleteimage') {
                    return $this->redirect(['/site/deleteimage']);
                }

                return $this->redirect(['/site/gallery']);
            }
        }

        return $this->render('editimage', [
            'model' => $model,
            'id_images' => $id_images,
        ]);
    }

    public function actionDeleteimage()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->session->setFlash('error', "You need to login!");
            return $this->redirect(['/site/login']);
        }

        $id_images = Yii::$app->request->get('id_images');
        $image_valid = Images::find()->where(['id_images' => $id_images]);
        if (!$image_valid->exists()) {
            Yii::$app->session->setFlash('error', "Invalid ID!");
            return $this->redirect(['/site/gallery']);
        }

        $model = Images::findOne($id_images);

        if(Yii::$app->request->isPost) {
            $model->delete();
            return $this->redirect(['/site/gallery']);    
        } 
        
        return $this->render('deleteimage', [
            'model' => $model,
            'id_images' => $id_images,
        ]);
    }
}
