<?php
/* Template Name: page visa */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Styles -->
    
    <link href="<?php bloginfo('template_url')?>/css/style.css" rel="stylesheet">
    <link href="<?php bloginfo('template_url')?>/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <div class="banner">
        <img src="<?php bloginfo('template_url')?>/images/uploads/visa.jpg" alt="" class="w-100">
    </div>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
        the_content();
    endwhile; else: ?>
        <p>Sorry, no posts matched your criteria.</p>
    <?php endif; ?>
</div>


<!-- ./wrapper -->

<!-- jQuery -->



</body>
</html>
