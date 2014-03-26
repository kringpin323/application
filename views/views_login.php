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
                            echo  '<span id="Label_" style="display:inline-block;width:50px;">'.$_SESSION['lzdusername'].'</span>';
                        }
                        else
                        {
                            echo "<input name=\"user_name\" type=\"text\" maxlength=\"50\" id=\"user_name\" style=\"border-width:1px;border-style:Inset;width:90px;\"><p>";
                        }    
                    
                        if(@$_SESSION['lzdusername'])
                        {

                        }
                        else
                        {
                            echo '<span id="Label2" style="display:inline-block;width:50px;">密&nbsp;&nbsp;码:</span><input name="password" type="password" maxlength="50" id="password" style="border-width:1px;border-style:Inset;width:90px;"><br>';
                            echo '<br>
                                    <input type="submit" name="loginbutton" value="登 录" id="loginbutton">&nbsp;
                                    <input id="Reset1" type="reset" value="重 置"><br>
                                    <br>';
                        }     
                        ?>
                        
                        
                 <br><br>
	</p></div>
             
        </div>
    	<div id="divmiddle" style=" text-align :left; float :left; width :60%; height :auto; font-family:Verdana ; padding-left: 20px;">
            <ul><li>欢迎访问[<a href="<?php echo site_url()."/con_login/index" ?>">广外语料库在线</a>] ——微博语言资源综合网站！</li></ul>           
            <ul><li><span style=" color:red ">更新：近一周来最新微博。</span></li></ul>
            <ul><li>语料库等资源需注册成为用户并登录后才能使用，如有问题、意见或建议请在致电我们。</li></ul>
            <ul><li>网站所有资源免费使用，仅限于用作研究目的，不得用于赢利性开发等用途。</li></ul>
            <ul><li><a href="<?php echo site_url()."/con_topic/show" ?>">微博话题检索</a></li>
                  </ul>
            <ul><li><a href="<?php echo site_url()."/con_weibo/show" ?>">微博原文检索</a></li>
                 </ul>
            <ul><li><a href="<?php echo site_url()."/con_comment/show" ?>">微博评论检索</a></li>
                </ul>
           <ul><li>建议使用IE7以上浏览器，网站对IE6支持不够，可能出现页面布局错乱情况。</li></ul>
          
        </div>

	</div>
        



<?php require('footer.php') ?>