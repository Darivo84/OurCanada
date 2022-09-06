<?php
include_once( "admin_inc.php" );
$cur_lang = '';
$view_lang = '';
if(isset($_GET['lang']) && !empty($_GET['lang'])){
    $cur_lang = "_".$_GET['lang'];
    $view_lang = '/'.$_GET['lang'];
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<?php include_once("includes/style.php"); ?>
</head>

<body data-sidebar="dark">

<!-- Begin page -->
<div id="layout-wrapper">
  <?php include_once("includes/header.php"); ?>
  
  <!-- ============================================================== --> 
  <!-- Start right Content here --> 
  <!-- ============================================================== -->
  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid"> 
        
        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
              <h4 class="mb-0 font-size-18">News Comments</h4>
              <div class="page-title-right">
                <select onchange="getContent(this.value);" class="form-control">
                    <option <?php if(str_replace('_', '', $cur_lang) == ""){echo "selected";} ?> value="">English</option>
                    <option <?php if(str_replace('_', '', $cur_lang) == "chinese"){echo "selected";} ?> value="chinese">Chinese</option>
                    <option <?php if(str_replace('_', '', $cur_lang) == "francais"){echo "selected";} ?> value="francais">Francais</option>
                    <option <?php if(str_replace('_', '', $cur_lang) == "hindi"){echo "selected";} ?> value="hindi">Hindi</option>
                    <option <?php if(str_replace('_', '', $cur_lang) == "spanish"){echo "selected";} ?> value="spanish">Spanish</option>
                    <option <?php if(str_replace('_', '', $cur_lang) == "urdu"){echo "selected";} ?> value="urdu">Urdu</option>
                    <option <?php if(str_replace('_', '', $cur_lang) == "punjabi"){echo "selected";} ?> value="punjabi">Punjabi</option>
                    <option <?php if(str_replace('_', '', $cur_lang) == "arabic"){echo "selected";} ?> value="arabic">Arabic</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <!--  <div class="row justify-content-end">
                <div class="col-lg-12 text-right mb-3">
                      <a href="add-users-listing.php" class="btn btn-primary">Add News</a>
                    </div>
                  </div>-->
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
             <!-- <a href="add-award.php" style="padding: 7px; margin-bottom: 15px; float: right;" class="btn btn-primary waves-effect waves-light btn-sm">Add Award & Nomination</a> -->
                                      <br>
                                      <br>
                <div class="table-responsive">
                  <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" style="width: 100px">#</th>
                        <th scope="col">Blog Title</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Comment</th>
                        <th scope="col">Date</th>
                        <th scope="col">Aprove</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $count = 1;
                      $langName = 'english';
                      $table_name = 'news_content';
                      if(isset($_GET['lang']) && !empty($_GET['lang'])){
                        $langName = $_GET['lang'];
                        $table_name = $table_name.'_'.$_GET['lang'];
                      }
                      $sqlQuery = " SELECT news_comments.*,news_comments.status as c_status,news_comments.id as com_id,".$table_name.".title,users.username,DATE_FORMAT(news_comments.created_at,'%M %d,%Y %h:%i %p') as c_date FROM news_comments 
                      LEFT JOIN users ON news_comments.user_id = users.id 
                      LEFT JOIN ".$table_name." ON news_comments.content_id = ".$table_name.".id 
                      WHERE news_comments.lang = '".$langName."' 
                      ORDER BY news_comments.id DESC";
                      // $getCom = mysqli_query($conn,"SELECT news_comments.*,news_comments.status as c_status,news_comments.id as com_id,`news_content`.title,users.username,DATE_FORMAT(news_comments.created_at,'%M %d,%Y %h:%i %p') as c_date FROM news_comments LEFT JOIN `news_content` ON news_comments.content_id = `news_content`.id LEFT JOIN users ON news_comments.user_id = users.id ORDER BY news_comments.id DESC");
                      $getCom = mysqli_query($conn,$sqlQuery);
                      while ($com_row = mysqli_fetch_assoc($getCom)) {
                      ?>
                      <tr>
                        <td><?= $count++ ?></td>
                        <td title="<?= $com_row['title'] ?>"><?php if(strlen($com_row['title']) > 25){echo substr($com_row['title'], 0,25).'...';}else{echo $com_row['title'];} ?></td>
                        <td><?= $com_row['username'] ?></td>
                        <td title="<?= $com_row['comment'] ?>"><?php if(strlen($com_row['comment']) > 25){echo substr($com_row['comment'], 0,25).'...';}else{echo $com_row['comment'];} ?></td>
                        <td><?= $com_row['c_date'] ?></td>
                        <td><label class=""><input type="checkbox" name="custom-switch-checkbox" class="get_value custom-switch-input" <?php if($com_row['c_status'] == 1){echo "checked";} ?> onChange="aprove($(this),<?= $com_row['com_id'] ?>);"><span class="custom-switch-indicator"></span></label></td>
                        <td>
                          <button onclick="editComment('<?= $com_row['comment'] ?>',<?= $com_row['com_id'] ?>)" class="btn btn-success"><i class="fa fa-edit"></i></button>
                          <button onclick="deleteComment(<?= $com_row['com_id'] ?>)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end row --> 
        
        <!--    <div class="row">
                            <div class="col-12">
                                <div class="text-center my-3">
                                    <a href="javascript:void(0);" class="text-success"><i class="bx bx-loader bx-spin font-size-18 align-middle mr-2"></i> Load more </a>
                                </div>
                            </div> 
                        </div>
                         end row --> 
        
      </div>
      <!-- container-fluid --> 
    </div>
    <!-- End Page-content -->
    
    <?php include_once("includes/footer.php"); ?>
  </div>
  <!-- end main content--> 
  
</div>
<!-- END layout-wrapper --> 

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
<!-- Delete Modal -->
<div id="smallModal" class="modal fade">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete Award</h6>
      </div>
      <div class="modal-body">
        <div class="prompt"></div>
        <p>Are you sure you want to delete this award?</p>
      </div>
      <!-- MODAL-BODY -->
      <div class="modal-footer">
        <input type="hidden" name="id" id="d_id">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
        <button id="addLoader" type="button" class="btn btn-danger" onClick="deleteCategory(document.getElementById('d_id').value)">Delete</button>
      </div>
    </div>
  </div>
  <!-- MODAL-DIALOG --> 
</div>

<div id="NominationModal" class="modal">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete Nomination</h6>
      </div>
      <div class="modal-body">
        <div class="prompt"></div>
        <p>Are you sure you want to delete this nomination?</p>
      </div>
      <!-- MODAL-BODY -->
      <div class="modal-footer">
        <input type="hidden" name="id" id="n_id">
        <button type="button" class="btn btn-light" data-dismiss="modal" onclick="$('#NominationModal').hide(); $('#n_id').val('');">Cancel</button>
        <button id="addLoader" type="button" class="btn btn-danger" onClick="delNomiation()">Delete</button>
      </div>
    </div>
  </div>
  <!-- MODAL-DIALOG --> 
</div>

<div id="delCommentModal" class="modal">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete Comment</h6>
      </div>
      <div class="modal-body">
        <div class="prompt"></div>
        <p>Are you sure you want to delete this comment?</p>
      </div>
      <!-- MODAL-BODY -->
      <div class="modal-footer">
        <input type="hidden" name="id" id="n_id">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
        <button id="addLoader" type="button" class="btn btn-danger"><i class="fa fa-spin fa-spinner" style="display: none; margin-right: 5px;"></i>Delete</button>
      </div>
    </div>
  </div>
  <!-- MODAL-DIALOG --> 
</div>

<div id="editComment" class="modal">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Update Comment</h6>
      </div>
      <div class="modal-body">
        <div class="prompt"></div>
        <textarea maxlength="1000" class="form-control"></textarea>
        <p class="text-danger" id="length"></p>
      </div>
      <!-- MODAL-BODY -->
      <div class="modal-footer">
        <input type="hidden" name="id" id="n_id">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
        <button id="addLoader" type="button" class="btn btn-success"><i class="fa fa-spinner fa-spin" style="display: none; margin-right: 5px;"></i> Update</button>
      </div>
    </div>
  </div>
  <!-- MODAL-DIALOG --> 
</div>
<?php include_once("includes/script.php"); ?>
<script>

  function getContent(value){
        if(value != ""){
            window.location.href = "<?php echo $currentTheme ?>superadmin/news-comments-listing?lang="+value;
        }else{
            window.location.href = "<?php echo $currentTheme ?>superadmin/news-comments-listing";
        }
    }
  $(document).ready( function () {
  
     $('#categoryTable').dataTable(); 
} );

  function aprove(sel,id){
    $.ajax({
      type: "POST",
      url: "<?= $super_admin ?>ajax.php?h=new_comment_satus",
      data: {id:id},
      dataType: "json",
      success:function(res){
        console.log(res)
      },error: function(e){
        console.log(e)
      }
    });
  }
  
  function deleteComment(id){
      $("#delCommentModal .prompt").attr("class","prompt");
      $("#delCommentModal .prompt").text("");
      var comment_id = id;
      $("#delCommentModal").modal();
      
      $("#delCommentModal .btn-light").click(function(){
        $("#delCommentModal .close").click();
      });

      $("#delCommentModal .btn-danger").click(function(){
        var sel = $(this);
        $.ajax({
          type: "POST",
          url: "<?= $super_admin ?>ajax.php?h=delete_comment",
          data: {id:comment_id,table:"news_comments"},
          dataType: "json",
          beforeSend: function(){
            sel.children("i").show();
          },success: function(res){
            sel.children("i").hide();
            if(res.success){
              window.location.reload();
            }else{
              $("#delCommentModal .prompt").attr("class","prompt alert alert-danger");
              $("#delCommentModal .prompt").text("Failed to delete comment.");
            }
            console.log(res)
          },error: function(e){
            sel.children("i").hide();
            console.log(e)
          }
        });
      });
    }

    function editComment(comment,id){
      $("#editComment .prompt").attr("class","prompt");
      $("#editComment .prompt").text("");
      var comment_id = id;
      $("#editComment").modal();
      $("#editComment textarea").val(comment);
      $("#editComment #length").text(comment.length+"/1000");
      $("#editComment textarea").on("keyup",function(){
        $("#editComment #length").text($(this).val().length+"/1000");
        if($(this).val().length > 0){
          $("#editComment .btn-success").prop("disabled",false);
        }else{
          $("#editComment .btn-success").prop("disabled",true);
        }
      });

      $("#editComment .btn-success").click(function(){
        var sel = $(this);
        var update_comment =  $("#editComment textarea").val();
        $.ajax({
          type: "POST",
          url: "<?= $super_admin ?>ajax.php?h=update_comment",
          data:{id:comment_id,comment:update_comment,table:"news_comments"},
          dataType: "json",
          beforeSend: function(){
            sel.children("i").show();
          },success: function(res){
            sel.children("i").hide();
            console.log(res);
            if(res.success){
              window.location.reload();
            }else{
              $("#editComment .prompt").attr("class","prompt alert alert-danger");
              $("#editComment .prompt").text("Failed to update comment.");
            }
          },error: function(e){
            sel.children("i").hide();
            console.log(e);
          }
        });
      });
    }

  </script> 
</body>
</html>
