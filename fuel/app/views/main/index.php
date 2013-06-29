<!doctype html>
<html lang="jp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width">
    <meta name="keywords" content="ATNDさーち,ATNDサーチ,ATND,イベント検索">
    <meta name="description" content="ATNDのイベントを検索するサービスです。FuelPHP 1.6で実装されています。">

    <?php echo Asset::css('style.css');?>
    <?php echo Asset::css('bootstrap.min.css');?>
    <?php echo Asset::css('bootstrap-responsive.min.css');?>
    <?php echo Asset::js('jquery.min.js');?>
    <?php echo Asset::js('bootstrap.min.js');?>

</head>
<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <?php echo Html::anchor('',$title, array('class' => 'brand')); ?>
        </div>
    </div>
</div>

<div class="container">
    <p>ATND BETA のイベントを検索する事ができます。</p>
    <div class="row">
        <div class="span3">
            <?php echo Form::open(array('action' => 'main/search', 'method' => 'post')); ?>
            <div class="control-group <?php $is_error($errors,'keyword'); ?>">
                <div class="controls controls-row">
                    <?php echo Form::input('keyword', $keyword, array('class' => 'input-medium', 'placeholder' => '検索キーワード（必須）')); ?>
                    <span class="help-inline">hint:半角スペースで複数入力可</span>
                </div>
            </div>
            <div class="control-group <?php $is_error($errors,'area'); ?>">
                <div class="controls controls-row">
                    <?php echo Form::input('area', $area, array('class' => 'input-medium', 'placeholder' => '開催エリア（任意）')); ?>
                    <span class="help-inline">hint:半角スペースで複数入力可</span>
                </div>
            </div>
            <div class="control-group <?php $is_error($errors,'date'); ?>">
                <div class="controls controls-row">
                    <?php echo Form::input('date', $date, array('class' => 'input-medium', 'placeholder' => '開催日（任意）')); ?>
                    <span class="help-inline">hint：20130501 or 201305</span>
                </div>
            </div>
            <div class="control-group">
                <div class="controls controls-row">
                    <?php echo Form::label('過去のイベントを検索しない', 'notpast'); ?>
                    <?php echo Form::checkbox('notpast', '1', $notpast); ?>
                </div>
            </div>
            <div class="control-group">
                <div class="controls controls-row">
                    <?php echo Form::submit('submit', 'この条件で検索する', array('class'=>'btn btn-primary')); ?>
                </div>
            </div>
            <?php echo Form::close(); ?>
        </div>
        <div class="span9">
            <legend>検索結果<?php echo $counter; ?></legend>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>開催日</th>
                    <th>タイトル</th>
                    <th>参加登録者数</th>
                    <th>主催者</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    if($results != null){
                        for($i = 0; $i < count($results); $i++){
                            echo '<tr><td>'.$results[$i]['date'].'</td>'.
                                '<td>'.Html::anchor($results[$i]['url'], $results[$i]['title'],array("target" => "_blank")).'</td>'.
                                '<td>'.$results[$i]['recruiting'].'</td>'.
                                '<td>'.Html::anchor($results[$i]['ownerurl'], $results[$i]['owner'],array("target" => "_blank")).'</td></tr>';
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="footer">
    <div class="center">Powerd by FuelPHP <?php echo $fuelversion; ?></div>
    <p class="center">Copyright &copy;  <?php echo $year; ?> <?php echo $author; ?></p>
</div>
</body>
</html>
