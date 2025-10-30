<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\v1\StoreCustomerRequest;
use App\Http\Requests\v1\UpdateCustomerRequest;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\CustomerResource;
use App\Http\Resources\v1\CustomerCollection;
use App\Filters\v1\CustomersFilter;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CustomersFilter();
        $filterItems = $filter->transform($request); //['column','operator','value']
        $includeInvoices = $request->query('includeInvoices');

        $customers = Customer::where($filterItems);
        if ($includeInvoices) {
            $customers = $customers->with('invoices');
        }

        return new CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        // Get validated data (after prepareForValidation runs)
        $data = $request->validated();

        // At this point, $data includes 'postal_code' (not 'postalCode')
        $customer = Customer::create($data);

        return new CustomerResource($customer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $includeInvoices = request()->query('includeInvoices');

        if ($includeInvoices) {
            return new CustomerResource($customer->loadMissing('invoices'));
        }

        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
