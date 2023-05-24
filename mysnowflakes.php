<?php
/*
Plugin Name: Snow Falling JS
Plugin URI: https://dekpo.com
Description: Ce plugin permet de faire tomber la neige
Author: C'est ouam
Version: 1.0
*/

// Adding mysnowflakes js script
function let_it_snow(){
    if (is_front_page()){
        wp_enqueue_script('my_snow_flakes', plugin_dir_url(__FILE__) . 'mysnowflakes.js');
    }  
}
add_action('wp_enqueue_scripts','let_it_snow',1);

// Adding admin page
function my_admin_options_flakes(){
    add_options_page(
        'My Snowflakes options',
        'Snowflakes',
        'manage_options',
        'my-snowflakes-options',
        'my_snowflakes_rendering_function'
    );
}
add_action('admin_menu','my_admin_options_flakes');

// Adding admin page rendering
function my_snowflakes_rendering_function(){
    ?>
    <h2>My Snowflakes Params</h2>
    <form action="options.php" method="post">
        <?php
        settings_fields('my-snowflakes-options');
        do_settings_sections('my-snowflakes-options');
        ?>
        <input type="submit" name="Save" class="button button-primary" value="Save">
    </form>
<?php
}

function my_snowflakes_register_settings(){
    register_setting(
        'my-snowflakes-options',
        'my_snowflakes_color'
    );
    register_setting(
        'my-snowflakes-options',
        'my_snowflakes_max'
    );
    add_settings_section(
       'my_snowflakes_settings_section',
       'Snowflakes settings section',
       'my_snowflakes_first_section',
       'my-snowflakes-options'
    );
    add_settings_field(
        'my_snowflakes_color',
        'Snowflakes Color Hex',
        'my_snowflakes_color_html_input',
        'my-snowflakes-options',
        'my_snowflakes_settings_section'
     );
     add_settings_field(
        'my_snowflakes_max',
        'Snowflakes Max Active',
        'my_snowflakes_max_html_input',
        'my-snowflakes-options',
        'my_snowflakes_settings_section'
     );
}
add_action('admin_init','my_snowflakes_register_settings');

function my_snowflakes_first_section(){
    echo '<p>This is our snowflakes settings section';
}

function my_snowflakes_color_html_input(){
?>
<input type="text" id="my_snowflakes_color" name="my_snowflakes_color" value="<?php echo get_option('my_snowflakes_color','#FF0000') ?>">
<?php
}

function my_snowflakes_max_html_input(){
    ?>
    <input type="text" id="my_snowflakes_max" name="my_snowflakes_max" value="<?php echo get_option('my_snowflakes_max','256') ?>">
    <?php
    }

function my_snowflakes_front_settings_script(){
?>
<script>
snowStorm.snowColor="<?php echo get_option('my_snowflakes_color','#FF0000') ?>";
snowStorm.flakesMaxActive="<?php echo get_option('my_snowflakes_max','256') ?>";
</script>
<?php
}

add_action('wp_head','my_snowflakes_front_settings_script');