<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // DB::table('invoices')
        return view('admin.pages.invoice.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.invoice.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'invoice_no' => 'required|string',
            'schedule_date' => 'required|date',
            'buyer_from' => 'required|string',
            'buyer_address' => 'required|string',
            'buyer_number' => 'required|string',
            'buyer_email' => 'required|email',
            'issuer_from' => 'required|string',
            'issuer_address' => 'required|string',
            'issuer_number' => 'required|string',
            'issuer_email' => 'required|email',
            'products' => 'required|array',
            'products.*.name' => 'required|string',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.total' => 'required|numeric|min:0',
        ]);
        DB::beginTransaction();

        try {
            $invoiceId = DB::table('invoices')->insertGetId([
                'invoice_no' => $validatedData['invoice_no'],
                'schedule_date' => $validatedData['schedule_date'],
                'buyer_from' => $validatedData['buyer_from'],
                'buyer_address' => $validatedData['buyer_address'],
                'buyer_number' => $validatedData['buyer_number'],
                'buyer_email' => $validatedData['buyer_email'],
                'issuer_from' => $validatedData['issuer_from'],
                'issuer_address' => $validatedData['issuer_address'],
                'issuer_number' => $validatedData['issuer_number'],
                'issuer_email' => $validatedData['issuer_email'],
                'date' => date('d-m-Y')
            ]);
            foreach ($validatedData['products'] as $product) {
                DB::table('invoices_data')->insert([
                    'invoice_id' => $invoiceId,
                    'name' => $product['name'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'total' => $product['total'],
                ]);
            }
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Invoice saved successfully!']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Failed to save invoice: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
