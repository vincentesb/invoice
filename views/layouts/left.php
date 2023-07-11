
<?php

use app\components\AppHelper;
use app\models\LkAccessControl;
use app\models\MsUserAccess;
use dmstr\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;

$base_url  = Url::base(true); 

$isCollapse = isset($_SESSION['sidebarCollapse']) ? $_SESSION['sidebarCollapse'] : null;
$screenWidth = isset($_SESSION['screenWidth']) ? $_SESSION['screenWidth'] : null;
$paddingTop = '100px';
if ($screenWidth > 990) {
    if ($isCollapse == 1) {
        $paddingTop = '50px';
    }
} else {
    $paddingTop = '100px';
}
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" style="background-color:#dark-gray;padding-left:20px;">
      ESB
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" id="invoice" class="nav-link active" style="color:white">
              <i class="nav-icon fa-solid fa-file-invoice"></i>
              <p>
                Invoice
              </p>
            </a>
          </li>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
