<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php if (isset($this->titulo))echo $this->titulo;?></title>
    <link href="<?php echo $_layoutParams['ruta_css'];?>estilos.css" rel="stylesheet" type="text/css" >
    <!-- <link rel="stylesheet" href="views/layout/default/css/estilos.css"> -->
    <script src="<?php echo BASE_URL; ?>public/js/jquery.js" type="text/javascript"></script>    
    <script src="<?php echo BASE_URL; ?>public/js/jquery.validate.js" type="text/javascript"></script>    
    
    
    <?php if(isset($_layoutParams['js']) && count($_layoutParams['js'])):?>
    <?php for($i=0; $i<count($_layoutParams['js']);$i++):?>
        <script src="<?php echo $_layoutParams['js'][$i];?>" type="text/javascript"></script>
    <?php endfor;?>
    <?php endif;?>
</head>
<body>    
    <div id="main">
        <div id="header">
            <h1><?php echo APP_NAME;?></h1>
        </div>
        <div id="menu_top">
            <ul>
                <?php if(isset($_layoutParams['menu'])):?>
                <?php for($i=0; $i<count($_layoutParams['menu']);$i++):?>
                    <li><a href="<?php echo $_layoutParams['menu'][$i]['enlace'];?>"><?php echo $_layoutParams['menu'][$i]['titulo'];?></a></li>
                <?php endfor;?>
                <?php endif;?>
            </ul>
        </div>
        <div id="content">
            <noscript><p>Para el perfeto funcionamiento debe tener el soporte de Javascript habilitado</p></noscript>
            
            <?php if(isset($this->_error)):?>            
                <div id ="error"><?php echo $this->_error;?></div>
            <?php endif;?>
            <?php if(isset($this->_mensaje)):?>            
                <div id ="mensaje"><?php echo $this->_mensaje;?></div>
            <?php endif;?>
        </div>
</body>
</html>