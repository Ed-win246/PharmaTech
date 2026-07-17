<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PharmacyController extends Controller
{
    //
    public function dashboard(){
        return Inertia::render('Dashboard',[
            'pharmacyCount'=>Pharmacy::count(),
            'activeCount'=>Pharmacy::where('status','active')->count(),
            'pharmacies'=>Pharmacy::latest()->get(),
        ]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'license_number'=>'required|string|max:255|unique:pharmacies,license_number',
            'address'=>'required|string|max:255',
            'owner_name'=>'required|string|max:255',
            'owner_email'=>'required|email|max:255|unique:pharmacies,owner_email',
            'owner_phone'=>'required|string|max:20|unique:pharmacies,owner_phone',
            'status'=>'required|in:active,inactive',
            'billing_cycle'=>'required|in:monthly,yearly',
            // 'subscription_fee'=>'required|numeric|min:0',
            'billing_date'=>'required|date',
        ]);
        $validated['billing_date']=now()->toDateString();
        $validated['next_billing_date']=$validated['billing_cycle']==='monthly'
        ?now()->addMonth()->toDateString()
        :now()->addYear()->toDateString();
        $validated['billing_status']='active';

        $pharmacy=Pharmacy::create($validated);
        return redirect()->back()->with('success','Pharmacy created successfully');
    }
    public function update(Request $request, Pharmacy $pharmacy){
        $validated = $request->validate([
            'name'=>'required|string|max:255',
            'license_number'=>'required|string|max:255|unique:pharmacies,license_number,'.$pharmacy->id,
            'address'=>'required|string|max:255',
            'owner_name'=>'required|string|max:255',
            'owner_email'=>'required|email|max:255|unique:pharmacies,owner_email,'.$pharmacy->id,
            'owner_phone'=>'required|string|max:20|unique:pharmacies,owner_phone,'.$pharmacy->id,
            'status'=>'required|in:active,inactive',
            'billing_cycle'=>'required|in:monthly,yearly',
            // 'subscription_fee'=>'required|numeric|min:0',
            'billing_date'=>'required|date',
        ]);

        $pharmacy->update($validated);
        return redirect()->back()->with('success','Pharmacy updated successfully');
    }

    public function destroy(Pharmacy $pharmacy){
        $pharmacy->destroy();
        return redirect()->back()->with('success','Pharmacy deleted successfully');
    }
}
