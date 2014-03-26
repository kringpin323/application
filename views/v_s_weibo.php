<?php require('header.php') ?>
<?php require('body_weibo.php') ?>

 		<div align="center" style="font-size:10pt;">   
            <div id="result" style="height:16px;width:904px;text-align:left;">
	
            <span id="LabelResult" style="display:inline-block;font-family:Arial;height:16px;font-family: Verdana">查询结果：</span>
            <span id="resultinfo" style="display:inline-block;height:16px;">
                <?php
                    echo "第".$num_begin."到第".$num_end."条，共查询到".$totalRows."条符合要求的例句";
            ?>
            </span>
			</div>
         </div> 
         
        
         <?php echo $this->table->generate(); ?>

        <div align="center" style="font-size:10pt;">
            <?php echo $this->pagination->create_links(); ?>
        </div>

<?php require('footer.php') ?>