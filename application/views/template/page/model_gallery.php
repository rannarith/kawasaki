<?php
if ($model_gallery->num_rows() > 0) {
    ?>
    <style>


        .row > .column {
            padding: 0 8px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .column {
            float: left;
            width: 25%;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 30px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;

            background-color: black;
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            width: 90%;
            max-width: 900px;
        }

        /* The Close Button */
        .close_btn {
            color: white;
            position: absolute;
            top: 10px;
            right: 25px;
            font-size: 45px;
            opacity: 1;
            font-weight: bold;
        }

        .close_btn:hover,
        .close_btn:focus {
            color: #999;
            text-decoration: none;
            cursor: pointer;
        }

        .mySlides {
            display: none;
        }

        .cursor {
            cursor: pointer;
        }

        /* Next & previous buttons */
        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: white;
            font-weight: bold;
            font-size: 20px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            -webkit-user-select: none;
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Position the "next button" to the right */
        .next {
            right: 0;
            border-radius: 3px 0 0 3px;

        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Number text (1/3 etc) */
        .numbertext {
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            top: 0;
        }

        img {
            margin-bottom: -4px;
        }

        .caption-container {
            text-align: center;
            background-color: black;
            padding: 2px 16px;
            color: white;
        }

        .demo {
            opacity: 0.6;
        }

        .active,
        .demo:hover {
            opacity: 1;
        }

        img.hover-shadow {
            transition: 0.3s;
        }

        .hover-shadow:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>


    <div class="container">
        <div class="clear"></div><br/>
            <h2 class="content_title"> <span class="kawa_txt_color"> Gallery</span></h2>
            <div class="clear"></div><br/>
        <?php
        $i = 0;
        foreach ($model_gallery->result() as $row) {
            $i++;
            ?>
            <div class="column">
                <img src="<?php echo base_url() . 'assets/images/model_gallery/' . $row->image; ?>" style="width:100%" onclick="openModal();currentSlide(<?php echo $i; ?>)" class="hover-shadow cursor">
            </div>
            <?php
        }
        ?>
            <div class="clear"></div><br/>

    </div>

    <div id="myModal" class="modal">
        
        <div class="container">
            <span class="close_btn cursor" onclick="closeModal()">&times;</span>
            <div class="modal-content">
                <?php
                $i = 0;
                foreach ($model_gallery->result() as $row) {
                    $i++;
                    ?>

                    <div class="mySlides">
                        <img src="<?php echo base_url() . 'assets/images/model_gallery/' . $row->image; ?>" style="width:100%">
                    </div>
                    <?php
                }
                ?>




                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>
                <div class="caption-container">
                    
                </div>

                <?php
                $i = 0;
                foreach ($model_gallery->result() as $row) {
                    $i++;
                    ?>
                    <div class="column">
                        <img class="demo cursor" src="<?php echo base_url() . 'assets/images/model_gallery/' . $row->image; ?>" style="width:100%" onclick="currentSlide(<?php echo $i; ?>)" alt="Images <?php echo $i; ?>">
                    </div>
                    
                    <?php
                }
                ?>
                

            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('myModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('myModal').style.display = "none";
        }

        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("demo");
            var captionText = document.getElementById("caption");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
            }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
            captionText.innerHTML = dots[slideIndex - 1].alt;
        }
    </script>

<?php } ?>



