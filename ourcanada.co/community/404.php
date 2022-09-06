
<?php  include_once( "user_inc.php" );
?>

<!DOCTYPE html>

<html lang="en-US">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="">
<meta name="description" content="">
<meta name="keywords" content="">
<!-- Title-->
<title><?= $allLabelsArray[689] ?></title>
<!-- Favicon-->
<!-- end head -->
</head>

<body>
  <div class="container">
     <div class="row">
       <div class="col-md-2"></div>
       <div class="col-md-8">
        <div class="error-template text-center">
          <h1 class="text-center">404</h1><h2><?= $allLabelsArray[262] ?></h2>
          <p class="text-center"><?= $allLabelsArray[706] ?></p>
          <p><a class="btn btn-login btn-lg" href="<?php echo $cms_url ?>" role="button"><?= $allLabelsArray[517] ?></a></p>
        </div>
       </div> <!-- col -->
       <div class="col-md-2"></div>
     </div>  <!-- row -->
   </div> <!-- container -->
</body>

</html>