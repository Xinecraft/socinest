<?php
if(basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])){header('Location: /');}
?>
<nav class="navigation-bar nav-bar top-sticky-nav-container" style=" position:fixed;z-index: 9999;">
    <nav class="navigation-bar-content nav-bar-content">
    <item class="element span4 text-center"><a href="?home"><p id="sn_header_logo">Socinest</p></a></item>
<?php
if (!isset($_GET["setupaccount"]))
{ ?>

    <div class="element input-element span7 header-search-container">
    <form method="get" class="headersearch" name="q" autocomplete="off">
    <input id="header-search"  class="absolute" type="text" name="q" placeholder="Search">
    </form>
    <input id="header-postupdate"  class="" type="text" name="pupdate" placeholder="Status">
    
    <div class="panel header-postupdate-panel hidden">
    <form action="php_include/ajaxDo/updatestatus.php" method="post" id="headpostupdateform">
     <div class="panel-header header-postupdate-panelheader bg-darkBlue fg-white">
        <span class="header-postupdate-chooser left"><p class="header-postupdate-title header-postupdate-title-active"><a href="#">Update Status</a></p></span><span class="left header-postupdate-title-separator">|</span>
        <span class="header-postupdate-chooser left"><p class="header-postupdate-title"><a href="#">Voice Status</a></p></span>
 
 
<div class="button-dropdown header-post-options-cont right">
<button class="dropdown-toggle header-post-options-toggler link" title="Post Options"><img class="header-post-options-img" src="img/Gears.png" width="25" /></button>
<ul class="dropdown-menu header-post-options-menu" data-role="dropdown">
        <h5 class="text-center">Who can see this post</h5>
       <div class="input-control radio" title="Everybody will be able to see this post.">
    <label>
        <input type="radio" name="header-post-options-s" value="0" checked/>
        <span class="check"></span>
        Global
    </label>
    </div>
    <div class="input-control radio" title="Only your friends will be able to see this post.">
    <label>
        <input type="radio" name="header-post-options-s" value="1" />
        <span class="check"></span>
        Friends
    </label>
    </div>
   <div class="input-control radio" title="Only you will be able to see this post.">
    <label>
        <input type="radio" name="header-post-options-s" value="2" />
        <span class="check"></span>
        Self
    </label>
</div>
        <li class="divider"></li>
        <h5 class="text-center">What's allowed in this post</h5>
<div class="input-control switch span3" title="Do you want to allow others to Comment on your post.Default is 'Yes'">
    <label>
    	Comments allowed
        <input type="checkbox" name="comment_allowed" checked/>
        <span class="check right"></span>
    </label>
</div> 
<div class="input-control switch span3" title="Do you want to allow others to Hit on your post.Default is 'Yes'">
    <label>
    	Hits allowed
        <input type="checkbox" name="hit_allowed" checked/>
        <span class="check right"></span>
    </label>
</div>  
</ul>
</div>
    </div>
    <div align="center" id="loading_indicator" style="position: absolute;right: 0;padding: 15px;display:none;">
    <span class="LoadSpinner"></span>
    </div>
    <div class="panel-content header-postcontent bg-white">
    <textarea id="header-postupdate-textbox"  class="" type="text" name="pupdate" placeholder="WhatsUp today!" style="max-height:520px;"></textarea>
    <div id="results"></div>
            <!-- Load result of URL extrack into this -->
    <div id="headerpost_imgpreview"></div>
    <input type="text" class="headerpost-combobox headerpost-tag-wrapper" name="ptagfrnd" placeholder="Add any friend to post."/> 
    
    <div class="headerpost-buttons-container toolbar transparent">
    <button class="post-tag-btn post-comboxbox-btn" onclick="return false;" title="Tag friends"><span class="typcn typcn-tags"></span></button>
    <button class="post-img-btn post-comboxbox-btn" onclick="return false;" title="Add photo"><span class="typcn typcn-camera-outline"></span></button>
    <button class="post-comboxbox-btn" onclick="return false;" title="Say your mood"><span class="typcn typcn-headphones"></span></button>
    
    <input class="main-btn place-right" type="submit" value="Post Update" name="post_update_btn" id="post_update_btn"/>
    <input class="span1 cancel-btn place-right headerpost-cancelbtn" type="reset" value="Cancel" />
    
    </div>
     
    </div></form>
   <!-- THis form is to handle the images of status update --> 
    <form id="headerpostimageform" method="post" enctype="multipart/form-data" action='php_include/ajaxDo/updatestatus_img.php' style="clear:both" class="hidden">
   <input type="file" accept="image/*" name="headerpost_images[]" id="headerpost_images" multiple class="" />
   </form>
   
    </div>

    </div>
     <a class="brand element place-right browser_hover" title="" href="#"><img class="header_browser" src="img/webbrowser.png" width="25px" height="25px" /></a>
     <a class="brand element place-right setting_hover" id="0"><img class="header_setting" src="img/setting.png" width="25px" height="25px" /> </a>
     <div class="header_submenu">
     <ul class="header_root">
     <a href="#mynest"><li>My Nest</li></a>
     <a href="#privacysetting"><li>Activity Log</li></a>
     <a href="#setting"><li>Settings</li></a>
     <a href="?logout"><li>Logout</li></a>
     <li class="menu_divider"></li>
     <a href="#privacysetting"><li>Help</li></a>
     <a href="#privacysetting"><li>Feedback</li></a>
     <a href="#privacysetting"><li>Problem</li></a>
     </ul>
     </div>
    <?php
	echo '<a class="brand element place-right" href="./?profile='.$ss_username.'"><span id="header-prof-cont"><img src="user/'.$ss_username.'/profilethumb.jpeg" width="30px" height="30px" style="margin-top: -4px;height:30px;width:30px;border-radius: 3px 0px 0px 3px;" />&nbsp;'.$ss_username.'</span> </a>';
	?>
<?php
}
?>
</nav>
	</nav>
    

	<!--  Top Fixed Nav Bar Ends  -->