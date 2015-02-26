<?php
/**
 * This file has all the auxilory functions regarding the display of content and its editing
 */

//function to validate internal links
function verify_internal_link($link) {
    global $mysqli;
    $title_query = $mysqli->query("SELECT page_title FROM page WHERE page_title='$link'");
    if($title_query->num_rows == 0) return FALSE;
    else return TRUE;
}
function text_to_link($text) {
    preg_match_all("/\[\[[a-zA-Z ]*\]\]/", $text, $output_array);
    foreach ($output_array[0] as &$value) {
        $len = strlen($value);
        $value_new = substr($value, 2, $len-4);
        if(verify_internal_link($value_new)) {
            $value_link = preg_replace("/[ ]/", "_", $value_new);
            $link = '<a href="articles/'.$value_link.'" class="true-link">'.$value_new.'</a>';
            $text = str_replace($value, $link, $text);
        }
        else {
            $value_link = preg_replace("/[ ]/", "_", $value_new);
            $link = '<a href="#" class="false-link">'.$value_new.'</a>';
            $text = str_replace($value, $link, $text);
        }
        
    }
    return $text;
}
//function to convert <a href="Article_Name">Article Name</a> to [[Article Name]]
function link_to_text($text) {
    preg_match_all("/\<a href=\"[a-zA-Z_\/]*\" class=\"[a-zA-Z-]*\">[a-zA-Z ]*<\/a>/", $text, $output_array);

    foreach ($output_array[0] as &$value) {
        preg_match("/>[a-zA-Z ]*</", $value, $output_value);
        $len = strlen($output_value[0]);
        $value_new = substr($output_value[0], 1, $len-2);
        $value_new = '[['.$value_new.']]';
        $text = str_replace($value, $value_new, $text);
    }    
    return $text;
}
?>