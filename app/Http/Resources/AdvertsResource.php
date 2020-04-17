<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertsResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $advert['title']  = $this->title;
        $advert['price']  = $this->price;
        $advert['photo']  = $this->photos->pluck('url')[0];

        return $advert;
    }
}
