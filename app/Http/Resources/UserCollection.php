<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Disable wrapping the result in {data:{}} object
        self::$wrap = null;

        // Add counter to the end result alongside with the user list
        return [
            'count' => $this->collection->count(),
            'users' => $this->collection,
        ];
    }
}
