<?php

// Include the services file.
include("services.php");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Innoraft Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
            
        <?php 
        $i=0;
        foreach ($services as $service): 

            // Alternate the services layout based on odd or even.
            if($i%2 == 0){
        ?>
            <div class="service">
                <div class="service-rv--content">
                    <div><?php echo $service->fieldsecondary; ?></div>

                    <div class="icon">
                        <?php 
                        // Loop through the icons and display them.
                        foreach ($service->icons as $icon) {?>
                            <img src="https://ir-dev-d9.innoraft-sites.com<?php echo $icon; ?>" alt="">
                        <?php } ?>    
                    </div>
            
                    <div class="service-list">
                        <ul><?php echo $service->fieldservice; ?></ul>
                    </div>

                    <div class="cta-link">
                        <a class="btn" href="">Explore More</a>
                    </div>
                </div>

                <div>
                    <img src="https://ir-dev-d9.innoraft-sites.com<?php echo $service->image_url; ?>" alt="">
                </div>
            </div>

        <?php 
            } else {
        ?>

            <div class="service">
                <div>
                    <img src="https://ir-dev-d9.innoraft-sites.com<?php echo $service->image_url; ?>" alt="">
                </div>

                <div class="service-rv--content">
                    <div><?php echo $service->fieldsecondary; ?></div>
            
                    <div class="icon">
                        <?php 
                        // Loop through the icons and display them.
                        foreach ($service->icons as $icon) {?>
                            <img src="https://ir-dev-d9.innoraft-sites.com<?php echo $icon; ?>" alt="">
                        <?php } ?>    
                    </div>

                    <div class="service-list">
                        <ul><?php echo $service->fieldservice; ?></ul>
                    </div>
            
                    <div class="cta-link">
                        <a class="btn" href="">Explore More</a>
                    </div>
                </div>         
            </div>

        <?php 
            }
            $i++;
        endforeach; 
        ?>
    </div>
</body>
</html>
