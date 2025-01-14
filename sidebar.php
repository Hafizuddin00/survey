
<style>
    /* Radial Gradient Background */
    .sidebar-dark-dark {
        background: radial-gradient(circle, #28a745, #007bff, #ffc107); /* Green to Blue to Yellow */
    }

    /* Ensure no content hides rounded corners */
    .main-sidebar {
        overflow: hidden !important; /* Prevent overflow */
        border-bottom-right-radius: 70px !important; /* Bottom right corner */
    }

    /* Sidebar itself */
    .sidebar {
        height: 100%;
        border-top-right-radius: 0x !important; /* Match the radius for consistency */
        border-bottom-right-radius: 50px !important;
    }
</style>
  <aside class="main-sidebar sidebar-dark-dark elevation-4">
    <div class="dropdown">
   	<a href="javascript:void(0)" class="brand-link dropdown-toggle" data-toggle="dropdown" aria-expanded="True">
        <span class="brand-image img-circle elevation-3 d-flex justify-content-center align-items-center bg-secondary text-white font-weight-500" style="width: 38px;height:50px"><?php echo strtoupper(substr($_SESSION['login_fullname'], 0,1)) ?></span>
        <span class="brand-text font-weight-bold"><?php echo ucwords($_SESSION['login_fullname']) ?></span>

      </a>
      <div class="dropdown-menu" >
        <a class="dropdown-item manage_account" href="javascript:void(0)" data-id="<?php echo $_SESSION['login_id'] ?>">Manage Account</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="ajax.php?action=logout">Logout</a>
      </div>
    </div>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>    
        <?php if($_SESSION['login_type'] == 1): ?>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_user">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="./index.php?page=order_message" class="nav-link nav-order_message">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Order Message
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./index.php?page=production" class="nav-link nav-production">
              <i class="nav-icon fas fa-folder"></i>
              <p>
                Production Management
              </p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="./index.php?page=manage_recipe" class="nav-link nav-manage_recipe">
              <i class="nav-icon fa fa-folder"></i>
              <p>
                Recipe Management  
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./index.php?page=order_log" class="nav-link nav-order_log">
              <i class="nav-icon fa fa-folder"></i>
              <p>
                Production Report  
              </p>
            </a>
          </li>  
          <li class="nav-item">
            <a href="./index.php?page=aboutus_settings" class="nav-link nav-page-settings">
              <i class="nav-icon fa fa-cogs"></i>
              <p>
                Page Settings
              </p>
            </a>
          </li>  
          <?php elseif($_SESSION['login_type'] == 2): ?>
            <li class="nav-item">
            <a href="./index.php?page=order_message" class="nav-link nav-order_message">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Order Message
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./index.php?page=production" class="nav-link nav-production">
              <i class="nav-icon fas fa-folder"></i>
              <p>
                Production Management
              </p>
            </a>
          </li> 
         <li class="nav-item">
            <a href="./index.php?page=manage_recipe" class="nav-link nav-manage_recipe">
              <i class="nav-icon fa fa-folder"></i>
              <p>
                Recipe Management  
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./index.php?page=order_log" class="nav-link nav-order_log">
              <i class="nav-icon fa fa-folder"></i>
              <p>
                Production Report  
              </p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="./index.php?page=aboutus_settings" class="nav-link nav-page-settings">
              <i class="nav-icon fa fa-cogs"></i>
              <p>
                Page Settings
              </p>
            </a>
          </li> 
              
        <?php else: ?>
          <li class="nav-item">
            <a href="./index.php?page=batch_tracking" class="nav-link nav-batch_tracking nav-answer_survey">
              <i class="nav-icon fas fa-poll-h"></i>
              <p>
                Batch Tracking
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="./index.php?page=order_log" class="nav-link nav-order_log">
              <i class="nav-icon fa fa-folder"></i>
              <p>
                Production Report  
              </p>
            </a>
          </li>  
        <?php endif; ?>
        </ul>
      </nav>
    </div>
  </aside>
  <script>
  	$(document).ready(function(){
  		var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
  		if($('.nav-link.nav-'+page).length > 0){
  			$('.nav-link.nav-'+page).addClass('active')
          console.log($('.nav-link.nav-'+page).hasClass('tree-item'))
  			if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
          $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
  				$('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
  			}
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

  		}
      $('.manage_account').click(function(){
        uni_modal('Manage Account','manage_user.php?id='+$(this).attr('data-id'))
      })
  	})
  </script>