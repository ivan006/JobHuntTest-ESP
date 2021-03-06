<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomStuff\image;
use App\image as imagemodel;

class product_c extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
      $id = 1;
      $images = array(
        array(
          "id"=>"1",
          "name"=>"Image 1",
          "url"=>"http://localhost/localhost/JobHuntTest-ESP/public/images/Desert.jpg ",
        ),
        array(
          "id"=>"2",
          "name"=>"Image 2",
          "url"=>"http://localhost/localhost/JobHuntTest-ESP/public/images/Chrysanthemum.jpg",
        ),
      );


     // Desert.jpg
     // Hydrangeas.jpg
     // Jellyfish.jpg
     // Koala.jpg
     // Lighthouse.jpg
     // Penguins.jpg
     // Tulips.jpg
     //

     $parent_id = $id;
     $update_url = "/localhost/JobHuntTest-ESP/public/update";


     return view('product', compact("images","id","update_url"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $id = 1;
      // dd($_POST);
      if (isset($_POST["action"]["create"])) {

        $Request_FILES = $_FILES;
        $Request_POST = $_POST;
        $parent_id = $id;
        $crop_preset = "resize_maxwidth_300";

        $image_url = imagemodel::create_helper__upload_to_server($Request_FILES, $Request_POST);

        $image_object = new image;
        if ($crop_preset == "crop_square_and_resize_maxwidth_250") {
          $image_object->crop_square($image_url);
          $image_object->resize_by_max($image_url,"250","height");
        } elseif ($crop_preset == "resize_maxwidth_300") {
          $image_object->resize_by_max($image_url,"300","height");
        }

      } elseif (isset($_POST["action"]["delete"])) {
        $image_id = $_POST["action"]["delete"];
        image::destroy($image_id);
      }

      return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
