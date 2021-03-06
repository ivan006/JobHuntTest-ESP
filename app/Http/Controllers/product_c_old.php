<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomStuff\image;

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
    public function edit($id)
    {
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
      $upload_input = image::edit($images,$id,"/localhost/JobHuntTest-ESP/public/a/".$id."/update","3j5yRIVTMvuqXBLWCBgUDxmQiLwqHYgQDoqYQg4i");
      echo $upload_input;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      // dd($_POST);
      if (isset($_POST["action"]["create"])) {
        image::create($_FILES, $_POST, $id, "resize_maxwidth_300");

      } elseif (isset($_POST["action"]["delete"])) {
        $image_id = $_POST["action"]["delete"];
        image::destroy($image_id);
      }

      return redirect('/a/'.$id."/edit");
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
