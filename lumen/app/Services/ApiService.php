<?php

namespace App\Services;

class ApiService
{
	public function fetchData(string $dataProvider)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $dataProvider);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$request = curl_exec($curl);
		curl_close($curl);

		return json_decode($request, true);
	}
}