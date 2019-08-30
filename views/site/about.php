<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Данные';
$this->params['breadcrumbs'][] = $this->title;
$c = 0;
$arr = [round((($bar_2015 * 100) / ($bar_2014)) - 100, 2), round((($bar_2016 * 100) / ($bar_2015)) - 100, 2), round((($bar_2017 * 100) / ($bar_2016)) - 100, 2), round((($bar_2018 * 100) / ($bar_2017)) - 100, 2)];
$prognoz = array_sum($arr) / count($arr);
$bar_2019 = $bar_2018 + ($bar_2018 / 100 * $prognoz)
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js" integrity="sha256-qSIshlknROr4J8GMHRlW3fGKrPki733tLq+qeMCR05Q=" crossorigin="anonymous"></script>
<div class="site-about">
    <h1>Средние оценки</h1>
    <br>
    <canvas id="myChart" width="800" height="600"></canvas>
</div>
    <br>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Год</th>
            <th scope="col">Средняя оценка</th>
            <th scope="col">Прирост</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>2014</td>
            <td><?= round($bar_2014, 2) ?></td>
            <td>-</td>
        </tr>
        <tr>
            <td>2015</td>
            <td><?= round($bar_2015, 2) ?></td>
            <td style="color: green;">↑ <?= round((($bar_2015 * 100) / ($bar_2014)) - 100, 2) ?>%</td>
<!--            '+' + Math.round((((value.next_year_nebudget * 100) / parseInt(value.last_year_nebudget, 10)) - 100))-->

        </tr>
        <tr>
            <td>2016</td>
            <td><?= round($bar_2016, 2) ?></td>
            <td style="color: green;">↑ <?= round((($bar_2016 * 100) / ($bar_2015)) - 100, 2) ?>%</td>
        </tr>
        <tr>
            <td>2017</td>
            <td><?= round($bar_2017, 2) ?></td>
            <td style="color: green;">↑ <?= round((($bar_2017 * 100) / ($bar_2016)) - 100, 2) ?>%</td>
        </tr>
        <tr>
            <td>2018</td>
            <td><?= round($bar_2018, 2) ?></td>
            <td style="color: green;">↑ <?= round((($bar_2018 * 100) / ($bar_2017)) - 100, 2) ?>%</td>
        </tr>
        <tr>
            <td>2019 (прогноз)</td>
            <td><?= round($bar_2019, 2) ?></td>
            <td style="color: grey;">↑ <?= $prognoz ?>%</td>
        </tr>
        </tbody>
    </table>
    <h1>Распрделение оценок</h1>
    <br>
<div class="row">
    <canvas id="myChart2" width="800" height="600"></canvas>
</div>
<br>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Оценка</th>
            <th scope="col">Кол-во оценок</th>
            <th scope="col">Процент от общего числа</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Отлично</td>
            <td><?= round($pie_5, 2) ?></td>
            <td style="color: green;"><?= round($pie_5 / (($pie_2 + $pie_3 + $pie_4 + $pie_5) / 100),2); ?>%</td>
        </tr>
        <tr>
            <td>Хорошо</td>
            <td><?= round($pie_4, 2) ?></td>
            <td style="color: darkolivegreen;"><?= round($pie_4 / (($pie_2 + $pie_3 + $pie_4 + $pie_5) / 100),2); ?>%</td>
        </tr>
        <tr>
            <td>Удовлетворительно</td>
            <td><?= round($pie_3, 2) ?></td>
            <td style="color: orange;"><?= round($pie_3 / (($pie_2 + $pie_3 + $pie_4 + $pie_5) / 100),2); ?>%</td>
        </tr>
        <tr>
            <td>Неудовлетворительно</td>
            <td><?= round($pie_2, 2) ?></td>
            <td style="color: darkred;"><?= round($pie_2 / (($pie_2 + $pie_3 + $pie_4 + $pie_5) / 100),2); ?>%</td>
        </tr>
        </tbody>
    </table>
    <h1>Распределение ведомостей</h1>
    <br>
<div class="row">
    <canvas id="myChart3" width="800" height="600"></canvas>
</div>
<br>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Тип ведомости</th>
            <th scope="col">Кол-во ведомостей</th>
            <th scope="col">Процент от общего числа</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($vedomostPreData as $row ) {?>
        <tr>
            <td><?= $row['type'] ?></td>
            <td><?= $row['count'] ?></td>
            <td style="color: green;"><?= round($row['count'] / (array_sum(json_decode($vedomostData)) / 100),2) ?>%</td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
<?php
$this->registerCssFile('@web/css/Chart.css.min');
$this->registerJsFile('@web/js/Chart.js.min');
$this->registerJs("
var ctx = document.getElementById(\"myChart\");
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [\"2014\", \"2015\", \"2016\", \"2017\", \"2018\", \"2019 (прогноз)\"],
    datasets: [{
      label: 'Средня оценка'+'$label',
      data: [$bar_2014, $bar_2015, $bar_2016, $bar_2017, $bar_2018, $bar_2019],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: false,
    scales: {
      xAxes: [{
        ticks: {
          maxRotation: 90,
          minRotation: 80
        }
      }],
      yAxes: [{
        ticks: {
          min: 3
        }
      }]
    }
  }
});
");

$this->registerJs("
var ctx = document.getElementById(\"myChart2\");
var myChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: [\"Неудовлетворительно\", \"Удовлетворительно\", \"Хорошо\", \"Отлично\"],
    datasets: [{
      label: 'Распределение оценок',
      data: [$pie_2, $pie_3, $pie_4, $pie_5],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: false,
  }
});
");

$this->registerJs("
var ctx = document.getElementById(\"myChart3\");
var myChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: $vedomostLabels,
    datasets: [{
      label: 'Распределение ведомостей',
      data: $vedomostData,
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 99, 34, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(255,99,45,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: false,
  }
});
");