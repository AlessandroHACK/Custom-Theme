<?php get_header();
?>
   
    <main class="seccion contenedor">
        <?php 
            //consulta el objeto 
            $categoria = get_queried_object();
        ?>
        <h2 class="text-primary text-center">Categoria:  <?php echo $categoria->name;?></h2>

    <ul class="listado-grid"> 
    <?php
    while (have_posts()){
        
        the_post();
        get_template_part('template-parts/blog');
    }
    
?>
    </ul>
    </main>
    <?php get_footer(); ?>
