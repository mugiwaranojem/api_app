<?php
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\ApiService;
use App\Services\CustomerImportService;
use App\Services\CustomerNormaliser;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CustomerRepository;
use App\Entities\Customer;

class CustomerImportServiceTest extends TestCase
{
	/**
	* @testdox Test import 5 records 
	*/
	public function testImport()
	{
		$apiResponse = $this->getApiResponseMock();
		$apiService = $this->getApiServiceMock();
		$apiService->expects($this->once())
			->method('fetchData')
			->willreturn(json_decode($apiResponse, true));

		$customerRepository = $this->getCustomerRepositoryMock();
		$customerRepository->method('findByEmail')
			->willReturn(null);

		$entityManager = $this->getEntityManagerMock();
		$entityManager->expects($this->exactly(5))
			->method('persist');
		$entityManager->expects($this->exactly(5))
			->method('flush');


		$importService = $this->getImportServiceMock([
			'apiService' => $apiService,
			'customerRepository' => $customerRepository,
			'entityManager' => $entityManager
		]);

		$importService->process();
	}

	/**
	* @testdox Test import and update record for existing data
	*/
	public function testImportUpdateRecord()
	{
		$apiResponse = $this->getApiResponseMock();
		$apiService = $this->getApiServiceMock();
		$apiService->expects($this->once())
			->method('fetchData')
			->willreturn(json_decode($apiResponse, true));

		$normaliser = $this->getNormaliser();
		$dataResponse = json_decode($apiResponse, true)['results'];

		$existingData1 = $normaliser->normalise($dataResponse[0]);
		$existingData1->setId(11);

		$existingData2 = $normaliser->normalise($dataResponse[1]);
		$existingData2->setId(22);

		// Mock two existing data
		$emailMap = [
            [$dataResponse[0]['email'], $existingData1],
            [$dataResponse[1]['email'], $existingData2],
            [$dataResponse[2]['email'], null],
            [$dataResponse[3]['email'], null],
            [$dataResponse[4]['email'], null]
        ];

		$customerRepository = $this->getCustomerRepositoryMock();
		$customerRepository->method('findByEmail')
			->will($this->returnValueMap($emailMap));

		$entityManager = $this->getEntityManagerMock();
		$entityManager->expects($this->exactly(2))
			->method('getReference')
			->will($this->returnValueMap([
				[Customer::class, 11, $existingData1],
				[Customer::class, 22, $existingData2]
			]));
		$entityManager->expects($this->exactly(3))
			->method('persist');
		$entityManager->expects($this->exactly(5))
			->method('flush');


		$importService = $this->getImportServiceMock([
			'apiService' => $apiService,
			'customerRepository' => $customerRepository,
			'entityManager' => $entityManager
		]);

		$importService->process();
	}

	private function getImportServiceMock($defaults = [])
	{
		$normaliser = array_key_exists('normaliser', $defaults) ?
			$defaults['normaliser'] : $this->getNormaliser();

		$entityManager = array_key_exists('entityManager', $defaults) ?
			$defaults['entityManager'] : $this->getEntityManagerMock();

		$customerRepository = array_key_exists('customerRepository', $defaults) ?
			$defaults['customerRepository'] : $this->getCustomerRepositoryMock();

		$apiService = array_key_exists('apiService', $defaults) ?
			$defaults['apiService'] : $this->getApiServiceMock();

		return new CustomerImportService(
			$normaliser,
			$entityManager,
			$customerRepository,
			$apiService
		);

	}

	private function getNormaliser()
	{
		return new CustomerNormaliser();
	}

	private function getEntityManagerMock()
	{
		return $this->getMockBuilder(EntityManagerInterface::class)
			->setMethods(get_class_methods(EntityManagerInterface::class))
			->disableOriginalConstructor()
			->getMock();
	}

	private function getCustomerRepositoryMock()
	{
		return $this->getMockBuilder(CustomerRepository::class)
			->setMethods([])
			->disableOriginalConstructor()
			->getMock();
	}

	private function getApiServiceMock()
	{
		return $this->getMockBuilder(ApiService::class)
			->setMethods(['fetchData'])
			->disableOriginalConstructor()
			->getMock();
	}

	private function getApiResponseMock($resultCount = 5)
	{
		$faker = Faker\Factory::create();
		$gender = ['Male', 'Female'];

		$results = [];
		for ($i=0; $i < $resultCount; $i++) { 
			$results[] = [
				'gender' => $gender[rand(0, 1)],
				'name' => [
					'first' => $faker->firstName(),
					'last' => $faker->lastName()
				],
				'email' => $faker->email,
				'login' => [
					'username' => $faker->userName,
					'password' => $faker->password
				],
				'location' => [
					'city' => $faker->city,
					'country' => $faker->country
				],
				'phone' => $faker->phoneNumber
			];
		}

		return json_encode([
			'results' => $results
		]);
	}
}