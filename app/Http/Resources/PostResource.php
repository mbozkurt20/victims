<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //if no resize image
        try {
            $resized_image = $this->getMedia('*')[0]->getUrl('resized-image');
        } catch (Exception $e) {
            $resized_image="";
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'age' => $this->age,
            'order' => $this->order,
            'order_date' => $this->order_date,
            'amount' => $this->amount,
            'status' => $this->status,
            'kg' => $this->kg,
            'share_holders_json' => json_decode($this->share_holders_json),
            'number_of_shares' => $this->number_of_shares,
            'categories' => $this->categories,
            'content' => $this->content,
            'original_image' => count($this->getMedia('*')) > 0 ? $this->getMedia('*')[0]->getUrl() : null,
            'resized_image' => $resized_image,
            'created_at' => date('d/m/Y H:i', strtotime($this->created_at))
        ];
    }
}
