<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CustomerRepository;
use App\Entities\Customer;

class CustomerImportService
{
	private $normaliser;
	private $entityManager;
	private $customerRepository;
	private $apiService;

	public function __construct(
		CustomerNormaliser $normaliser,
		EntityManagerInterface $entityManager,
		CustomerRepository $customerRepository,
		ApiService $apiService
	) {
		$this->normaliser = $normaliser;
		$this->entityManager = $entityManager;
		$this->customerRepository = $customerRepository;
		$this->apiService = $apiService;
	}

	/**
     * Create a new command instance.
     *
     * @return int
     */
	public function process($params = null)
	{
		$fetchParams = sprintf('?%s', $params ? $params : env('CUSTOMER_API_URL_PARAMS'));

		$data = $this->apiService->fetchData(env('CUSTOMER_API_URL') . $fetchParams);
		
		if (!array_key_exists('results', $data)) {
			print('No data to process');
			return;
		}

		foreach ($data['results'] as $result) {
			$customer = $this->normaliser->normalise($result);
			$record = $this->customerRepository->findByEmail($customer->getEmail());

			// update record if exist else presist
			if ($record) {
				$dataRef = $this->entityManager->getReference(Customer::class, $record->getId());
				$dataRef->setFullName($customer->getFullName());
				$dataRef->setUsername($customer->getUsername());
				$dataRef->setGender($customer->getGender());
				$dataRef->setCountry($customer->getCountry());
				$dataRef->setCity($customer->getCity());
				$dataRef->setPhone($customer->getPhone());
			} else {
				$this->entityManager->persist($customer);
			}

			$this->entityManager->flush();
		}
		
	}
}