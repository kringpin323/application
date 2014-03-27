<?php require('header.php') ?>
<?php require('body_comment.php') ?>

 		<div align="center" style="font-size:10pt;">   
            <div id="result" style="height:16px;width:904px;text-align:left;">
	
            <span id="LabelResult" style="display:inline-block;font-family:Arial;height:16px;font-family: Verdana">查询结果：</span>
            <span id="resultinfo" style="display:inline-block;height:16px;">
                <?php
                    echo "第".$num_begin."到第".$num_end."条，共查询到<font color=red>".$totalRows."</font>条符合要求的例句。以下评论对应的原微博中褒义:<font color=red>".$baoyi."</font> 无法判断:<font color=red>".$wufapanduan."</font> 贬义:<font color=red>".$bianyi."</font>。现在显示的是：";
                    switch($totalRows)
                    {
                        case $baoyi:
                            echo "<font color=red>褒义</font>";
                            break;
                        case $bianyi:
                            echo "<font color=red>贬义</font>";
                            break;
                        case $wufapanduan:
                            echo "<font color=red>无法判断</font>";
                            break;
                        default:
                            echo "<font color=red>全部</font>";
                    }
            ?>
            </span>
			</div>
         </div> 
         
        
         <?php echo $this->table->generate(); ?>

        <div align="center" style="font-size:10pt;">
            <?php echo $this->pagination->create_links(); ?>
        </div>

<?php require('footer.php') ?>