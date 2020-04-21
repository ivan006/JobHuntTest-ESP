<?php
namespace App\CustomStuff;


class image {

  /**
   * use this in your entity edit page to render the image uploader tool
   * @param  Array $images     an image array that you would get from your image table
   * @param  int $parent_id  the id of the parent entity that owns this image
   * @param  String $update_url the url in you app that updates the parent entity
   * @param  String $csrf_token the token used to secure your post request
   * @return String             this is the html form thats generated
   */
  public static function edit($images,$parent_id,$update_url,$csrf_token){


    ob_start();

    ?>
    <style media="screen">
    .BoRa_10px {border-radius: 5px;}
    .BgCo_White {background-color: white;}
    .Pa_10px {padding: 10px;}
    .BgCo_Grey {background-color: rgb(200,200,200);}
    .Ma_10px {margin: 10px;}
    .Di_InBl {display:inline-block;}


    </style>
    <form action="<?php echo $update_url ?>" method="post" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="<?php echo $csrf_token ?>">
      <h1>Create</h1>
      <div class="BgCo_White  BgCo_Grey Ma_10px BoRa_10px Di_InBl">

        <div class="">
          <table class="Ma_10px">
            <tr>
              <td>
                Image
              </td>
              <td>
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload">
              </td>
            </tr>
            <tr>
              <td>
                Create
              </td>
              <td>


                <button type="submit" class="Pa_10px BgCo_White BoRa_10px Ma_10px Di_InBl" name="action[create]" value="Upload Image" >
                  Create
                </button>

              </td>
            </tr>
          </table>
        </div>

      </div>

      <h1>Edit</h1>
      <?php foreach ($images as $key => $value): ?>

        <br>
        <div class="BgCo_White  BgCo_Grey Ma_10px BoRa_10px Di_InBl">

          <div class="">

            <table class="Ma_10px">
              <tr>
                <td>
                  Image
                </td>
                <td>
                  <img src="<?php echo $value["url"] ?>" alt="" style="width: 200px;" class="BoRa_10px Ma_10px">
                </td>
              </tr>
              <tr>
                <td>
                  Delete
                </td>
                <td>
                  <button type="submit" class="Pa_10px BgCo_White BoRa_10px Ma_10px Di_InBl" name="action[delete]" value="<?php echo $value["id"] ?>">
                    Delete
                  </button>

                </td>
              </tr>
            </table>
          </div>

        </div>
      <?php endforeach; ?>
    </form>
    <?php

    $result = ob_get_contents();

    ob_end_clean();

    return $result;
  }

  /**
   * this goes in the update controller method for the images parent entity
   * @param  Array  $Request_FILES This contains the file into sent from the file uploader input "_FILE"
   * @param  Array  $Request_POST  This contains the post info sent from the post request
   * @param  int $parent_id     this is the id of the parent entity that owns the image
   * @param  String $crop_preset   This contains either "crop_square_and_resize_maxwidth_250" or "resize_maxwidth_300" which are the 2 crop presets
   * @return void                nothing is returned
   */
  public static function create($Request_FILES, $Request_POST, $parent_id, $crop_preset){
    $image_url = self::create_helper__upload_to_server($Request_FILES, $Request_POST);

    if ($crop_preset == "crop_square_and_resize_maxwidth_250") {
      self::crop_square($image_url);
      self::resize_maxwidth($image_url,"250");
    } elseif ($crop_preset == "resize_maxwidth_300") {
      self::resize_maxwidth($image_url,"300");
    }
  }

  /**
   * this assist the create method as it deals with the upload logic
   * @param  Array  $Request_FILES This contains the file into sent from the file uploader input "_FILE"
   * @param  Array  $Request_POST  This contains the post info sent from the post request
   * @return String                It returns the location of the file that was uploaded
   */
  private static function create_helper__upload_to_server($Request_FILES, $Request_POST){
    $target_dir = "images/";
    $target_file = $target_dir . basename($Request_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($Request_POST["action"]["create"])) {
      $check = getimagesize($Request_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }
    // Check file size
    if ($Request_FILES["fileToUpload"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($Request_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $Request_FILES["fileToUpload"]["name"]). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
    return $target_file;
  }

  /**
   * this deletes the specified image
   * @param  int $id this specifies the images to delete
   * @return void     nothing returned
   */
  public static function destroy($id){

  }

  /**
   * this crops any image into a square
   * @param  String $image_url this is the location of the image to crop
   * @return void            nothing is returned
   */
  public static function crop_square($image_url){
    $im = self::imagecreatefromany($image_url);
    $size = min(imagesx($im), imagesy($im));
    $im2 = imagecrop($im, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);
    if ($im2 !== FALSE) {
      imagepng($im2, $image_url);
      imagedestroy($im2);
    }
    imagedestroy($im);
  }

  /**
   * this imppliments the appropriate "imagecreatefrom" function depending on the input extention
   * @param  String $image_url this is the location of tthe image to crop
   * @return resource             this returns the appropriate image resource
   */
  public static function imagecreatefromany($image_url){
    if (!file_exists($image_url)) {
      throw new InvalidArgumentException('File "'.$image_url.'" not found.');
    }


    switch ( strtolower( pathinfo( $image_url, PATHINFO_EXTENSION ))) {
      case 'jpeg':
      case 'jpg':
      return imagecreatefromjpeg($image_url);
      break;

      case 'png':
      return imagecreatefrompng($image_url);
      break;

      case 'gif':
      return imagecreatefromgif($image_url);
      break;

      default:
      throw new InvalidArgumentException('File "'.$image_url.'" is not valid jpg, png or gif image.');
      break;
    }

  }

  /**
   * this resizes any image according to the the specified max width
   * @param  String $image_url this is the location of the image to resize
   * @param  int $maxwidth  this specifies the max width to resize by
   * @return void            returns nothing
   */
  public static function resize_maxwidth($image_url,$maxwidth){




    $x = getimagesize($image_url);
    $width  = $x['0'];
    $height = $x['1'];


    if ($width > $maxwidth) {
      $rs_width = $maxwidth;
      $percent = $rs_width/$width;
      $rs_height = $height * $percent;
    } else {
      $rs_width = $width;
      $rs_height = $height;
    }

    switch ($x['mime']) {
      case "image/gif":
      $img = imagecreatefromgif($image_url);
      break;
      case "image/jpg":
      case "image/jpeg":
      $img = imagecreatefromjpeg($image_url);
      break;
      case "image/png":
      $img = imagecreatefrompng($image_url);
      break;
    }

    $img_base = imagecreatetruecolor($rs_width, $rs_height);
    imagecopyresized($img_base, $img, 0, 0, 0, 0, $rs_width, $rs_height, $width, $height);

    $image_url_info = pathinfo($image_url);
    switch ($image_url_info['extension']) {
      case "gif":
      imagegif($img_base, $image_url);
      break;
      case "jpg":
      case "jpeg":
      imagejpeg($img_base, $image_url);
      break;
      case "png":
      imagepng($img_base, $image_url);
      break;
    }
  }

 /**
  * this uploads the image to amazon
  * @param  String $image_url this is the location of the image to resize
  * @return String            returns success message
  */
  public static function upload_to_amazon($image_url){

  }
}
