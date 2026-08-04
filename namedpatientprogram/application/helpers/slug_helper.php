<?php
// function create_slug($string)
// {
//     $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($string));
//     return trim($slug, '-');
// }

function create_slug($string)
{
    // convert to lowercase
    $string = strtolower($string);

    // decode html entities
    $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');

    // replace anything not a-z, 0-9 with dash
    $string = preg_replace('/[^a-z0-9]+/', '-', $string);

    // remove duplicate dashes
    $string = preg_replace('/-+/', '-', $string);

    // trim dashes
    return trim($string, '-');
}