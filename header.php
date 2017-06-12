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
<script type="text/javascript" src="/js/jquery.min.js"></script>
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
                   <li><a href="/" title="KPI" class="<?php if($active==1)echo "active"; ?>" ><img src="/images/icons/dashboard.png" alt="Dasboard" />Kpi</a></li><!--Add "active" Class for Current Page-->
                   <li><a href="/?/Prep" class="<?php if($active==2)echo "active"; ?>" title="Forms" ><img src="/images/icons/form.png" alt="Forms" />Preparaci&oacute;n</a></li>
                   <li><a href="/?/Fuentes" class="<?php if($active==3)echo "active"; ?> " title="Elements" ><img src="/images/icons/elements.png" alt="Elements" />Carga</a></li>
                   <li><a href="/?/Base" class="<?php if($active==5)echo "active"; ?>" title="Additional Elements" ><img src="/images/icons/settings.png" alt="Additional" />Base</a></li>
               </ul>
           </div>
    
   </div>
   <!--Header-End-->
   
   <div class="clear"></div>

