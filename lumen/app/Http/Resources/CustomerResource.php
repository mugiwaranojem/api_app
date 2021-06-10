<?php

namespace App\Http\Resources;

use App\Entities\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
	/**
	 * Transform the resource collection into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		$requestRoute = $request->route();
		if (array_key_exists('as', $requestRoute[1])
			&& $requestRoute[1]['as'] === 'customer_detail'
		) {
			return [
				'full_name' => $this->getFullName(),
				'country' => $this->getCountry(),
				'email' => $this->getEmail(),
				'username' => $this->getUsername(),
				'gender' => $this->getGender(),
				'country' => $this->getCountry(),
				'city' => $this->getCity(),
				'phone' => $this->getPhone()
			];

		}
		return [
			'full_name' => $this->getFullName(),
			'country' => $this->getCountry(),
		];
	}
}