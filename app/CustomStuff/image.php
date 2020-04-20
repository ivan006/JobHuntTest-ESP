<?php
namespace App\CustomStuff;


class image {

  public static function edit($images,$parent_id,$edit_url,$create_url,$update_url,$destroy_url){


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
    <form action="" method="post" enctype="multipart/form-data">

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
                Name
              </td>
              <td>
                <input class="Pa_10px BgCo_White BoRa_10px Ma_10px Di_InBl" type="text" name="" value="">
              </td>
            </tr>
            <tr>
              <td>
                Create
              </td>
              <td>
                <a class="Pa_10px BgCo_White BoRa_10px Ma_10px Di_InBl" href="<?php echo $destroy_url ?>?action=delete&parentid=">
                  Create
                </a>
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
                  <a class="Pa_10px BgCo_White BoRa_10px Ma_10px Di_InBl" href="<?php echo $destroy_url ?>?action=delete&id=<?php echo $value["id"] ?> ">
                    Delete
                  </a>
                </td>
              </tr>
              <tr>
                <td>
                  Name
                </td>
                <td>
                  <input class="Pa_10px BgCo_White BoRa_10px Ma_10px Di_InBl" type="text" name="" value="<?php echo $value["name"] ?>">
                </td>
              </tr>
              <tr>
                <td>
                  Update
                </td>
                <td>
                  <a class="Pa_10px BgCo_White BoRa_10px Ma_10px Di_InBl" href="<?php echo $destroy_url ?>?action=delete&id=<?php echo $value["id"] ?> ">
                    Update
                  </a>
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

  public static function update($id){

  }

  public static function create($parent_id){

  }

  public static function destroy($id){

  }



}
