<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
  protected $fillable = [
    'parent_id',
    'parent_type',
    'url',
  ];
  public function parent() {
    return $this->morphTo();
  }


  /**
  * this assist the create method as it deals with the upload logic
  * @param  Array  $Request_FILES This contains the file into sent from the file uploader input "_FILE"
  * @param  Array  $Request_POST  This contains the post info sent from the post request
  * @return String                It returns the location of the file that was uploaded
  */
  public static function create_helper__upload_to_server($Request_FILES, $Request_POST){
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
}
