<div class="page-breadcrumb">
    <ol class="breadcrumb container">
        <li><a href="javascript:void(0)">Connect & Learn</a></li>
        <li class="active">Trends </li>
    </ol>
</div>
    

    <!-- Styles -->
    <link href="<?php echo base_url() ?>assets/css/main.css" rel="stylesheet">

    

    <div id="primary" class="col-sm-12">
      <div class="content">
       
          <?php 
          //echo '<pre />'; print_r($trends); 
          foreach($trends as $td) { ?>
          <section class="post">
          <header class="entry-header">
            
            <h2 class="entry-title"><?php echo $td['Title'] ?></h2>
            <p class="entry-meta">
              Posted on <a class="entry-date" href="date.html"><?php echo $td['timestamp'] ?></a> <!--| By <a class="entry-author" href="author.html">Paul Laros</a> | Tags <a class="label label-danger" href="tag.html">CSS3</a>-->
            </p>
          </header>
          <div class="entry-description">
              <img class="img-responsive" src="<?php echo $td['Document'] ?>" />
              <p style="    margin-top: 20px;">
                <?php echo $td['Description'] ?>
            </p>
          </div>
        </section> <!-- /.post -->
        
          <?php } ?>

       

      </div>
    </div> <!-- /#primary -->
