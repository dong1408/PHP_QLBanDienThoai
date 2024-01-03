<?php
// function get_pagging($num_page, $page, $base_url = "")
// {
//     $str_pagging = "<ul id='list-paging' class='fl-right'>";
//     if ($page > 1) {
//         $page_prev = $page - 1;
//         $str_pagging .= "<li><a href='{$base_url}&page={$page_prev}'>Trước</a></li>";
//     }
//     for ($i = 1; $i <= $num_page; $i++) {
//         $active = "";
//         if ($i == $page) {
//             $active = "class='active'";
//         }
//         $str_pagging .= "<li {$active}><a href='{$base_url}&page={$i}'>{$i}</a></li>";
//     }
//     if ($page < $num_page) {
//         $page_next = $page + 1;
//         $str_pagging .= "<li><a href='{$base_url}&page={$page_next}'>Sau</a></li>";
//     }
//     $str_pagging .= "</ul>";
//     echo $str_pagging;
// }


function get_pagging($num_page, $page, $base_url = "")
{
    $str_pagging = "<ul class='pagination'>";
    if ($page > 1) {
        $page_prev = $page - 1;
        $str_pagging .= "<li class='page-item'><a href='{$base_url}&page={$page_prev}' class='page-link'>Trước</a></li>";
    }
    for ($i = 1; $i <= $num_page; $i++) {
        $style = "";
        if ($i == $page) {
            $style = "border: 1px solid red;
            margin:0px 1px";
        }
        $str_pagging .= "<li class='page-item' style='{$style}' ><a class='page-link' href='{$base_url}&page={$i}'>{$i}</a></li>";
    }
    if ($page < $num_page) {
        $page_next = $page + 1;
        $str_pagging .= "<li class='page-item'><a class='page-link' href='{$base_url}&page={$page_next}'>Sau</a></li>";
    }
    $str_pagging .= "</ul>";
    echo $str_pagging;
}

?>
