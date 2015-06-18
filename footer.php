<?php
if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){header('Location: /');}
?>

<nav class="navigation-bar fixed-bottom hide">
  <nav class="navigation-bar-content">
    <ul class="element-menu drop-up">
     <div class="times element span4"></div><span class="element-divider"></span>
     <a class="element brand element bg-active-transparent span2 text-center" href="#">23 Mins Up</a><span class="element-divider"></span>
       <a class="element brand element bg-active-transparent span2 text-center" href="#">Freeze</a><span class="element-divider"></span>
        <a class="element brand element bg-active-transparent span2 text-center" href="#">My Sketch</a><span class="element-divider"></span>
         <a class="element brand element bg-active-transparent span2 text-center" href="#">Setting</a><span class="element-divider"></span>
          <a class="element brand element bg-active-transparent span2 text-center" href="#">Cookie:: <?php echo isset($_COOKIE['loginkey'])?$_COOKIE['loginkey']:'NULL'; ?></a><span class="element-divider"></span>  
          <a class="element brand element bg-active-transparent span2 text-center" href="#">Lock Screen</a><span class="element-divider"></span>  
           <a class="brand element place-right bg-active-steel text-center  bg-focus-grayDark" href="?logout" style="color:#0E1399">Log Out</a>     
    </ul>
</nav>
</nav>
