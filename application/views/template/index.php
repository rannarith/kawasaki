<?php include_once 'header.php'; ?>


<?php include_once 'menu.php'; ?>


<?php ?>


<?php

if ($this->uri->segment(1) == "" && $this->uri->segment(2) == ""|| $this->uri->segment(1) == "page" && $this->uri->segment(2) == "" || $this->uri->segment(1) == "page" && $this->uri->segment(2) == "index") {
    
	include_once 'home_slide.php'; 
    include_once 'page/home.php';
} else {
    include_once $this->uri->segment(1).'/'.$this->uri->segment(2).'.php';
}
?>


<?php include_once 'footer.php'; ?>