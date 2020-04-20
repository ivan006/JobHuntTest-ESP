<?php
namespace App\CustomStuff;


class image {

  edit
  create
  update
  destroy

  public static function edit($images){


    ob_start();

    ?>
    <style media="screen">

    </style>
    <form action="upload.php" method="post" enctype="multipart/form-data">
      Select image to upload:
      <input type="file" name="fileToUpload" id="fileToUpload">
      <input type="submit" value="Upload Image" name="submit">
      <?php foreach ($images as $key => $value): ?>

      <?php endforeach; ?>
    </form>
    <?php

    $result = ob_get_contents();

    ob_end_clean();

    return $result;
  }



}
