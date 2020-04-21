<?php
namespace App\CustomStuff;


class image {

  /**
   * this crops any image into a square
   * @param  String $image_url this is the location of the image to crop
   * @return void            nothing is returned
   */
  public function crop_square($image_url){

    $im = $this->imagecreatefromany($image_url);
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
  public function imagecreatefromany($image_url){
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
   * @param  int $max  this specifies the max width to resize by
   * @param  String $axis      takes either "width" or "height"
    * @return void            returns nothing
   */

   /**
    */
  public function resize_by_max($image_url,$max,$axis){

    $x = getimagesize($image_url);
    $width  = $x['0'];
    $height = $x['1'];

    $axis_1 = "";
    $axis_2 = "";
    if ($axis == "width") {
      $axis_1 = $width;
      $axis_2 = $height;
    } elseif ($axis == "height") {
      $axis_1 = $height;
      $axis_2 = $width;
    }

    if ($axis_1 > $max) {
      $rs_axis_1 = $max;
      $percent = $rs_axis_1/$axis_1;
      $rs_axis_2 = $axis_2 * $percent;
    } else {
      $rs_axis_1 = $axis_1;
      $rs_axis_2 = $axis_2;
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

    $img_base = imagecreatetruecolor($rs_axis_1, $rs_axis_2);
    imagecopyresized($img_base, $img, 0, 0, 0, 0, $rs_axis_1, $rs_axis_2, $width, $height);

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
  public function upload_to_amazon($image_url){

  }
}
