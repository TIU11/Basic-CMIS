<?php
/*
Plugin Name: Basic CMIS for Wordpress
Plugin URI: https://github.com/ansonhoyt/Basic-CMIS
Description: Wordpress Plugin for basic CMIS integration. Does nothing yet, but will read from Alfresco Enterprise's CMIS interface and render a list of documents.
Version: 0.0.1 (pre-alpha)
Author: Anson Hoyt
Author URI: https://github.com/ansonhoyt
*/

// Required PHP files
$PLUGIN_PATH = dirname(__FILE__).'/';
require_once($PLUGIN_PATH . './admin.php');

/*
Define CMIS shortcode

Usage: [cmis folder="my particular/folder name/" keywords="coffee tea"]
*/
function cmis_shortcode( $attr, $content = null ) { 
    extract( shortcode_atts( array(
      'folder' => '', 
      'keywords' => '', 
      ), $attr ) );
 
    ob_start();
    ?>
    <h3>Folder: <?php echo esc_attr($folder) ?></h3>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a href="#">Some document name</a></td>
            </tr>
            <tr>
                <td><a href="#">Some document name</a></td>
            </tr>
            <tr>
                <td><a href="#">Some document name</a></td>
            </tr>
        </tbody>
    </table>
    <?php

    return ob_get_clean();
}
add_shortcode('cmis', 'cmis_shortcode');
?>
