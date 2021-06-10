<?php
namespace App\Services;

use App\Entities\Customer;

class CustomerNormaliser implements NormaliserInterface
{
	public function normalise($data)
	{
		$customer = new Customer;

		if (isset($data['name'])) {
			$customer->setFullName(sprintf(
				'%s %s',
				$data['name']['first'],
				$data['name']['last']
			));
		}

		if (isset($data['email'])) {
			$customer->setEmail($data['email']);
		}

		if (isset($data['login'])) {
			$customer->setUsername($data['login']['username']);
			$customer->setPassword(md5($data['login']['password']));
		}

		if (isset($data['gender'])) {
			$customer->setGender($data['gender']);
		}

		if (isset($data['location'])) {
			$customer->setCountry($data['location']['country']);
			$customer->setCity($data['location']['city']);
		}

		if (isset($data['phone'])) {
			$customer->setPhone($data['phone']);
		}

		return $customer;
	}
}