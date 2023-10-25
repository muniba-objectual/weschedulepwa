<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="KoolReport.com">
    <meta name="keywords" content="">
    <?php if ($this->app()->_favicon()!==null): ?>
        <link rel="shortcut icon" href="<?php echo $this->app()->_favicon(); ?>">
    <?php endif ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <title><?php echo $this->app()->_title(); ?></title>
</head>
<body>
    <?php if($this->csrf()!==null):?>
        <script type="text/javascript">KoolReport.dashboard.security.csrf=<?php echo json_encode($this->csrf()->_getProps()); ?>;</script>
    <?php endif; ?>
    
    <?php if($this->app()->debugMode()===true):?>
        <script type="text/javascript">KoolReport.dashboard.security.debugMode=true;</script>
    <?php endif; ?>
    <?php echo $this->app()->ajaxPanel("Page",$this->page()->view()); ?>
    <ajaxpanel id="ajpTunnel"></ajaxpanel>
    <?php $this->innerView("Application.loader"); ?>
</body>
</html>