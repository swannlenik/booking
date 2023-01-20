<?php

namespace App\Services;

use App\Models\Place;
use Illuminate\Support\Collection;

class PlaceService
{
    public function getPlaces(): Collection {
        return Place::all()->keyBy('id');
    }

    public function addPlace(array $data): Place {
        $place = new Place();
        $place->name = $data['name'];
        $place->address = $data['address'];
        $place->city = $data['city'];
        $place->zipcode = $data['zipcode'];
        $place->province = $data['province'];
        $place->country = $data['country'];
        $place->save();

        return $place;
    }

    public function deletePlace(int $id): void {
        $place = Place::find($id);
        $place->delete();
    }
}
