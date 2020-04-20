<?php
namespace App\CustomStuff;


class image {

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
    /*
    .Wi_700 {width: 700px;}
    .MarLe_Auto {margin-left: auto;}
    .MarRi_Auto {margin-right: auto;}
    .Bo_1pxsolidgrey {border:1px solid grey;}
    .Wi_25Per {width: 25%;}
    .Wi_50Per {width: 50%;}
    .Di_Fl {display: flex;}
    .Wi_100Per {width: 100%;}
    .BoSi_BoBo {box-sizing: border-box;}
    .Fl_Wr {flex-wrap: wrap;} */

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
                <input type="submit" value="Upload Image" name="submit">
              </td>
            </tr>
            <tr>
              <td>
                Create
              </td>
              <td>
                <button type="submit" class="Pa_10px BgCo_White BoRa_10px Ma_10px Di_InBl" name="action[create]" value="">
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
            <!-- <button type="submit" name="images[<?php echo $key ?>][delete]"></button> -->
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

  public static function create($Request_FILES, $Request_POST, $parent_id){

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($Request_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($Request_POST["submit"])) {
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





  }

  public static function destroy($id){

  }



}
