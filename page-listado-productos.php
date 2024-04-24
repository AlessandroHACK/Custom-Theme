<?php
/**
 * Template Name: Listado de Productos
 */
get_header(); ?>

<main class="contenedorCard seccion">
    <ul class="listado-gridProducto">
        <?php
        // Consulta para obtener los productos
        $args = array(
            'post_type'      => 'producto', // Tipo de publicación personalizada "Producto"
            'posts_per_page' => -1,         // Mostrar todos los productos
        );

        $productos = new WP_Query($args); //consultar la base de datos de wp

        // Verificar si hay productos
        if ($productos->have_posts()) {
            // Iterar sobre los productos
            while ($productos->have_posts()) {
                $productos->the_post(); ?>
                <li class="card">
                    <h2><?php the_title(); ?></h2>
                    <?php
                    // Mostrar la imagen destacada
                    if (has_post_thumbnail()) {
                        echo '<div class="imagen-producto">';
                        the_post_thumbnail('thumbnail');
                        echo '</div>';
                    }
                    ?>
                    <?php the_content(); ?>
                    <?php
                    // Obtener el precio del producto
                    $precio = get_post_meta(get_the_ID(), '_precio', true);
                    if ($precio) {
                        echo '<p class="precio">Precio: $' . $precio . '</p>';
                    }
                    ?>
                </li>
            <?php }
            wp_reset_postdata(); // Restaurar datos originales de la consulta
        } else {
            // Si no hay productos
            echo '<p>No se encontraron productos.</p>';
        }
        ?>
    </ul>
</main>

<?php get_footer(); ?>
