<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $service;
    public function __construct(InvoiceService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $result = ['status' => 200];
        try {
            $invoices = $this->service->getAllPaginated(['seller', 'customer', 'products'], $request);
            $result['data']['invoices'] = InvoiceResource::collection($invoices);
            $result['meta'] = [
                'total' => $invoices->total(),
                'currentPage' => $invoices->currentPage(),
                'lastPage' => $invoices->lastPage(),
            ];

        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(InvoiceRequest $request)
    {
        try {
            $validated = $request->validated();
            $result = [
                'status' => 201,
                'invoice' => $this->service->saveInvoice($validated)
            ];
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $result = ['status' => 200];
        try {
            $result['data']['invoice'] = new InvoiceResource($this->service->getOne($id));
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(InvoiceRequest $request, int $id)
    {

        try {
            $validated = $request->validated();
            $result = [
                'status' => 200,
                'data' => [
                   'invoice' => $this->service->updateInvoice($validated, $id)
                ],

            ];
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $result = ['status' => 200];
            $this->service->deleteInvoice($id);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }
}
