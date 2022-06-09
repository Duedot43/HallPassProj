<?php
include "usr_pre_fls/checks.php";


ck_page();
check_string($_GET['room'], "INVALID ROOM VALUE NOT NUMERIC");


$user_json = json_decode(file_get_contents("registered_phid/" . $_COOKIE['phid']), true);


if ($user_json['student_activ'] == 0){
    $user_json['student_activ'] = 1;
} else{
    $user_json['student_activ'] = 0;
}


$date = date("d") . "/" . date("m") . "/" . date("y");
$time = time();
if ($user_json['student_activ'] == 0){
    $time1 = $user_json['activity'][$date][count($user_json['activity'][$date])-1]["timeDep"];
    $time2 = time();
} else{
    $time1 = time();
    $time2 = $user_json['activity'][$date][count($user_json['activity'][$date])-1]["timeDep"];
}
if (!isset($user_json['activity'][$date])){
    $user_json['activity'] =  array(
        $date=>array(
            0=>array(
                "room"=>$_GET['room'],
                "timeDep"=>$time1,
                "timeArv"=>$time2
            )
        )
    );
    write_json($user_json, "registered_phid/" . $_COOKIE['phid']);
    header("Location: index.php?room=" . $_GET['room'] . "&page=main");
    exit();
} else{
    $user_json['activity'][$date][count($user_json['activity'][$date])] = array(
        "room"=>$_GET['room'],
        "timeDep"=>$time1,
        "timeArv"=>$time2
    );
    write_json($user_json, "registered_phid/" . $_COOKIE['phid']);
    header("Location: index.php?room=" . $_GET['room'] . "&page=main");
    exit();
}
?>