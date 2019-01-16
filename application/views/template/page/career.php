<div style="background: #F6F6F6; color: #000;">
<!--   banner     -->
<!--<img class="img-responsive" width="100%" src="<?php echo base_url(); ?>assets/images/accessory/1.jpg" />
 
-->
<div class="clear"></div>


<div class="container">  
    <div class="row">
        <!-- left menu -->
        <div class="col-lg-2">
            <div class="clear"></div><br/><br/>
            <?php include_once 'menu_about.php'; ?>
        </div>

        <div class="col-lg-10">
            <div class="clear"></div><br/><br/>
            <h2 class="content_title"><span class="kawa_txt_color"> JOIN WITH US</span></h2>
            We at Kawasaki Motors Cambodia are rapidly expanding our business operations and diversifying our company activities. As we are continuously growing, we would like to invite highly qualified, competent and committed candidates to join our dynamic team where employees are treated with respect and are self-motivated to excel.
            <br/><br/>
            Currently we are looking for candidates to fill up the vacancies for the following areas:
            <br/>
            
            <?php
            
            if($career_detail->num_rows() > 0){
                $row = $career_detail->row();
                ?>
                <h3 class=""><span class="kawa_txt_color"> <?php echo $row->position;  ?></span></h3>
                <?php echo $row->description; ?>
                <div class="clear"></div><br/>
                For more positions:
                <br/>
            <?php
            }
            ?>
            
            
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <td>Date</td>
                        <td>Position</td>
                        <td>Closing Date</td>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                    foreach ($career->result() as $row){
                        $position = $row->position;
                        $closing_date = $row->closing_date;
                        $create_date = $row->create_date;
                        $originalDate = $row->create_date;
                        $newDate = date("d/m/Y", strtotime($originalDate));
                        ?>
                    <tr>
                        <td>
                            <?php echo $newDate; ?>
                        </td>
                        <td>
                            <a href="<?php echo base_url()."page/career/".$row->cid; ?>"><?php echo $position; ?></a>
                        </td>
                        <td>
                            <?php echo $closing_date ?>
                        </td>
                    </tr>
                    <?php
                    }
                    
                    ?>
                    
                    
                </tbody>
            </table>
        </div>

    </div>

</div>
</div>


