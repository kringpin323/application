


<div id="Div1" style="width:1000px; height :10px; background-color:white; margin:0 auto; text-align:left; position:relative; border-left: silver 1px solid;  border-right: silver 1px solid; ">
          &nbsp; &nbsp; &nbsp;</div>
 <div id="maindiv" align="center" style="width:1000px; min-height:500px; background-color:White; margin:0 auto; position:relative;font-size:10pt; border-left: 1px solid silver;border-top: silver 0px solid;  border-right: 1px solid silver;left: 0px; top: 0px;">
 <div id="mainform" style="width:1000px; margin:0 auto;background-color:white; text-align:left; position:relative; min-height:500px; border-bottom: silver 1px solid; border-top: silver 0px solid; border-right: silver 1px solid; left: 0px; top: 0px;">
  <div align="center">
           <span style="font-family:微软雅黑; font-size:medium">微博评论检索</span>


           &nbsp;<br><br>
        <div id="seach" style="border-color:LightGrey;border-width:1px;border-style:Solid;font-size:10pt;height:48px;width:880px;text-align:left;border-right: #4682b4 1px solid; border-bottom: #4682b4 1px solid; padding-left: 20px; background-color:#C2E0F1; padding-top: 8px; padding-bottom: 3px;">
    
            <span id="Label1" style="display:inline-block;height:16px;width:72px;">查询条件：</span>
            <input name="TextBox1" type="text" id="TextBox1" style="font-family:新宋体;height:16px;width:400px;">
            &nbsp; &nbsp;
            <span id="Label6">每页句数:</span>&nbsp;<select name="DropDownListPsize" id="DropDownListPsize" style="font-size:8pt;">
        <?php
            $data['DropDownListPsize'] = $pageSize;
            $array_1 = array(30,20,15,5);
            foreach($array_1 as $value)
            {
                if($value == $pageSize)
                {
                    echo "<option selected=\"selected\" value=\"".$value."\">".$value."</option>";
                }
                else
                {
                    echo "<option value=\"".$value."\">".$value."</option>";
                }
            }   
        ?>
        

    </select>
            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
            <input type="submit" name="Button1" value="检索" id="Button1" style="font-size:10pt;height:24px;width:100px;">&nbsp;<br>
        <span id="Label5" style="display:inline-block;height:16px;width:72px;">查询模式：</span>
            <input id="RBobscure" type="radio" name="1" value="RBobscure" checked="checked"><label for="RBobscure">模糊匹配</label>
            <input id="RBlikeword" type="radio" name="1" value="RBlikeword"><label for="RBlikeword">整词匹配</label>
            <!--<input id="RBfulltextmode" type="radio" name="1" value="RBfulltextmode"><label for="RBfulltextmode">全文检索</label>-->
            &nbsp; &nbsp; 
            <span id="Label4" style="display:inline-block;height:16px;">输出语料：</span>
            <input id="RadioButton3" type="radio" name="2" value="RadioButton3" checked="checked"><label for="RadioButton3">生语料</label>
            <input id="RadioButton4" type="radio" name="2" value="RadioButton4" ><label for="RadioButton4">词类标记</label>
            &nbsp; &nbsp;
            <span id="Label4" style="display:inline-block;height:16px;">褒贬显示：</span>
            <input  type="checkbox" name="baobian[]" value="Praise" checked="checked"><label for="Praise">褒义</label>
            <input  type="checkbox" name="baobian[]" value="Unable" checked="checked"><label for="Unable">无法判断</label>
            <input  type="checkbox" name="baobian[]" value="Criticize" checked="checked"><label for="Criticize">贬义</label>
            

            
</div>
        </div>

        <div align="right" style="padding-right: 50px">
            <br>
            <?php echo "<a id=\"LinkButtonFormat\" href=\"".site_url()."/con_header/layout\">" ?>查询条件格式</a>
            &nbsp; &nbsp;
            <?php echo "<a id=\"LinkButtonPOSset\" href=\"".site_url()."/con_header/parts_of_speech\">" ?>词类标记代码</a>
            &nbsp; &nbsp;
            <?php echo "<a id=\"LinkButtonInfo\" href=\"".site_url()."/con_header/introduce\">" ?>语料库说明</a>
         </div>