<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=devic-width,initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
  <link href="css/dashboard.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Match</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="index.php">积分榜</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <h2 class="sub-header">本轮对决</h2>
    <p><a class="btn btn-default" href="#" role="button">&laquo;上一轮</a><a class="btn btn-default" href="#" role="button">下一轮 &raquo;</a></p>
  <div class="tablle-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>开赛时间(日本时间)</th>
          <th>对阵双方</th>
          <th>结果</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require_once dirname(__FILE__).'/../SerieA/SerieANews.php';
        $serieA = new SerieA();
        $serieA_result = $serieA->accept("match");
        print_r($serieA_result);
         ?>
      </tbody>

</body>
