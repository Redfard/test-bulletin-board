<?php

namespace App\Services;

use App\Advert;
use App\Photo;
use DB;

class AdvertService
{

    /**
     * @param $data array
     * @return boolean
     */
    public function addAdvert($data)
    {
        $advert = new Advert();

        DB::transaction(function() use ($data, $advert) {
            $advert->title       = $data['title'];
            $advert->description = $data['description'];
            $advert->price       = $data['price'];
            $advert->save();

            foreach ($data['photos'] as $index => $url) {
                $photo            = new Photo();
                $photo->advert_id = $advert->id;
                $photo->url       = $url;

                if ($index === 0) {
                    $photo->is_main = 1;
                }

                $photo->save();
            }
        });

        return $advert->id;
    }

    /**
     * @param int | string $id
     * @param boolean $getDescription
     * @param boolean $getAllPhoto
     * @return \App\Advert
     */
    public function getAdvert($id, $getDescription, $getAllPhoto)
    {
        $query = Advert::where('id', $id)->select('id', 'title', 'price');

        if ($getDescription) {
            $query->addSelect('description');
        }

        if ($getAllPhoto) {
            $query->with(['photos' => function($query) {
                $query->orderBy('is_main', 'desc');
            }]);
        } else {
            $query->with(['photos' => function($query) {
                $query->where('is_main', 1);
            }]);
        }

        $advert = $query->firstOrFail();

        return $advert;
    }

    /**
     * @param string $dirtySort
     * @param string $sortDirection
     * @return Advert[]
     */
    public function getAdverts($dirtySort, $dirtySortDirection)
    {
        $adverts = Advert::select('id', 'title', 'price');

        $sort = $this->getAdvertsSort($dirtySort);

        if ($sort) {
            $sortDir = $dirtySortDirection == 'desc' ? 'desc' : 'asc';
            $adverts->orderBy($sort, $sortDir);
        }

        $adverts->with(['photos' => function($query) {
            $query->where('is_main', 1);
        }]);

        return $adverts->paginate(10);
    }

    /**
     * @param  string $dirtySort
     * @return string
     */
    protected function getAdvertsSort($dirtySort)
    {
        switch ($dirtySort) {
            case 'price':
                return 'price';

            case 'date':
                return 'created_at';

            default:
                return 'id';
        }
    }
}