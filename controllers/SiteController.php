<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Dataset1;

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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
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
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {

        set_time_limit(200);
        $dataset1 = Dataset1::find()->all();

        $marks = [
          'Отлично' => 5,
          'Хорошо' => 4,
          'Удовлетворительно' => 3,
          'Неудовлетворительно' => 2,
          'Неявка' => 10,
          'Зачтено' => 11,
          'Не зачтено' => 12,
          'Продление сессии' => 20,
        ];

        if (!$dataset1) {

            $filename = '../hakaton/hash_table.csv';

// The nested array to hold all the arrays
            $hashTable = [];

// Open the file for reading
            if (($h = fopen("{$filename}", "r")) !== FALSE) {
                // Each line in the file is converted into an individual array that we call $data
                // The items of the array are comma separated
                while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
                    // Each individual array is being pushed into the nested array
                    $hashTable[$data[0]] = $data[1];
                }

                // Close the file
                fclose($h);
            }

            $filename = '../hakaton/first.csv';

// The nested array to hold all the arrays
            $the_big_array = [];

// Open the file for reading
            if (($h = fopen("{$filename}", "r")) !== FALSE) {
                // Each line in the file is converted into an individual array that we call $data
                // The items of the array are comma separated
                while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
                    // Each individual array is being pushed into the nested array
                    $the_big_array[] = $data;
                }

                // Close the file
                fclose($h);
            }

            foreach ($the_big_array as $row) {
                if (!$row[1]) {
                    continue;
                }
                $record = new Dataset1();
                $record->predmet = $hashTable[$row[0]];
                $record->mark = $marks[$row[1]];
                $record->year = $row[2];
                $record->semestr = $row[3];
                $record->vedomost_type = $row[4];
                $record->ind_main = $row[5];
                $record->disc_po_v = $row[6];
                $record->save();
            }

        }

        $bar_2014 = \Yii::$app->db->createCommand(<<<SQL
        SELECT AVG(mark) FROM dataset_1
        WHERE mark IN (2,3,4,5)
        AND year = 2014
SQL
    )->queryScalar();

        $bar_2015 = \Yii::$app->db->createCommand(<<<SQL
        SELECT AVG(mark) FROM dataset_1
        WHERE mark IN (2,3,4,5)
        AND year = 2015
SQL
    )->queryScalar();

        $bar_2016 = \Yii::$app->db->createCommand(<<<SQL
        SELECT AVG(mark) FROM dataset_1
        WHERE mark IN (2,3,4,5)
        AND year = 2016
SQL
    )->queryScalar();

        $bar_2017 = \Yii::$app->db->createCommand(<<<SQL
        SELECT AVG(mark) FROM dataset_1
        WHERE mark IN (2,3,4,5)
        AND year = 2017
SQL
    )->queryScalar();

        $bar_2018 = \Yii::$app->db->createCommand(<<<SQL
        SELECT AVG(mark) FROM dataset_1
        WHERE mark IN (2,3,4,5)
        AND year = 2018
SQL
    )->queryScalar();

        $pie_2 = \Yii::$app->db->createCommand(<<<SQL
        SELECT COUNT(mark) FROM dataset_1
        WHERE mark = 2
SQL
    )->queryScalar();

        $pie_3 = \Yii::$app->db->createCommand(<<<SQL
        SELECT COUNT(mark) FROM dataset_1
        WHERE mark = 3
SQL
    )->queryScalar();

        $pie_4 = \Yii::$app->db->createCommand(<<<SQL
        SELECT COUNT(mark) FROM dataset_1
        WHERE mark = 4
SQL
    )->queryScalar();

        $pie_5 = \Yii::$app->db->createCommand(<<<SQL
        SELECT COUNT(mark) FROM dataset_1
        WHERE mark = 5
SQL
    )->queryScalar();

        $label = ' по всем предметам';

        return $this->render('about', [
            'bar_2014' => $bar_2014,
            'bar_2015' => $bar_2015,
            'bar_2016' => $bar_2016,
            'bar_2017' => $bar_2017,
            'bar_2018' => $bar_2018,
            'pie_2' => $pie_2,
            'pie_3' => $pie_3,
            'pie_4' => $pie_4,
            'pie_5' => $pie_5,
            'label' => $label,
        ]);
    }
}
