    <div id="header">
 
                    <ul class="top_menu">
                          <li><a href="/" <?php if($page=='') echo 'class="activ" ';?>title="�������"><span>�������</span></a></li>
                          <li><a href="/about/" <?php if($page=='about') echo 'class="activ" ';?>title="� ��������"><span>� ��������</span></a></li>
                          <li><a href="/contact/" <?php if($page=='contact') echo 'class="activ" ';?>title="��������"><span>��������</span></a></li>
                          <li><a href="/akcii/" <?php if($page=='akcii') echo 'class="activ" ';?>title="�����"><span>�����</span></a></li>
			  <li><a href="/sale/" <?php if($page=='sale') echo 'class="activ" ';?>title="����������"><span>����������</span></a></li>
                    </ul>     
                    
          <div class="clear"></div> 
                  
                    <div id="logo"><a href="/" title=""><img src="/images/logo_gl.png" alt="������ �������" /></a></div> 

	<div class="clear"></div> 

                  <div class="logo_pamira"></div>  

<div class="clear"></div> 
<?php
//if($page=='tovar_po_brandu') echo '<h1>'.$rowbrand['name'].'</h1>'; else if(($page=='catalog')AND($id=='Duhovye_shkafy')AND($id1=='')) echo '<div class="slogan">������� ����</div>'; else if(($page=='catalog')AND($id=='Kuhonnye_mojki')AND($id1=='')) echo '<div class="slogan">�������� �����</div>'; else if(($page=='catalog')AND($id=='posudomoechnye-mashiny')AND($id1=='')) echo '<div class="slogan">������������� ������</div>'; else if(($page=='catalog')AND($id=='Vytjazhki')AND($id1=='')) echo '<div class="slogan">�������</div>'; else if(($page=='catalog')AND($id=='Varochnye_poverhnosti')AND($id1=='Gazovye')AND($id1=='Gazovye')AND($_GET['strview']=='')) echo '<div class="slogan">�������� ������</div>'; else if(($page=='article')AND($id=='AEG_vstraivaemay_tehnika')) echo '<div class="slogan">������������ �������</div>'; else echo '<div class="slogan">������� ��� �����</div>';
if($page=='tovar_po_brandu') echo '<h1>'.$rowbrand['name'].'</h1>'; else if(($page=='catalog')AND($id=='Duhovye_shkafy')AND($id1=='')) echo '<h1>������� ����</h1>'; else if(($page=='catalog')AND($id=='Kuhonnye_mojki')AND($id1=='')) echo '<h1>�������� �����</h1>'; else if(($page=='catalog')AND($id=='posudomoechnye-mashiny')AND($id1=='')) echo '<h1>������������� ������</h1>'; else if(($page=='catalog')AND($id=='Vytjazhki')AND($id1=='')) echo '<h1>�������</h1>'; else if(($page=='catalog')AND($id=='Varochnye_poverhnosti')AND($id1=='Gazovye')AND($id1=='Gazovye')AND($_GET['strview']=='')) echo '<h1>�������� ������</h1>'; else if(($page=='article')AND($id=='AEG_vstraivaemay_tehnika')) echo '<h1>������������ �������</h1>'; else echo '<h1>������� ��� �����</h1>';
?>

           <div class="clear"></div> 
                    
                    <div class="phone">�.������-��-����, ��.���������������,103/123<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;���. <span class="textnewbold">+7 (863) 299-44-53</span></div>   
                    
     </div> 