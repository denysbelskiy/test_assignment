<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    private $pagination;

    public function __construct($resource)
    {
        $this->pagination = [
            'current_page' => $resource->currentPage(),
            'from' => $resource->firstItem(),
            'last_page' => $resource->lastPage(),
            'per_page' => $resource->perPage(),
            'to' => $resource->lastItem(),
            'total_users' => $resource->total(),
            'links' => [
                    'next_url' => $resource->nextPageUrl(),
                    'previous_url' => $resource->previousPageUrl(),
                ],

        ];
        
        $resource = $resource->getCollection();

        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'success' => true,
            'page' => $this->pagination['current_page'],
            'total_pages' => $this->pagination['last_page'],
            'total_users' => $this->pagination['total_users'],
            'count' => $this->pagination['per_page'],
            'links' => $this->pagination['links'],
            'users' => $this->collection,
        ];

        return $data;
    }
}
