<?php
/*
Plugin Name: Basic CMIS for Wordpress
Plugin URI: https://github.com/ansonhoyt/Basic-CMIS
Description: Wordpress Plugin for basic CMIS integration. Searches a CMIS compliant system and renders the matching documents. Tested with Alfresco Enterprise's CMIS service.
Version: 0.0.1 (pre-alpha)
Author: Anson Hoyt
Author URI: https://github.com/ansonhoyt
*/

// Required PHP files
$PLUGIN_PATH = dirname(__FILE__).'/';
require_once($PLUGIN_PATH . '/admin.php');
require_once ($PLUGIN_PATH . '/lib/cmis_repository_wrapper.php');
require_once ($PLUGIN_PATH . '/stream.php');

/*
Define CMIS shortcode

Usage:
    [cmis folder="/my particular/folder name/"] # Docs in the folder
    [cmis tree="/my particular/folder name/"]   # Docs in the folder, including subfolders
    [cmis keywords="coffee tea"]                # Docs containing the keywords
    [cmis name="Agenda%.doc"]                   # Docs whose name matches. May include wildcard character '%'.
*/
function cmis_shortcode( $attr, $content = null ) { 
    extract( shortcode_atts( array(
      'folder' => '', 
      'tree' => '', 
      'keywords' => '', 
      'name' => '', 
      ), $attr ) );

    return do_cmis($folder, $tree, $keywords, $name);
}
add_shortcode('cmis', 'cmis_shortcode');

/*
Perform specified retrieve and return rendered table of documents.
*/
function do_cmis($folder, $tree, $keywords, $name) {
    // Initialize CMIS Client
    $repo_url = get_option('cmis_repository_url');
    $repo_username = get_option('cmis_username');
    $repo_password = get_option('cmis_password');
    $client = new CMISService($repo_url, $repo_username, $repo_password);
    $query_conditions = array();

    try {
        if ($folder) {
            $f = $client->getObjectByPath($folder);
            array_push($query_conditions, "IN_FOLDER('$f->id')");
        }
        elseif ($tree) {
            $f = $client->getObjectByPath($tree);
            array_push($query_conditions, "IN_TREE('$f->id')");
        }

        if ($keywords) {
            array_push($query_conditions, "CONTAINS('$keywords')");
        }

        if ($name) {
            array_push($query_conditions, "cmis:name LIKE '$name'");
        }

        // Perform query
        if(sizeof($query_conditions)) {
            $query = "SELECT * FROM cmis:document WHERE " . join(" AND ", $query_conditions);
            $objs = $client->query($query);
            return display_cmis_objects($objs);
        }
    }
    catch (CmisRuntimeException $e) {
        echo '<div class="alert">', 'Caught exception: ', $e, '</div>';
    }
    return '<div class="alert">Unable to show documents.</div>';
}

function display_cmis_objects($objs) {
    ob_start();
    ?>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Updated</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($objs->objectList as $obj) {
            display_cmis_object($obj);
        }
        ?>
        </tbody>
    </table>
    <?php

    $ret = ob_get_contents();
    ob_end_clean();
    return $ret;
}

function display_cmis_object($obj) {
    $name = $obj->properties['cmis:name'];
    ?>
    <tr>
        <td>
            <a href="<?php echo get_object_url($obj) ?>">
                <?php echo get_object_icon($obj); ?>
                <?php echo $name ?>
            </a>
        </td>
        <td>
            <?php
                $date_string = $obj->properties['cmis:lastModificationDate'];
                $timestamp = strtotime($date_string);
                #$timestamp = DateTime::createFromFormat('Y-m-dThh:mm:ss:mmmT', $date_string);
                echo date( "M d Y h:i a", $timestamp);
            ?>
        </td>
    </tr>
    <?php
}

function get_object_icon($obj) {
    $name = $obj->properties['cmis:name'];
    $mimeType = $obj->properties['cmis:contentStreamMimeType'];
    $docType = $obj->properties['cmis:baseTypeId'];
    $icon = '_default.gif';

    if($docType == 'cmis:folder') {
        $icon = 'folder.gif';
    } else {
        // Determine icon image based on Mime Type
        switch($mimeType) {
            case 'image/bmp':
                $icon = 'bmp.gif';
                break;
            case 'image/jpeg':
                $icon = 'jpg.gif';
                break;
            case 'application/x-shockwave-flash':
                $icon = 'swf.gif';
                break;
            case 'text/html':
                $icon = 'htm.gif';
                break;
            case 'application/zip':
                $icon = 'zip.gif';
                break;
            case 'video/x-ms-wmv':
            case 'video/x-msvideo':
                $icon = 'wmv.gif';
                break;
            case 'application/msword':
                $icon = 'doc.gif';
                break;
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                $icon = 'pptx.gif';
                break;
            case 'application/vnd.powerpoint':
            case 'application/vnd.ms-powerpoint':
                $icon = 'ppt.gif';
                break;
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                $icon = 'docx.gif';
                break;
            case 'audio/x-mpeg':
                $icon = 'mp3.gif';
                break;
            case 'application/vnd.ms-excel':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                $icon = 'xls.gif';
                break;
            case 'application/x-javascript':
                $icon = 'js.gif';
                break;
            case 'application/pdf':
                $icon = 'pdf.gif';
                break;
            case 'application/acp':
                $icon = 'acp.gif';
                break;
            case 'text/plain':
                $icon = 'txt.gif';
                break;
            default:
                $icon = '_default.gif';
        }
    }

    return <<<EOD
    <img src="/wp-content/plugins/basic-cmis/img/$icon" alt="$name" title="$name">
EOD;
}

function get_object_url($obj) {
    $siteurl = get_option('siteurl');
    $id = $obj->properties['cmis:objectId'];
    return $siteurl . '?cmis_obj_id=' . urlencode($id);
}

?>
