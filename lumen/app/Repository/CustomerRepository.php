<?php

namespace App\Repository;

use App\Http\Resources\CustomerResource;
use App\Entities\Customer;
use Doctrine\ORM\EntityManagerInterface;

class CustomerRepository
{
	private $entityManager;

	public function __construct(
		EntityManagerInterface $entityManager
	) {
		$this->entityManager = $entityManager;
	}

	/**
	* @return Array collection App\Entities\Customer
	*/
	public function findAll()
	{
		$customerRepository = $this->entityManager->getRepository(Customer::class);
		$allRecords = CustomerResource::collection($customerRepository->findAll());
		if (empty($allRecords)) {
			return [];
		}
		return $allRecords;
	}

	/**
	* @param $id
	* @return App\Entities\Customer
	*/
	public function find($id)
	{
		$customer = $this->entityManager->find(Customer::class, $id);
		if (empty($customer)) {
			return [];
		}

		return  CustomerResource::collection([$customer])[0];
	}

	/**
	* @param string $email
	* @return App\Entities\Customer|null
	*/
	public function findByEmail($email)
	{
		$q = $this->entityManager->createQueryBuilder('c')
			->select('c')
			->from(Customer::class, 'c')
			->where('c.email = :email')
			->setParameter('email', $email)
			->getQuery();
		return $q->getOneOrNullResult();
	}
}
