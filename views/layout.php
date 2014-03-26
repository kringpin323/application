<?php require('header.php') ?>
<?php require('body_topic.php') ?>


	<div align="center" style="font-size:10pt;">   
            <div id="result" style="height:16px;width:904px;text-align:left;">
            <img src="" alt="">&nbsp; <span id="LabelResult" style="display:inline-block;font-family:Arial;height:16px;font-family: Verdana">
            <ul><li>查询条件由一个或多个关键词组成。</li>
            	<li>----------关键词----------</li>
            		○ 字或词，如：文、语言 || ○ 词+词类，如： 语言/n、制定/v || ○ 词类标识符为“/”，如：语言/n 
            	<li>----------关键词串----------</li>
            		○ 单一关键词，如： 语言，语言/n || ○ 多关键词用空格隔开，如： 语言 文字，语言/n 文字/n <font color="red">|| ○ 连续词类串，如： /v /u /m /v</font>
            	<li><font color="red">----------多关键词逻辑-------</li>
            		只对[整词匹配]的查询方式有效的标记：<br>1    空格或[+]表示[与(and)]关系，如： 语言 文字 或 语言 +文字<br>2    [@]表示[或(or)]关系，如： 语言 @文字 <br>3    [-]表示[非(not)]关系，如： 语言 -文字<br>示例：条件“语言 @文字 研究 -教学”表示检索“包含关键词'语言'或'文字'并且含关键词'研究'但不含关键词'教学'”的例句。</font>
            	<li>----------整词匹配-----------</li>
            		使用整词索引进行查询，多关键词时忽略顺序，速度快，多关键词查询时任一关键词未被索引则不能返回结果。
            	<li>----------话题匹配-----------</li>
            		话题匹配根据相关话题，返回与给话题有关的微博。
            	<li><font color="red">----------全文检索-----------</li>
            		使用全文检索方式进行查询，多关键词时忽略顺序，速度快，但不能检索‘的、了’等极高频词。</font></ul></span>
        	</div>
    </div> 


<?php require('footer.php') ?>