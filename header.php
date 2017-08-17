<?php
    header('X-Frame-Options: GOFORIT'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Observatorio Logistico</title>
<link rel="shortcut icon" href="favicon.ico" />
<link href="/css/style.css" rel="stylesheet" type="text/css" charset="utf-8" />
<link href="/css/reset.css" rel="stylesheet" type="text/css"  />
<link rel='stylesheet' type='text/css' href='/css/fullcalendar.css' />
<link rel='stylesheet' type='text/css' href='/css/custom.css' />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rainbow/1.2.0/themes/github.css">
<link rel="stylesheet" href="/assets/google/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/google/css/bootstrap-theme.css">
<link rel="stylesheet" href="/assets/google/css/todc-bootstrap.min.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="/js/custom.js"></script>
<script src="/js/jquery-ui-1.8.13.custom.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="/js/vertlib.min.js"></script><!-- Right Menu Fixed Scroll-->
<script type="text/javascript" src="/js/StickyScroller.min.js"></script><!-- Right Menu Fixed Scroll-->
<script type='text/javascript' src='/js/jquery-ui-1.8.13.custom.min.js'></script>
<script type='text/javascript' src='/js/fullcalendar.min.js'></script>
</head>

<body>
 
   <div class="header">
    
           <div id="logo"><img src="/images/logo.png" width="150px" alt="Logo" /></div>
           
           <div class="top-nav">
               <ul>
                   <li><a href="/" title="KPI" class="<?php if($active==1)echo "active"; ?>" >Bases</a></li><!--Add "active" Class for Current Page-->
                   <li><a href="/?/Prep" class="<?php if($active==2)echo "active"; ?>" title="Forms" >Preparador</a></li>
<!--                   <li><a href="/?/Base" class="<?php if($active==3)echo "active"; ?> " title="Elements" ><img src="/images/icons/elements.png" alt="Elements" /></a></li>-->
                   <li><a href="/?/Mantenedor" class="<?php if($active==4)echo "active"; ?>" title="Additional Elements" >Man</a></li>
               </ul>
           </div>
    
   </div>
   <!--Header-End-->
   
   <div class="clear"></div>

