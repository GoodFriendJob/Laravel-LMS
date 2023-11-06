<?php

namespace App\Http\Controllers\Backend\Admin;

use App\App;
use App\Helpers\AppResolver;
use App\Http\Controllers\Controller;
use App\Models\OauthClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\ClientRepository;

class ApiClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all()
    {
        $user = auth()->user();
        $app_resolver = new AppResolver();
        $app_id = $app_resolver->getAppId();
        if($app_id != null){
            $app = App::where('user_id','=',$user->id)->find($app_id);
        }else{
            return back()->with(['error' => 'No App Selected!']);
        }
        $data['title'] = 'API Clients';
        $data['clients'] = $app->api_clients;
        return view('client.all',$data);
    }

    public function generate(ClientRepository $clients)
    {

       $clients->create(
           auth()->user()->id, request('api_client_name'), '', '',0,1
        );
        return ['status' => 'success'];
    }
    public function status()
    {
        $client = OauthClient::find(request('api_id'));
        if($client == null){
            return ['status' => 'failure'];
        }
        $client->revoked = !$client->revoked;
        $client->save();
        return ['status' => 'success'];
    }
}
