<?php

function show_array($data) {
    if (is_array($data)) {
        echo "<pre>";
        print_r($data);
        echo "<pre>";
    }
}

function numRowOfList($list = array())
{
    $count = 0;
    if (!empty($list)) {
        foreach ($list as $item) {
            $count++;
        }
    }
    return $count;
}

