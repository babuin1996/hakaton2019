<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Данные';
$this->params['breadcrumbs'][] = $this->title;
$c = 0;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Название предмета</th>
            <th scope="col">Оценка</th>
            <th scope="col">Год сдачи</th>
            <th scope="col">Семестр сдачи</th>
            <th scope="col">Тип ведомости</th>
            <th scope="col">Индивидуальная/Основная</th>
            <th scope="col">Дисциплина по выбору</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($data as $row) {?>
            <?php if ($c++ == 1000) {break;} ?>

            <tr>
            <th scope="col"><?= $hashTable[$row[0]] ?></th>
            <th scope="col"><?= $row[1] ?></th>
            <th scope="col"><?= $row[2] ?></th>
            <th scope="col"><?= $row[3] ?></th>
            <th scope="col"><?= $row[4] ?></th>
            <th scope="col"><?= $row[5] ?></th>
            <th scope="col"><?= $row[6] == 0 ? 'Нет' : 'Да' ?></th>
        </tr>

        <?php } ?>
        </tbody>
    </table>
</div>
