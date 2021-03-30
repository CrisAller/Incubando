<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CompanyController extends Controller
{
    public function show()
    {
        return view('companies.show')->with([
            'company' => auth()->user()->company
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required'],
            'address' => [],
            'city' => [],
            'cif' => [],
            'logo' => [],
        ];
        $request->validate($rules);
        $url_logo = $request->logo->store('public');
        $company = Company::create($request->all());
        $company->logo = $url_logo;
        $company->save();


        return redirect()->route('companies.show')->with([
            'company' => auth()->user()->company
        ]);
    }

    public function edit()
    {
        return view('companies.edit')->with([
            'company' => auth()->user()->company
        ]);
    }

    public function update(UpdateCompanyRequest $request)
    {
        /*$fields = $request->fields;
        ddd($fields);*/
        $fields = $request->validated();
        $company = new Company();
        $company = auth()->user()->company;
        
        if(isset($request->logo)){
            $fields['logo'] = $request->logo->store('public');
            Storage::delete($company->logo);
        }
        $company->update($fields);
        
        return redirect()->route('companies.show')->with([
            'company' => $company->fresh()
        ]);;
    }
}
