<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Excercise extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'exercise' => $this->exercise,    
            'repetitions' => $this->repetitions,    
            'weight' => $this->weight         
        ];
    }
}
