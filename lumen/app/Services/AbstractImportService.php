<?php

namespace App\Services;

use App\Services\ImportNormaliserInterface;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractImportService
{
	private $normaliser;
	private $entityManager;

	public function __construct(
		ImportNormaliserInterface $normaliser,
		EntityManagerInterface $entityManager
	) {
		$this->normaliser = $normaliser;
		$this->entityManager = $entityManager;
	}

	abstract public function processImport(array $data, $entity);
}