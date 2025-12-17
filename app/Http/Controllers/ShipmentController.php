<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Shipment;
use App\Models\StatusLog;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {

        $shipments = Shipment::latest()->get();
        return view('shipments.index', compact('shipments'));
    }

    public function detail($id)
    {
        $shipment = Shipment::with('statusLogs')->findOrFail($id);
        return view('shipments.detail', compact('shipment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|unique:shipments',
            'sender_name' => 'required',
            'sender_address' => 'required',
            'receiver_name' => 'required',
            'receiver_address' => 'required',
            'status' => 'required',
        ]);

        $shipment = Shipment::create($request->all());

        StatusLog::create([
            'shipment_id' => $shipment->id,
            'status' => $shipment->status,
            'location' => $shipment->receiver_address,
        ]);

        return redirect()->back()->with('success', 'Shipment added successfully');
    }

    public function updateStatus(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'status' => 'required|in:Pending,In Transit,Delivered',
        ]);
        $shipment = Shipment::findOrFail($request->id);
        $shipment->update([
            'status' => $request->status,
        ]);

        StatusLog::create([
            'shipment_id' => $shipment->id,
            'status' => $request->status,
            'location' => $shipment->receiver_address,
        ]);

        return redirect()->back()->with('success', 'Shipment status updated successfully.');
    }
}
