<?php
require_once 'global.php';
//$s=mysqli_query($conn,"update category_blog set title_punjabi='ਕਮਿਊਨਟੀ ਰੇਸੂਰਸਸ' where id=12");
if($s)
{
    echo 'yes';
}
else
{
    print_r(mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CKEditor 5 – Classic editor</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
</head>
<body>
    <h1>Classic editor</h1>
    <!-- <div id="editor">
        <p>This is some sample content.</p>
    </div> -->
    <textarea id="editor">
        testing textarea!
    </textarea>
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
</body>
</html>