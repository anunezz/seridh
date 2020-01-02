<?php

namespace App\Http\Resources\Catalogs;

use Illuminate\Http\Resources\Json\JsonResource;

class AttentionClassificationCollection extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'level_attentions_id'   => $this->level_attentions_id,
            'name'                  => $this->name,
            'isActive'              => $this->isActive,
            'created_at'            => $this->created_at,
            'updated_at'            => $this->updated_at,
        ];
    }
}
