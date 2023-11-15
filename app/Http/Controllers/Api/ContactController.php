<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use App\Http\Resources\CountryResource;
use Modules\Shop\Entities\Country;
use Modules\Shop\Entities\EntityContact;
use Modules\Shop\Entities\Shop;

class ContactController extends Controller
{
    public function central()
    {
        $shop = Shop::where('default', true)
            ->active()
            ->published()
            ->with(['map','contacts'])
            ->first();

        return new ContactResource($shop);
    }

    public function countries()
    {
        $countries = Country::whereShow(true)
            ->active()
            ->published()
            ->withCount('shops')
            ->get();

        return CountryResource::collection($countries);
    }

    public function offices()
    {
        $shops = Shop::active()
            ->published()
            ->where('default', false)
            ->with(['map'])
            ->get();

        return  ContactResource::collection($shops);
    }
}
