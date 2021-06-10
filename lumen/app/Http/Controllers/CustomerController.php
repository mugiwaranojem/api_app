<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\CustomerRepository;

class CustomerController extends Controller
{
    private $customerRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
    * Show all customers.
    *
    * @param  int  $customerId
    * @return Response
    */
    public function index()
    {
        return response()->json([
            'data' => $this->customerRepository->findAll()
        ], 200);
    }

    /**
    * Show single customer data.
    *
    * @param  int  $customerId
    * @return Response
    */
    public function show($customerId)
    {
        return response()->json([
            'data' => $this->customerRepository->find($customerId)
        ], 200);
    }

}
