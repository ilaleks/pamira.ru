    <div id="header">
 
                    <ul class="top_menu">
                          <li><a href="/" <?php if($page=='') echo 'class="activ" ';?>title="Главная"><span>Главная</span></a></li>
                          <li><a href="/about/" <?php if($page=='about') echo 'class="activ" ';?>title="О компании"><span>О компании</span></a></li>
                          <li><a href="/contact/" <?php if($page=='contact') echo 'class="activ" ';?>title="Контакты"><span>Контакты</span></a></li>
                          <li><a href="/akcii/" <?php if($page=='akcii') echo 'class="activ" ';?>title="Акции"><span>Акции</span></a></li>
			  <li><a href="/sale/" <?php if($page=='sale') echo 'class="activ" ';?>title="Распродажи"><span>Распродажи</span></a></li>
                    </ul>     
                    
          <div class="clear"></div> 
                  
                    <div id="logo"><a href="/" title=""><img src="/images/logo_gl.png" alt="Памира логотип" /></a></div> 

	<div class="clear"></div> 

                  <div class="logo_pamira"></div>  

<div class="clear"></div> 
<?php
if($page=='tovar_po_brandu') echo '<div class="slogan">'.$rowbrand['name'].'</div>'; else if(($page=='catalog')AND($id=='Duhovye_shkafy')AND($id1=='')) echo '<div class="slogan">Духовой шкаф</div>'; else if(($page=='catalog')AND($id=='Kuhonnye_mojki')AND($id1=='')) echo '<div class="slogan">Кухонные мойки</div>'; else if(($page=='catalog')AND($id=='Posudomoechnye_mashiny')AND($id1=='')) echo '<div class="slogan">Посудомоечные машины</div>'; else if(($page=='catalog')AND($id=='Vytjazhki')AND($id1=='')) echo '<div class="slogan">Вытяжки</div>'; else if(($page=='catalog')AND($id=='Varochnye_poverhnosti')AND($id1=='Gazovye')AND($id1=='Gazovye')AND($_GET['strview']=='')) echo '<div class="slogan">Варочная панель</div>'; else if(($page=='article')AND($id=='AEG_vstraivaemay_tehnika')) echo '<div class="slogan">Встраиваемая техника</div>'; else echo '<div class="slogan">Техника для кухни</div>';
?>

           <div class="clear"></div> 
                    
                    <div class="phone">г.Ростов-на-Дону, ул.Красноармейская,103/123<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;тел. <span class="textnewbold">+7 (863) 299-44-53</span></div>   
                    
     </div> 