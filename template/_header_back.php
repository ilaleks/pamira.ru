    <div id="top_menu_container">
      <ul class="top_menu clearfix">
                          <li><a href="/" <?php if($page=='') echo 'class="activ" ';?>title="Главная"><span>Главная</span></a></li>
                          <li><a href="/about/" <?php if($page=='about') echo 'class="activ" ';?>title="О компании"><span>О компании</span></a></li>
                          <li><a href="/contact/" <?php if($page=='contact') echo 'class="activ" ';?>title="Контакты"><span>Контакты</span></a></li>
                          <li><a href="/akcii/" <?php if($page=='akcii') echo 'class="activ" ';?>title="Акции"><span>Акции</span></a></li>
			  <li><a href="/sale/" <?php if($page=='sale') echo 'class="activ" ';?>title="Распродажи"><span>Распродажи</span></a></li>
			  <li>
			  <?php
			  	if($_SESSION['desi']==1) echo '<a href="/str_designer/"><span>'.$_SESSION['logged_desi'].'</span><em></em></a>'; else echo '<a href="#" id="loginButton" OnClick="ClickFormDis();"><span>Дилерам</span><em></em></a>';
			  ?>
			  </li>
                    </ul> 
                    </div>
                    <div id="loginBox">                
                    <form id="loginForm" method="post" action="/str_designer/">
                                                        <label for="password">Пароль:</label>
                               				<input type="password" style="width:30px;" name="password" id="password" />
                                                    <input type="submit" id="login" value="Авторизоваться" />
                                                    <input type="hidden" name="users" value="desi" />
                    </form>
                </div>                     

     <div class="top_banner_container">
      <div class="top_scallop"><div></div></div>
      <div class="tob_banner_inner clearfix">
         <div class="top_banner_overlay">
            <h1>
            <?php
//if($page=='tovar_po_brandu') echo '<h1>'.$rowbrand['name'].'</h1>'; else if(($page=='catalog')AND($id=='Duhovye_shkafy')AND($id1=='')) echo '<div class="slogan">Духовой шкаф</div>'; else if(($page=='catalog')AND($id=='Kuhonnye_mojki')AND($id1=='')) echo '<div class="slogan">Кухонные мойки</div>'; else if(($page=='catalog')AND($id=='posudomoechnye-mashiny')AND($id1=='')) echo '<div class="slogan">Посудомоечные машины</div>'; else if(($page=='catalog')AND($id=='Vytjazhki')AND($id1=='')) echo '<div class="slogan">Вытяжки</div>'; else if(($page=='catalog')AND($id=='Varochnye_poverhnosti')AND($id1=='Gazovye')AND($id1=='Gazovye')AND($_GET['strview']=='')) echo '<div class="slogan">Варочная панель</div>'; else if(($page=='article')AND($id=='AEG_vstraivaemay_tehnika')) echo '<div class="slogan">Встраиваемая техника</div>'; else echo '<div class="slogan">Техника для кухни</div>';
if($page=='tovar_po_brandu') echo '<h1>'.$rowbrand['name'].'</h1>'; else if(($page=='catalog')AND($id=='Duhovye_shkafy')AND($id1=='')) echo '<h1>Духовой шкаф</h1>'; else if(($page=='catalog')AND($id=='Kuhonnye_mojki')AND($id1=='')) echo '<h1>Кухонные мойки</h1>'; else if(($page=='catalog')AND($id=='posudomoechnye-mashiny')AND($id1=='')) echo '<h1>Посудомоечные машины</h1>'; else if(($page=='catalog')AND($id=='Vytjazhki')AND($id1=='')) echo '<h1>Вытяжки</h1>'; else if(($page=='catalog')AND($id=='Varochnye_poverhnosti')AND($id1=='Gazovye')AND($id1=='Gazovye')AND($_GET['strview']=='')) echo '<h1>Варочная панель</h1>'; else if(($page=='article')AND($id=='AEG_vstraivaemay_tehnika')) echo '<h1>Встраиваемая техника</h1>'; else echo '<h1>Техника для кухни</h1>';
?>
            </h1>
          </div> 

         <div class="left_block">
            <div class="logo_fr"><img src="/images/logo_franke.png" alt="franke (франке)"></div>
            <div class="text_box">
               <span class="textnewbold">Розничный отдел:</span><br />г.Ростов-на-Дону,<br />ул.Красноармейская,103/123<br />тел. <span class="textnewbold">+7 (863) 299-44-53</span><br />тел. <span class="textnewbold">+7 (919) 888-6-777</span>
            </div>
         </div>

         <div class="tp-banner-container">
            <div class="tp-banner">
               <ul style="display:none;">

                  <!-- SLIDE 2  -->
                  <li data-transition="slideleft" data-slotamount="5" data-masterspeed="700" data-delay="4000">
                     <img src="/images/slider/img3.png" alt="slide2"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                  </li>
                  
                  <!-- SLIDE 3  -->
                  <li data-transition="slideleft" data-slotamount="5" data-masterspeed="700" data-delay="4000">
                     <img src="/images/slider/img4.png" alt="slide3"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                  </li>                  
                  
                  <!-- SLIDE 4  -->
                  <li data-transition="slideleft" data-slotamount="5" data-masterspeed="700" data-delay="4000">
                     <img src="/images/slider/img5.png" alt="slide4"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                  </li>
                  
                  <!-- SLIDE 5  -->
                  <li data-transition="slideleft" data-slotamount="5" data-masterspeed="700" data-delay="4000">
                     <img src="/images/slider/img6.png" alt="slide5"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                  </li>                  
                  
                  <!-- SLIDE 6  -->
                  <li data-transition="slideleft" data-slotamount="5" data-masterspeed="700" data-delay="4000">
                     <img src="/images/slider/img7.png" alt="slide6"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                  </li>    
                  
                  <!-- SLIDE 7  -->
                  <li data-transition="slideleft" data-slotamount="5" data-masterspeed="700" data-delay="4000">
                     <img src="/images/slider/img8.png" alt="slide7"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                  </li>                                

                  <!-- SLIDE 8  -->
                  <li data-transition="slideleft" data-slotamount="5" data-masterspeed="700" data-delay="4000">
                     <img src="/images/slider/img9.png" alt="slide8"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                  </li>
                  
                  <!-- SLIDE 1  -->
                  <li data-transition="slideleft" data-slotamount="5" data-masterspeed="700" data-delay="4000">
                     <img src="/images/slider/slide1.jpg" alt="slide1"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">
                  </li>                  

               </ul>
               <div class="tp-bannertimer"></div>
            </div>
         </div>

         <div class="right_block">
            <div class="logo_fr"><img src="/images/logo_pam.png" alt="Памира"></div>
            <div class="text_box">
              <span class="textnewbold">Оптовый отдел:</span><br />г.Ростов-на-Дону,<br />ул.Троллейбусная, 24/2B,<br />офис 702<br />тел. <span class="textnewbold">+7 (863) 300-53-00</span>
            </div>
         </div>

      </div>
      <div class="bottom_scallop"><div></div></div>
   </div>