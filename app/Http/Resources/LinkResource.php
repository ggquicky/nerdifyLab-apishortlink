<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//       return parent::toArray($request);

        return [
            'id' => $this->id,
            'url' => $this->url,
            'laravel_url' => 'http://localhost:8000/s/'.$this->laravel_url,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at,
            'all_clicks' => $this->whenLoaded('linkcounters')->count()??null,
        ];
    }
}
