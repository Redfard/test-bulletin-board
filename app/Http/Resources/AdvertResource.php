<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertResource extends JsonResource
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

        if ($this->description) {
            $advert['description'] = $this->description;
        }

        if (in_array('all_photos', $request->fields ?? [])) {
            $advert['photos'] = $this->photos->pluck('url');
        } else {
            $advert['photo'] = $this->photos->pluck('url')[0];
        }

        return $advert;
    }
}
