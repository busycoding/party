<?php

namespace App\Http\Controllers\Api;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

// https://www.youtube.com/watch?v=fiVA2Oko23o
//https://www.youtube.com/watch?v=OJtGeqgXwfo 
//https://www.youtube.com/watch?v=4fLoVIqHCcc
//https://stackoverflow.com/questions/59110730/laravel-client-authentification-with-external-laravel-passport-lumen-api
// https://stackoverflow.com/questions/59113959/request-guidance-on-error-in-receiving-token-in-laravel
// https://stackoverflow.com/questions/59330402/how-do-i-get-a-refresh-token-in-laravel-passport
// https://stackoverflow.com/questions/58621097/laravel-passport-authentication-issues-with-decoupled-vuejs-client
// https://stackoverflow.com/questions/58642227/how-to-get-an-authorization-code-from-the-authorization-code-grant-in-laravel-pa
// https://stackoverflow.com/questions/58805356/unable-to-authorize-or-get-token
// https://stackoverflow.com/questions/58828291/how-to-get-an-users-access-token-programically-using-laravel-passport
// https://stackoverflow.com/questions/58917651/how-should-i-store-the-access-token-to-my-api-in-the-browser-after-login-flow-au
// https://stackoverflow.com/questions/59103610/how-to-retrieve-access-token-with-passport-in-laravel
// https://stackoverflow.com/questions/tagged/laravel-passport
// https://laravel.io/forum/laravel-passport-vue-check-user-authentication
//https://www.udemy.com/course/laravel-restful-api-with-passport-authentication/
//https://www.udemy.com/course/restful-api-with-laravel-php-homestead-passport-hateoas/
//https://pusher.com/tutorials/laravel-vue-axios
//https://laravel.com/docs/5.8/passport#requesting-tokens
//https://laravel.com/docs/5.8/api-authentication
//https://raw.githubusercontent.com/DevMarketer/DevMarketer/b30124b183357538574764bb86c692d342498fae/app/Http/Controllers/PermissionController.php
//https://www.youtube.com/watch?v=5alYl63tXL8
//https://www.google.com/search?q=laravel+how+to+do+api+login+call+passport&oq=laravel+how+to+do+api+login+call+passport&aqs=chrome..69i57.19295j1j4&sourceid=chrome&ie=UTF-8
//https://www.youtube.com/watch?v=HPW0hjZJoNw
//https://www.youtube.com/results?search_query=laravel+passport+login
//https://www.youtube.com/watch?v=HGh0cKEVXPI&t=838s
//https://www.youtube.com/watch?v=gRbuInSwU9U
//https://www.youtube.com/watch?v=FJ270I0Pwtc
//https://www.youtube.com/results?search_query=laravel+axios+login
//https://github.com/webdevmatics/webdevlistapi/blob/master/app/Http/Controllers/Api/AuthController.php
//https://www.youtube.com/watch?v=GRhkhSzyApc
//https://www.youtube.com/watch?v=Wd646u2Sikg
//https://www.youtube.com/watch?v=Ym5_8f-tMzc
//https://tutsforweb.com/restful-api-in-laravel-56-using-jwt-authentication/
// https://stackoverflow.com/questions/54008703/how-to-convert-a-laravel-project-to-a-laravel-api
//https://dev.to/sandeepbalachandran/api-authentification-with-laravel-5-8-passport-56d7

class AuthController extends Controller
{
   public function register(Request $request)
   {

        $validatedData = $request->validate([
            'name'=>'required|max:55',
            'email'=>'email|required|unique:users',
            'password'=>'required|confirmed'
        ]);
        //$validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;
        return response(['user'=> $user, 'access_token'=> $accessToken]);



/*        $validatedData = $request->validate([
            'name'=>'required|max:55',
            'email'=>'email|required|unique:users',
            'password'=>'required|confirmed'
        ]);
        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;
        return response(['user'=> $user, 'access_token'=> $accessToken]);*/

        $request->validate([
            'name'=>'required|max:55',
            'email'=>'email|required|unique:users',
            'password'=>'required|confirmed'
        ]);

        $user = new User();
        //$user = User::firstOrNew(['email' => $request->email]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $user->save();

        $http = new Client;
        //TODO: update the link below to url('/oauth/token')
		$response = $http->post('http://localhost:8001/oauth/token', [
		    'form_params' => [
		        'grant_type' => 'password',
		        'client_id' => 2,
		        'client_secret' => 'PURUkO6MjdKUsNvt6UcbWQEkCXTSrWwoxR4GU9Wu',
		        'username' => $request->email,
		        'password' => $request->password,
		        'scope' => '',
		    ],
		]);
		//https://github.com/guzzle/guzzle/issues/1857
//'client_id' => config('services.passport.client_id'), //client id
//            'client_secret' => config('services.passport.client_secret'), //client secret
		//return json_decode((string) $response->getBody(), true);
		return response(['data' => json_decode((string) $response->getBody(), true)]);
       

   }
   public function login(Request $request)
   {

        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
       
        if(!auth()->attempt($loginData)) {
            return response(['message'=>'Invalid credentials']);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user' => auth()->user(), 'access_token' => $accessToken]);


        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
       
/*        if(!auth()->attempt($loginData)) {
            return response(['message'=>'Invalid credentials']);
        }
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return response(['user' => auth()->user(), 'access_token' => $accessToken]);*/

        $user = User::where('email', $request->email)->first();

        if(!$user){
        	return response(['status' => 'error', 'message' => 'User not found']);
        }

        if(Hash::check($request->password, $user->password)){
	        $http = new Client;
	        //TODO: update the link below to url('/oauth/token')
			$response = $http->post('http://localhost:8001/oauth/token', [
			    'form_params' => [
			        'grant_type' => 'password',
			        'client_id' => 2,
			        'client_secret' => 'PURUkO6MjdKUsNvt6UcbWQEkCXTSrWwoxR4GU9Wu',
			        'username' => $request->email,
			        'password' => $request->password,
			        'scope' => '',
			    ],
			]);

			//return json_decode((string) $response->getBody(), true);
			return response(['data' => json_decode((string) $response->getBody(), true)]);
        }
   }
}
