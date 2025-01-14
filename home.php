<?php include('db_connect.php') ?>
<!-- Info boxes -->
<?php if($_SESSION['login_type'] == 1): ?>
<script>
  var welcomeMessage = 'Welcome, Administrator!';
  // Display the welcome message
  alert(welcomeMessage);
</script>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-folder"></i></span>
              <a href="./index.php?page=production">
              <div class="info-box-content">
                <span class="info-box-text">Total Categories</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM categories ")->num_rows; ?>
                </span>
              </a>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
              <a href="./index.php?page=user_list">
              <div class="info-box-content">
                <span class="info-box-text">Total Respondents</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM users where type = 3")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>

          <div class="col-12 col-sm-6 col-md-3">
          <a href="./index.php?page=user_list">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
              
              <div class="info-box-content">
                <span class="info-box-text">Total Researchers</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM users where type = 2")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
          <a href="./index.php?page=survey_templates">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>
              
              <div class="info-box-content">
                <span class="info-box-text">Total Survey</span>
                 <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM survey_set")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
          <a href="./index.php?page=inbox">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-envelope"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Messages</span>
                 <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM contact")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
      </div>
      <?php elseif($_SESSION['login_type'] == 2): ?>
        <script>
  var welcomeMessage = 'Welcome, Supervisor!';
  // Display the welcome message
  alert(welcomeMessage);
</script>
        <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <a href="./index.php?page=order_message">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-envelope"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Order Message</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM order_customer")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
          <a href="./index.php?page=production">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-folder"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Production Management</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM categories")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
          <a href="./index.php?page=manage_recipe">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Recipe Management</span>
                 <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM receipe")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
          <a href="./index.php?page=order_log">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-folder"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Production Report</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM receipe")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
      </div>

<?php else: ?>
  <script>
  var welcomeMessage = 'Welcome, Bakers!';
  // Display the welcome message
  alert(welcomeMessage);
</script>
	 <div class="col-12">
          <div class="card">
          	<div class="card-body">
          		Welcome <?php echo $_SESSION['login_name'] ?>!
          	</div>
          </div>
      </div>
      <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
          <a href="./index.php?page=batch_tracking">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-poll-h"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Batch Tracking</span>
                
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
          <a href="./index.php?page=order_log">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-folder"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Production Report</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
      </div>
          
<?php endif; ?>
