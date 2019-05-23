<?php

namespace memento\Http\Controllers\Auth;

use memento\User;
use memento\Job;
use memento\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'gsm' => ['required'],
            'job' => ['required']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \memento\User
     */
    protected function create(array $data)
    {

        
        $job = Job::where('name', $data['job'])->first();

        if($job === null){
            $job = Job::create(['name' => $data['job']]);
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'api_token' => str_random(60),
                'gsm' => $data['gsm'],
                'job_id' => $job->id,
                'password' => Hash::make($data['password']),
            ]);
        }else{
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'api_token' => str_random(60),
                'gsm' => $data['gsm'],
                'job_id' => $job->id,
                'password' => Hash::make($data['password']),
            ]);
        }


        
    }
}
