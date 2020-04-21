<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>

        <!-- Fonts -->

        <!-- Styles -->
        <style media="screen">
        .BoRa_10px {border-radius: 5px;}
        .BgCo_White {background-color: white;}
        .Pa_10px {padding: 10px;}
        .BgCo_Grey {background-color: rgb(200,200,200);}
        .Ma_10px {margin: 10px;}
        .Di_InBl {display:inline-block;}


        </style>
    </head>
    <body>
      <form action="<?php echo $update_url ?>" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
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
    </body>
</html>
