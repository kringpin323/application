<?php require('views_1.htm'); ?>
<?php require('views_2.php'); ?>   
<?php require('views_header_3.php'); ?>
<?php require('views_body_1_for_t_v.php'); ?>



        <div align="center" style="font-size:10pt;">   
            <div id="result" style="height:16px;width:904px;text-align:left;">
	
            <img src="./语料库在线--语料库检索2_files/bs.png" alt="X">&nbsp; <span id="LabelResult" style="display:inline-block;font-family:Arial;height:16px;font-family: Verdana">查询结果：</span>
            <span id="resultinfo" style="display:inline-block;height:16px;">
                <?php
                    echo "第1到50条，共查询到".$totalRows."条符合要求的例句";
            ?>
            </span>
			</div>
         </div> 
         
        
         <?php echo $this->table->generate(); ?>

        <div align="center" style="font-size:10pt;">
            <?php echo $this->pagination->create_links(); ?>
        </div>


<?php require('views_end.htm'); ?>