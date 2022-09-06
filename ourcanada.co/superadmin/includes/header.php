<?php
ini_set('max_execution_time', 500000);

?>
<style>
    .news_error_span
    {
        color:red;
        display:none;
    }
</style>
<div id="global-loader">
			<img src="assets/images/loader.svg" class="loader-img" alt="Loader">
		</div>
<header id="page-topbar">
  <div class="navbar-header">
    <div class="d-flex"> 
      <!-- LOGO -->
      <div class="navbar-brand-box">
        <a href="#" class="logo logo-light"> <span class="logo-sm"> <img src="assets/images/logo-light.svg" alt="" height="22"> </span> <span class="logo-lg"> <img src="assets/images/our_canada.png" alt="" height="70"> <span style="font-size: 18px; color: #fff;">Our Canada</span></span> </a>
       
                 </div>
      <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn"> <i class="fa fa-fw fa-bars"></i> </button>
 
    </div>
    <div class="d-flex">
      <div class="dropdown d-inline-block d-lg-none ml-2">
        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-magnify"></i> </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                                aria-labelledby="page-header-search-dropdown">
          <form class="p-3">
            <div class="form-group m-0">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                <div class="input-group-append">
                  <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      

      <div class="dropdown d-none d-lg-inline-block ml-1">
        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen"> <i class="bx bx-fullscreen"></i> </button>
      </div>
      <div class="dropdown d-inline-block">
        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img class="rounded-circle header-profile-user" src="assets/images/users/admin.png"
                                    alt="Header Avatar"> <span class="d-none d-xl-inline-block ml-1">Super Admin</span> <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i> </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item text-danger" href="admin_inc?method=logout"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> Logout</a> </div>
      </div>
     
    </div>
  </div>
</header>
<!-- ========== Left Sidebar Start ========== -->
	<!-- GLOBAL-LOADER -->
		
		<!-- /GLOBAL-LOADER -->
<div class="vertical-menu">
  <div data-simplebar class="h-100"> 
    
    <!--- Sidemenu -->
    <div id="sidebar-menu"> 
      <!-- Left Menu Start -->
      <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title">Menu</li>
        <li> <a href="index" class="waves-effect"> <i class="bx bx-home-circle"></i><span>Dashboard</span> </a>
        </li>
          <?php if($_SESSION[ 'role' ] == 'admin'){ ?>
          <li> <a href="javascript: void(0);" class="has-arrow waves-effect"> <i class="bx bx-male"></i> <span>Users</span> </a>
              <ul class="sub-menu" aria-expanded="false">
                  <li><a href="users-listing">Users Listing</a></li>
              </ul>
          </li>
		  <li> <a href="accounts" class="waves-effect"> <i class="bx bx-power-off"></i><span>Professional Accounts</span> </a>
        </li>
          <?php } ?>
		  <li> <a href="javascript: void(0);" class="has-arrow waves-effect"> <i class="bx bx-layout"></i> <span>User Posted Content</span> </a>
          <ul class="sub-menu" aria-expanded="false">
            <li><a href="news">News</a></li>
            <li><a href="blogs">Blogs</a></li>
          </ul>
        </li>

          <li> <a href="javascript: void(0);" class="has-arrow waves-effect"> <i class="bx bx-award"></i> <span>Comments</span> </a>
              <ul class="sub-menu" aria-expanded="false">
                  <li><a href="comments-listing">Blogs</a></li>
                  <li><a href="news-comments-listing">News</a></li>
                  <li><a href="award_comments">Awards</a></li>
                  <li><a href="story_comments">Stories</a></li>
              </ul>
          </li>
          <?php if($_SESSION[ 'role' ] == 'admin'){ ?>

          <li> <a href="gallery_content" class="waves-effect"> <i class="bx bx-layout"></i> <span>Gallery Images</span> </a>
        </li>
				<li> <a href="javascript: void(0);" class="has-arrow waves-effect"> <i class="bx bx-user"></i> <span>Moderator</span> </a>
				  <ul class="sub-menu" aria-expanded="false">
					<li><a href="moderators">All Listing</a></li>
					<li><a href="add-moderator">Add Moderator</a></li>
				  </ul>
				</li>
          <?php } ?>

          <li> <a href="javascript: void(0);" class="has-arrow waves-effect"> <i class="bx bx-upload"></i> <span>Admin Content</span> </a>
              <ul class="sub-menu" aria-expanded="false">
                  <li><a href="upload-content">Add Content</a></li>
                  <li><a href="admin-blog-listing">Blogs</a></li>
                  <li><a href="admin-news-listing">News</a></li>
              </ul>
          </li>
          <?php if($_SESSION[ 'role' ] == 'admin'){ ?>

              <li> <a href="javascript: void(0);" class="has-arrow waves-effect"> <i class="bx bx-layout"></i> <span>Categories</span> </a>
          <ul class="sub-menu" aria-expanded="false">
          <li><a href="blog-category-listing">All Categories</a></li>
          <li><a href="add-blog-category">Add Category</a></li>
          </ul>
        </li>
          <?php } ?>

          <li> <a href="javascript: void(0);" class="has-arrow waves-effect"> <i class="bx bx-award"></i> <span>Awards</span> </a>
				  <ul class="sub-menu" aria-expanded="false">
					<li><a href="award-listing">All Listing</a></li>
					<li><a href="add-award">Add Award</a></li>
				  </ul>
				</li>
          <li> <a href="javascript: void(0);" class="has-arrow waves-effect"> <i class="bx bx-award"></i> <span>Referrals</span> </a>
              <ul class="sub-menu" aria-expanded="false">
                  <li><a href="token-listings">User Referral</a></li>
              </ul>
          </li>

       

          <?php if($_SESSION[ 'role' ] == 'admin'){ ?>




		  <li> <a href="javascript: void(0);" class="has-arrow waves-effect"> <i class="bx bx-layout"></i> <span>Multi Lingual</span> </a>
				  <ul class="sub-menu" aria-expanded="false">
					<li><a href="multiLingual">All Listing</a></li>
					<li><a href="add-multi">Add Multi Lingual</a></li>
                      <li><a href="static_labels">Static Labels</a></li>
                      <li><a href="email_templates">Email Templates</a></li>
                      <li><a href="terms_and_conditions">Terms & Conditions</a></li>
                  </ul>
				</li>
              <li> <a href="forms" class="waves-effect"> <i class="bx bx-list-ul"></i><span>User Forms</span> </a>
              </li>
			<?php } ?>
		  	
       
		   <!--    <li> <a href="javascript: void(0);" class="has-arrow waves-effect"> <i class="bx bxl-blogger"></i> <span>FAQ's</span> </a>
          <ul class="sub-menu" aria-expanded="false">
			  <li><a href="faq">FAQ Listing</a></li>
            <li><a href="add-faq">Add FAQ</a></li>
            
          </ul>
        </li>
		  
        
        <li> <a href="javascript: void(0);" class="has-arrow waves-effect"> <i class="bx bx-receipt"></i> <span>Invoices</span> </a>
          <ul class="sub-menu" aria-expanded="false">
            <li><a href="invoices-list">Invoice List</a></li>
            <li><a href="invoices-detail">Invoice Detail</a></li>
          </ul>
        </li>
        <li> <a href="javascript: void(0);" class="has-arrow waves-effect"> <i class="bx bxs-user-detail"></i> <span>Users</span> </a>
          <ul class="sub-menu" aria-expanded="false">
            <li><a href="contacts-list">User List</a></li>
           
          </ul>
        </li>-->
        
       
      </ul>
    </div>
    <!-- Sidebar --> 
  </div>
</div>
<!-- Left Sidebar End -->
