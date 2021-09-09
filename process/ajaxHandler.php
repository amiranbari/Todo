<?php
include_once "../bootstrap/init.php";

if(!isAjaxRequest()){
    diePage("Invalid Request!");
}

if(!isset($_POST['action']) || empty($_POST['action'])){
    diePage("Invalid Action!");
}


switch($_POST['action']){
    case "doneSwitch":
        $task_id = $_POST['taskId'];
        if(!isset($task_id) || !is_numeric($task_id)){
            echo "آیدی تسک معتبر نیست";
            die();
        }
        doneSwith($task_id);
    break;
    case "addFolder":
        if(!isset($_POST['folderName']) || strlen($_POST['folderName']) < 3){
            echo "نام فولدر باید بزرگتر از 2 حرف باشد.";
            die();
        }
        echo addFolder($_POST['folderName']);
    break;
    case "addTask":
        $folderId = $_POST['folderId'];
        $taskTitle = $_POST['taskTitle'];
        if(!isset($folderId) || empty($folderId)){
            echo "فولدر را انتخاب کنید.";
            die();
        }
        if(!isset($taskTitle) || strlen($taskTitle) < 3){
            echo "عنوان تسک باید بزرگتر از 2 حرف باشد.";
            die();
        }
        echo addTask($taskTitle,$folderId);
    break;

    default:
        diePage("Invalid Action!");
}