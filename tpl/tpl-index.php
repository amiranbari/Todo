<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title><?=SITE_TITLE?></title>
  <link rel="stylesheet" href="<?=BASE_URL?>assets/css/style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="page">
  <div class="pageHeader">
    <div class="title">Dashboard</div>
    <div class="userPanel">
    <a href="<?= site_url("?logout=1")?>"><i class="fa fa-sign-out"></i></a>
    <span class="username"><?= $user->name ?? 'Unknown'; ?></span>
    <img src="<?= $user->image; ?>" width="40" height="40"/></div>
  </div>
  <div class="main">
    <div class="nav">
      <div class="searchbox">
        <div><i class="fa fa-search"></i>
          <input type="search" placeholder="Search"/>
        </div>
      </div>
      <div class="menu">
        <div class="title">Folders</div>
        <ul class="folder-list">
          <li class="<?=isset($_GET['folder_id']) ? '' : 'active'?>">
          <a href="<?= site_url() ?>"><i class="fa fa-folder"></i>All</a>
          </li>

          <?php foreach ($folders as $folder): ?>
          <li class="<?=($_GET['folder_id'] == $folder->id) ? 'active' : ''?>">
          <a href="<?= site_url("?folder_id=$folder->id") ?>"><i class="fa fa-folder"></i><?=$folder->name?></a>
          <a href="?delete_folder=<?=$folder->id?>" class="remove"  onclick="return confirm('Are You Sure to delete this Item?\n<?=$folder->name?>');">x</a>
          </li>
          <?php endforeach;?>

        </ul>
      </div>
      <div>
        <input type="text" id="addFolderInput" style='width: 65%;margin-left:3%' placeholder="Add New Folder"/>
        <button id="addFolderBtn" class="btn clickable">+</button>
      </div>
    </div>
    <div class="view">
      <div class="viewHeader">
        <div class="title" style="width: 50%;">
        <input type="text" id="taskNameInput" style="width: 100%;margin-left:3%;line-height: 30px;" placeholder="Add New Task">
        </div>
        <div class="functions">
          <div class="button active">Add New Task</div>
          <div class="button">Completed</div>
        </div>
      </div>
      <div class="content">
        <div class="list">
          <div class="title">Today</div>
          <ul>
          <?php if (sizeof($tasks)): ?>
          <?php foreach ($tasks as $task): ?>
            <li class="<?=$task->is_done ? 'checked' : '';?>">
              <i data-taskId="<?=$task->id?>" class="isDone clickable fa <?=$task->is_done ? 'fa-check-square-o' : 'fa-square-o';?> "></i>
              <span><?=$task->title?></span>
              <div class="info">
                <span class='created-at'>Created At <?=$task->created_at?></span>
                <a href="?delete_task=<?=$task->id?>" class="remove" onclick="return confirm('Are You Sure to delete this Item?\n<?=$task->title?>');">x</a>
              </div>
            </li>
            <?php endforeach;?>
          <?php else: ?>
            <li>No Task Here ..</li>
          <?php endif;?>

          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script  src="assets/js/script.js"></script>
  <script>
    $(document).ready(function(){

      $('.isDone').click(function(e){
          var tid = $(this).attr('data-taskId');
          $.ajax({
            url : "process/ajaxHandler.php",
            method : "post",
            data : {action: "doneSwitch",taskId : tid},
            success : function(response){
                location.reload();
            }
          });
      });

      $('#addFolderBtn').click(function(e){
          var input = $('input#addFolderInput');
          $.ajax({
            url : "process/ajaxHandler.php",
            method : "post",
            data : {action: "addFolder",folderName: input.val()},
            success : function(response){
              if(response == '1'){
                $('<li> <a href="#"><i class="fa fa-folder"></i>'+input.val()+'</a></li>').appendTo('ul.folder-list');
              }else{
                alert(response);
              }
            }
          });
      });

      $('#taskNameInput').on('keypress',function(e) {
          e.stopPropagation();
          if(e.which == 13) {
              $.ajax({
                url : "process/ajaxHandler.php",
                method : "post",
                data : {action: "addTask",folderId : <?= $_GET['folder_id'] ?? 0 ?> ,taskTitle: $('#taskNameInput').val()},
                success : function(response){
                  if(response == '1'){
                    location.reload();
                  }else{
                    alert(response);
                  }
                }
              });
          }
      });
      $('#taskNameInput').focus();
    });

  </script>
</body>
</html>
