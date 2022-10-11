<?php

namespace Modules\HR\Services;

use Modules\HR\Http\Requests\Recruitment\JobDesignationRequest;
use Illuminate\Support\Str;
use Modules\HR\Entities\HrJobDesignation;
use Modules\HR\Entities\HrJobDomain;
use Illuminate\Support\Facades\DB;

class HrJobDesignationService
{
    public function index()
    {
        $designations = HrJobDesignation::all();
        $domains = HrJobDomain::all();

        return [
            'designations' => $designations,
            'domains' => $domains,
        ];
    }

    public function storeDesignation(JobDesignationRequest $request)
    {
        $validatedData = request()->validate([
            'domain'=>'required',
            'name' => 'required'
        ]
        );
        if($request['domain']=='Select Domain'){
        }
        else{
    $domain_id = DB::table('hr_job_domains')->select('id')->where('domain', $request['domain'])->first();
    $jobDesignation = new HrJobDesignation();
    $jobDesignation->designation = $request['name'];
    $jobDesignation->slug = Str::slug($request['name']);
    $jobDesignation->domain_id = $domain_id->id;
    $jobDesignation->save();
}
    }

    public function edit(JobDesignationRequest $request, $id)
    {
        $validatedData = request()->validate([
            'domain'=>'required',
            'name'=>'required'
        ]
        );
        dd($request->all());
        $domain_id = DB::table('hr_job_domains')->select('id')->where('domain', $request['domain'])->first();
        $hrJobDesignation = HrJobDesignation::find($id);
        $hrJobDesignation->designation = $request['name'];
        $hrJobDesignation->slug = Str::slug($request['name']);
        $hrJobDesignation->domain_id = $domain_id->id;
        $hrJobDesignation->save();
    }

    public function destroy(HrJobDesignation $request, $id)
    {
        $hrJobDesignation = $request->find($id);
        $hrJobDesignation->delete();
    }
}
