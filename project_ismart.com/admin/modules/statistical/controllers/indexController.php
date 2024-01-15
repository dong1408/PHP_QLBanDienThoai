<?php

function construct()
{
    
}

function indexAction()
{
    $statistical = (isset($_GET['statistical'])) ? $_GET['statistical'] : 'time';
    $typeStatistical = 'statisticalByDate';
    if(isset($_POST['filter'])){
        $typeStatistical = $_POST['typeStatistical'];        
    }
    $data = array(
        'typeStatistical' => $typeStatistical,
        'staistical' => $statistical
    );
    load_view('index', $data);
}


?>