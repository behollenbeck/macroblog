<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title_for_layout; ?></title>
    <meta name="description" content="A Twitter-enabled anti-twitter blogging site, where you're rewarded for writing with purpose.">
    <meta name="author" content="elsewar.es">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link type="stylesheet/less" href="<?php echo $this->webroot; ?>/css/lib/bootstrap.less" rel="stylesheet/less">

    <!-- Le scripts -->
    <script type="text/javascript" src="<?php echo $this->webroot; ?>/js/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->webroot; ?>/js/less.js"></script>

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
  </head>

  <body>

    <div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="#">macroblog</a>
          <ul class="nav">
            <li class="active"><a href="#">home</a></li>
            <li><a href="#about">about</a></li>
            <li><a href="#contact">contact</a></li>
          </ul>
          <form action="" class="pull-right">
            <input class="input-small" type="text" placeholder="Username">
            <input class="input-small" type="password" placeholder="Password">
            <button class="btn" type="submit">Sign in</button>
          </form>
        </div>
      </div>
    </div>

    <div class="container">

      <div class="content">
        <div class="page-header">
          <h1>Don't just tweet - write. <small>Twitter for people who blog like they mean it.</small></h1>
        </div>
        <div class="row">
          <div class="span12">
            <?php echo $content_for_layout; ?>
          </div>
          <div class="span2">
            <h3>Le Menu</h3>
          </div>
        </div>
      </div>

      <footer>
        <p>&copy; elsewar.es 2011</p>
      </footer>

    </div> <!-- /container -->

  </body>
</html>