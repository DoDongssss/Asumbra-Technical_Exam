<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $Fullname = $this->Firstname + " " + $this->Middle_Initial + " " + $this->Lastname;

        return [
            'id' => $this->id,
            'Fullname' => $this->getFullName(),
            'Firstname' => $this->Firstname,
            'Lastname' => $this->Lastname,
            'Middle_Initial' => $this->Middle_Initial,
            'Age' => $this->calculateAge($this->Birthday),
            'Birthday' => $this->getFormattedDate($this->Birthday),
            'Gender' => $this->getGenderLabel($this->Gender),
            'Gender_id' => $this->Gender,
            'Date_registered' => $this->getFormattedDate($this->Date_registered)
        ];
    }

    public function getFullName()
    {
        return $this->Firstname . ' ' . $this->Middle_Initial . '. ' . $this->Lastname;
    }

    private function getGenderLabel($genderValue)
    {
        switch ($genderValue) {
            case 1:
                return 'Male';
            case 2:
                return 'Female';
            default:
                return 'Others';
        }
    }

    private function calculateAge($birthdate)
    {
        return Carbon::parse($birthdate)->age;
    }

    private function getFormattedDate($date)
    {
        return Carbon::parse($date)->format('M jS, Y');
    }
}
