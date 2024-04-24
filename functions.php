<?php

function setUp(){
    //imagenes destacadas
    add_theme_support('post-thumbnails');

    //titulos para SEO
    add_theme_support('title-tag');
}

add_action('after_setup_theme', 'setUp');

function menu(){
    register_nav_menus(array(
        'menu-principal' => __('Menu Principal', 'editorialC')
    ));
}

add_action('init', 'menu');

function scripts_styles(){
    wp_enqueue_style('normalize', 'https://necolas.github.io/normalize.css/',array(),'8.0.1');
    wp_enqueue_style('style', get_stylesheet_uri(),array('normalize'),'1.0.0');
}

add_action('wp_enqueue_scripts', 'scripts_styles');

//definir zona se widgets

function widgets(){

    register_sidebar(array(
        'name' => 'sidebar 1',
        'id' => 'sidebar_1',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="text-center">',
        'after_title' => '</h3>'
    ));

}
add_action('widgets_init','widgets');

function cargar_scripts_personalizados() {
    // Registra el archivo scripts.js en WordPress
    wp_register_script('scripts', get_template_directory_uri() . '/js/scripts.js', array(), '1.0.0', true);

    // Lo encola para que se cargue en el front-end
    wp_enqueue_script('scripts');
}
add_action('wp_enqueue_scripts', 'cargar_scripts_personalizados');

// Registrar el punto de acceso personalizado para obtener datos de productos en formato JSON
add_action('rest_api_init', 'register_custom_products_endpoint');

function register_custom_products_endpoint() {
    register_rest_route('custom/v1', '/products', array(
        'methods' => 'GET',
        'callback' => 'get_custom_products_data',
    ));
}

// Controlador para obtener datos de productos
function get_custom_products_data() {
    $args = array(
        'post_type' => 'producto', // Reemplaza 'producto' con el nombre de tu tipo de publicación de productos
        'posts_per_page' => -1, // Obtener todos los productos
    );

    $query = new WP_Query($args);

    $products = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Obtener el precio del producto
            $precio = get_post_meta(get_the_ID(), '_precio', true);

            $product = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'content' => get_the_content(),
                'precio' => $precio // Añadir el precio aquí
            );

            $products[] = $product;
        }
    }

    wp_reset_postdata();

    // Devolver los datos de los productos como JSON
    wp_send_json($products);
}

// Agrega este código en tu functions.php del plugin 'custom-features'
add_action( 'rest_api_init', function () {
    register_rest_route( 'custom-features/v1', '/productos/', array(
        'methods' => 'GET',
        'callback' => 'get_custom_products_data',
    ) );
} );
