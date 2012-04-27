<?php
add_action('plugins_loaded', 'cmis_download');

function cmis_download() {
    $cmis_object_id = $_GET['cmis_obj_id'];

    if($cmis_object_id != '')
    {
        $client = new CMISService(get_option('cmis_repository_url'), get_option('cmis_username'), get_option('cmis_password'));
        $props = $client->getProperties($cmis_object_id);

        $file_name = $props->properties['cmis:name'];
        $file_size = $props->properties['cmis:contentStreamLength'];
        $mime_type = $props->properties['cmis:contentStreamMimeType'];

        header('Content-type: $mime_type');
        header('Content-Disposition: attachment; filename="'.$file_name.'"');
        header("Content-length: $file_size");

        $content = $client->getContentStream($cmis_object_id);

        echo $content;
    }
}
?>
