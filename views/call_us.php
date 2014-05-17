<?php require('header.php') ?>


	<div id="maindiv" style="width:1000px; min-height:450px; background-color:white; text-align :center ; margin:0 auto; position:relative;font-size:10pt; border-left: silver 1px solid;  border-right: silver 1px solid; left: 0px; top: 0px; height: 448px;">
	    <div id="topbanner" style="width:1000px; height:30px; position:relative;font-size:10pt; left: 0px; top: 0px; border-left-width: 1px; border-left-color: silver; margin-left: auto; border-top-style: none; margin-right: auto; border-right-width: 1px; border-right-color: silver; border-bottom-style: none;">
	    </div>
    	<div id="leftbanner" style="float :left ;width:20px;text-align:center;height: 30px;">
        </div>
    	<div id="left" style="float :left ;width:160px;padding-top: 20px; text-align:center; font-family: Arial; height: 344px;">
             <div id="PanelLogin" style="width:160px; text-align:center ; background-color: #6699cc; padding-left: 2px; padding-top: 2px; border-right: navy 1px solid; border-top: silver 1px solid; border-left: silver 1px solid; border-bottom: navy 1px solid;">
	
                        <div style="width :98%;height:20px; border-right: navy 1px solid; border-top: silver 1px solid; border-left: silver 1px solid; padding-top: 7px; border-bottom: navy 1px solid; background-color: #4682b4; color: #F8F8FF;"> 
                        网站用户登录</div>
                        <br>
                        <span id="Label1" style="display:inline-block;width:50px;">用户名:</span>
                    <?php
                        if(@$_SESSION['lzdusername'])
                        {
                            echo  "<span id=\"LabelZ_\" style=\"display:inline-block;width:50px;\">".$_SESSION['lzdusername']."</span>";
                        }
                        else  
                            echo '<input name="TextBox1" type="text" maxlength="50" id="TextBox1" style="border-width:1px;border-style:Inset;width:90px;">';
                    ?>    
                        <p>
                    <?php
                        if(@$_SESSION['lzdusername'])
                        {

                        }
                        else
                        {
                            echo '<span id="Label2" style="display:inline-block;width:50px;">密&nbsp;&nbsp;码:</span>
                                    <input name="TextBox2" type="password" maxlength="50" id="TextBox2" style="border-width:1px;border-style:Inset;width:90px;">';
                            echo '<br>
                                    <input type="submit" name="loginbutton" value="登 录" id="loginbutton">&nbsp;
                                    <input id="Reset1" type="reset" value="重 置">';
                        }     
                            
                    ?>  
                        
                       
                 <br><br>
                 
                  
	</p></div>
             
        </div>
    	<div id="divmiddle" style=" text-align :left; float :left; width :60%; height :auto; font-family:Verdana ; padding-left: 20px;">
            <ul><li>欢迎查看功能说明,本网站实现的功能有：</li>  
             
            <li>微博话题检索</li>
            <li>微博检索</li>
            <li>微博评论检索</li>
            <li>褒贬义判断</li>
            <li>褒贬义评论数量统计</li>
            <li>通过要查找的评论返回原语境</li>
            <li>显示发微博者信息</li>
            </ul>   
           
          
        </div>
    	<div id="right" style="float :right; width :20%; height: 112px;padding-top: 20px;">
    	</div>

	</div>
        



<?php require('footer.php') ?>