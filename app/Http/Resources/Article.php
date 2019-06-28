<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);

        // return [
        //     'id' =>$this->id,
        //     'title' => $this->title,
        //     'Body' => $this->body

        // ];
    }

    public function with($request){

            return [

"Author" => [
    "name"=> "Yusif",
    "fb_link" => url("http://facebook.com/moro.yusif"),
    "tw_link" => url("http://twitter.com/yusif"),
    "gh_link" => url("http://github.com/yusifk88")
],
"Verison" => "1.2"

            ];

        }
    
}
