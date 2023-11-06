<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscribedResource extends JsonResource
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
            'name' => $this->name,
            'course' => $this->courseQuantity($this->course),
            'bundle' => $this->bundleQuantity($this->bundle),
            'end_at' => $this->end_at,
            'created_at' => $this->created_at,
        ];
    }

    private function courseQuantity($course)
    {
        switch ($course){
            case 0:
                return "Unlimited";
                break;
            case 99:
                return "Not Access";
                break;
            default:
                return $course;
                break;
        }
    }

    /**
     * @return mixed|string
     */
    public function bundleQuantity($bundle)
    {
        switch ($bundle) {
            case 0:
                return "Unlimited";
                break;
            case 99:
                return "Not Access";
                break;
            default:
                return $bundle;
                break;
        }
    }
}
