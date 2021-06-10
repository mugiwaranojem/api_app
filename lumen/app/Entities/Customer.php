<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="customers")
*/
class Customer
{
	/**
	* @ORM\Id
	* @ORM\GeneratedValue
	* @ORM\Column(type="integer")
	*/
	private $id;

	/**
	* @ORM\Column(type="string")
	*/
	private $fullName;

	/**
	* @ORM\Column(type="string")
	*/
	private $email;

	/**
	* @ORM\Column(type="string")
	*/
	private $username;

	/**
	* @ORM\Column(type="string")
	*/
	private $password;

	/**
	* @ORM\Column(type="string")
	*/
	private $gender;

	/**
	* @ORM\Column(type="string")
	*/
	private $country;

	/**
	* @ORM\Column(type="string")
	*/
	private $city;

	/**
	* @ORM\Column(type="string")
	*/
	private $phone;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getFullName()
	{
		return $this->fullName;
	}

	public function setFullName($fullName)
	{
		$this->fullName = $fullName;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function getGender()
	{
		return $this->gender;
	}

	public function setGender($gender)
	{
		$this->gender = $gender;
	}

	public function getCountry()
	{
		return $this->country;
	}

	public function setCountry($country)
	{
		$this->country = $country;
	}

	public function getCity()
	{
		return $this->city;
	}

	public function setCity($city)
	{
		$this->city = $city;
	}

	public function getPhone()
	{
		return $this->phone;
	}

	public function setPhone($phone)
	{
		$this->phone = $phone;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}
}