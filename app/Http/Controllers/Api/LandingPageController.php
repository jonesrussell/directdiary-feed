<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use Exonet\Powerdns\Powerdns;
use Exonet\Powerdns\RecordType;
use Illuminate\Http\Request;
use RenokiCo\PhpK8s\KubernetesCluster;
use Validator;

class LandingPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $landingPages = LandingPage::all();
        return response()->json(
            [
                "success" => true,
                "message" => "LandingPage List",
                "data" => $landingPages
            ]
        );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'domain' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->_sendError('Validation Error.', $validator->errors());
        }

        $landingPage = LandingPage::create($input);

        // $cluster = KubernetesCluster::fromKubeConfigYamlFile(base_path('.kube/config'), 'do-lon1-k8s-holonet');
        // $deployment = $cluster->fromYamlFile(resource_path('kubernetes/deployment.yml'))->create();
        
        // Initialize the Powerdns client.
        $powerdns = new Powerdns(env('PDNS_NS1'), env('PDNS_API_KEY'));

        // Create a new zone.
        $domain = 'comeback.com';
        $zone = $powerdns->createZone(
            $domain,
            [
                'ns1.domainracing.com.',
                'ns2.domainracing.com.',
            ]
        );

        // Add two DNS records to the zone.
        $zone->create(
            [
                ['type' => RecordType::A, 'content' => '206.189.245.64', 'ttl' => 60, 'name' => '@'],
                ['type' => RecordType::A, 'content' => '206.189.245.64', 'ttl' => 60, 'name' => 'www'],
            ]
        );

        return response()->json(
            [
                "success" => true,
                "message" => "LandingPage created successfully.",
                "data" => $landingPage
            ]
        );
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $landingPage = LandingPage::find($id);
        if (is_null($landingPage)) {
            return $this->_sendError("LandingPage not found.", "Doesn't exist.");
        }
        return response()->json(
            [
                "success" => true,
                "message" => "LandingPage retrieved successfully.",
                "data" => $landingPage
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LandingPage $landingPage)
    {
        $input = $request->all();
        $validator = Validator::make(
            $input,
            [
                'domain' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->_sendError('Validation Error.', $validator->errors());
        }

        $landingPage->domain = $input['domain'];
        $landingPage->save();

        return response()->json(
            [
                "success" => true,
                "message" => "LandingPage updated successfully.",
                "data" => $landingPage
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(LandingPage $landingPage)
    {
        $landingPage->delete();

        return response()->json(
            [
                "success" => true,
                "message" => "LandingPage deleted successfully.",
                "data" => $landingPage
            ]
        );
    }

    private function _sendError($msg, $err)
    {
        return [$msg, $err];
    }
}
