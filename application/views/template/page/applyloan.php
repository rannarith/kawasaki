<!--   banner  #7e7e7e   -->
<div style="background: #F6F6F6; color: #7e7e7e;">

    <div class="clear"></div>
    <div class="container">  
        <div class="row">
            <div class="col-lg-12">
                <div class="clear"></div><br/>
                <h2 class="content_title" >Apply for <span class="kawa_txt_color"> LOAN</span></h2>
            </div>
            <div class="col-lg-2 col-md-3">
                
                <div class="clear"></div><br/><br/>
				<h3>Click on logo to select.</h3>
                <?php 
                
                $segment3 = $this->uri->segment(3);
                $bank_name = "";
                $term = "";
                $bank_logo = "";
                if($bank_details->num_rows() > 0){
                    $row_bank = $bank_details->row();
                    $bank_name = $row_bank->name;
                    $term = $row_bank->term_condition;
                    $bank_logo = $row_bank->logo;
                }
                
                    foreach ($banks->result() as $bank){
                        $bank_id = $bank->id;
                        $link_bank = base_url()."page/applyloan/".$bank_id;
                        if(isset($_GET['m'])){
                            $link_bank = base_url()."page/applyloan/".$bank_id."?m=".$_GET['m'];
                        }
                        ?>
                        <div class="col-md-12 col-sm-12" style="padding: 0px;">
                            <a href="<?php echo $link_bank; ?>"><img src="<?php echo base_url() . "assets/images/bank_logo/".$bank->logo; ?>" alt="..." class="img-thumbnail <?php echo $bank_id==$segment3?"":"img-black-white"; ?>"></a>
                        </div>
                        <div class="clear"></div><br/>
                <?php
                    }
                ?>
                
            </div>
            <div class="col-lg-10 col-md-9">
                <div class="clear"></div><br/><br/>
                
                <?php
                    if($this->session->flashdata('success_message')){
                        echo '<div class="alert alert-success" role="alert">';
                        echo $this->session->flashdata('success_message');
                        echo '</div>';
                    }
                    
                    if($this->session->flashdata('error_message')){
                        echo '<div class="alert alert-danger" role="alert">';
                        echo $this->session->flashdata('error_message');
                        echo '</div>';
                    }
                ?>
                
                <form class="form-horizontal loan_form" method="post" action="<?php echo base_url()."page/submitloan" ?>">
                    <div class="form-group">
                        <label for="bank" class="col-md-3 control-label">Bank Name : </label>
                        <div class="col-md-6">
                            <strong><?php echo $bank_name; ?></strong> &nbsp;
                            <img style="width: 60px;" src="<?php echo base_url() . "assets/images/bank_logo/".$bank_logo; ?>" alt="..." class="">
                        </div>
                    </div>
                    <input type="hidden" name="bank_id" value="<?php echo $segment3; ?>" />
                     <input type="hidden" name="bank_name" value="<?php echo $bank_name; ?>" />
                    
                    <div class="form-group ">
                        <label for="model" class="col-md-3 control-label">Model * : </label>
                        <div class="col-md-6">
                            <select class="form-control" id="model" name="model_id" onchange="showModel(this.value)" required>
                                <option value="">-- Select Model --</option>
                                <?php
                                $mid = 0;
                                if(isset($_GET['m'])){
                                    $mid = $_GET['m'];
                                }
                                
                                foreach ($all_model->result() as $model) {
                                    $selected = "";
                                    if($model->model_id == $mid){
                                        $selected = "selected";
                                    }
                                    echo '<option value="' . $model->model_id . '" '.$selected.' > ' . $model->model_name . '</option>';
                                
                                }
                                ?>
                            </select>
                            
                        </div>
                    </div>
                    <div class="form-group"  id="show_modelYear">
                        <?php
                        if(isset($_GET['m'])){
                            $model = $this->m_page->getModelByID($_GET['m']);
                            if($model->num_rows() > 0){
                                $row = $model->row();

                                echo '<label for="modelyear" class="col-md-3 control-label">Model Year</label>
                                            <div class="col-md-5">
                                                <label class=" control-label">'.$row->model_year.' </label>
                                                    <img src="'. base_url().'assets/images/model_thumbnail/'.$row->thumbnail.'" class="img-responsive"/>
                                            </div>';
                                echo '<input type="hidden" id="full_price" name="full_price" value="'.$row->price.'"/>';
                                echo '<input type="hidden" name="model_year" value="'.$row->model_year.'"/>';
                                echo '<input type="hidden" name="model_name" value="'.$row->model_name.'"/>';
                            }
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="downpayment" class="col-md-3 control-label">Down Payment *  : </label>
                        <div class="col-md-4">
                            <select class="form-control" id="downpayment" name="downpayment" onchange="DownPayment(this.value)" required>
                                <option value="">-- Please select --</option>
                                <option value="10">10%</option>
                                <option value="20">20%</option>
                                <option value="30">30%</option>
                                <option value="40">40%</option>
                                <option value="50">50%</option>
                                <option value="75">75%</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class=" control-label" id="showDownPayment"></label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="loan_term" class="col-md-3 control-label">Loan Term * : </label>
                        <div class="col-md-4">
                            <select class="form-control" id="loan_term" name="loan_term" required>
                                <option value="">-- Please select --</option>
                                <option value="6 Months">6 Months</option>
                                <option value="12 Months">12 Months</option>
                                <option value="18 Months">18 Months</option>
                                <option value="24 Months">24 Months</option>
                                <option value="36 Months">36 Months</option>
                                <option value="48 Months">48 Months</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class=" control-label" id="showDownPayment"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="term" class="col-md-3 control-label">Required Documents : </label>
                        <div class="col-md-9">
                            <?php echo $term; ?>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9">
                            <h2 style="border-bottom: 1px solid #ccc;"><strong>Personal Information</strong></h2>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Name * : </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="name" placeholder="Full Name" name="name" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-3 control-label">Email * : </label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-md-3 control-label">Phone Number * : </label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="phone" placeholder="Phone Number" name="phone" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="other" class="col-md-3 control-label">Other : </label>
                        <div class="col-md-6">
                            <textarea name="other" class="form-control" id="other" placeholder="Other"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-6">
                            <input type="submit" class="btn  btn-loan-form" name="submit" value="SUBMIT">
                        </div>
                    </div>
                    <br/>
                </form>
                <div class="clear"></div><br/><br/>
            </div>
        </div>
    </div>

    <!-- new style -->

    <script>
        function showModel(str) {
            if (str == "") {
                document.getElementById("show_modelYear").innerHTML = "";
                document.getElementById("showDownPayment").innerHTML = "";
                    $("#downpayment").val('');
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("show_modelYear").innerHTML = this.responseText;
                    document.getElementById("showDownPayment").innerHTML = "";
                    $("#downpayment").val('');
                }
            }
            xmlhttp.open("GET", "<?php echo base_url() . "page/showmodeldetail/" ?>" + str, true);
            xmlhttp.send();
        }
    </script>

    <script>
        function DownPayment(str) {
            var full_price = $('#full_price').val();
            if(full_price){
                if (str == "" || full_price == "" || full_price == NaN) {
                    document.getElementById("showDownPayment").innerHTML = "";
                    return;
                } else {
                    //Get
                    var full_price = $('#full_price').val();
                    var downpay = parseInt(str) * full_price / 100;
                    document.getElementById("showDownPayment").innerHTML = "$ " + downpay;
                    return;
                }
            }

        }
    </script>



</div>

<style>
    .mySlides {
        margin-bottom: -6px;
    }
</style>
<!-- Modal 1   -->

