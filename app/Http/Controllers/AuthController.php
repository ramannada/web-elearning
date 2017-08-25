<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\UploadedFile;
use Alert;
use Session;

class AuthController extends Controller
{

    private $url = "http://127.0.0.1:8080/api/";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client)
    {
        return view('front.login');
    }

    public function postLogin(Client $client, Request $request)
    {
        try {
            $body = $client->post( $this->url . 'auth/login' , [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    ],
                'json' => [
                    'username' => $request->username,
                    'password' => $request->password,
                ],
                // 'Authorization' => 'bearer ' . $token, 
            ])->getBody()->getContents();

            $body = json_decode($body);
            Session::put('login', $body);
            $login = Session::get('login');


            if ($login->data->role == 'administrator') {
                // redirect()->route('profile');
            }elseif ($login->data->role == 'moderator') {
                redirect()->route();
            }elseif ($login->data->role == 'contributor') {
                redirect()->route();
            }else{
                return redirect()->route('home');
            }
        } catch (GuzzleException $e) {
            $body = $e->getResponse()->getBody()->getContents();
        }
        alert()->error('Username atau password tidak sesuai', 'Kesalahan');

        return redirect()->route('auth.get.login');
    }

    public function getRegister(Client $client)
    {
        return view('front.register');
    }

    public function postRegister(Client $client, Request $request)
    {
        try {
            $body = $client->request('POST', $this->url . 'auth/register',[
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    "name"=> $request->name,
                    "username" => $request->username,
                    "email" => $request->email,
                    "password" => $request->password,

                ] 
            ])->getBody()->getContents();

        } catch (GuzzleException $e) {
            $body = $e->getResponse()->getBody()->getContents();
        }
        
        $body = json_decode($body);
            // Alert::message('Register berhasil!');
        alert()->info('Silakan Aktifasi Akun Melalui Email', 'Register Berhasil');

         return redirect()->route('auth.get.login');


    }

    public function activation(Client $client)
    {
        return view('front.activation');
    }

    public function logout(Client $client)
    {
        Session::forget('login');

        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function getUpdate(Request $request, Client $client)
    {
        try {
            $body = $client->get( $this->url . 'guest/profile' , [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'authorization' => 'Bearer ' . Session::get('login')->meta->api_token, 
                    ],
                // 'Authorization' => 'bearer ' . $token, 
            ])->getBody()->getContents();
            $user = json_decode($body)->data;
        } catch (Exception $e) {
            $user = null;
        }
        $tab ='';

        return view('front.profileupdate', compact('user', 'tab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        // $this->validate($request,[
        //         'name' => 'required',
        //         'phone' => 'required',
        //     ]);

        $data = [
            "name"=> $request->name,
            "phone_number" => $request->phone,
        ];

        if ($request->file('photo') != NULL) {
            $path      = $request->file('photo')
                                 ->getRealPath();
            $name      = $request->file('photo')
                                 ->getClientOriginalName();
            $extension = $request->file('photo')
                                 ->getClientOriginalExtension();
            $mime      = $request->file('photo')
                                 ->getMimeType();

            $thumbnail = [
                'name'      => "photo",
                'filename'  => $name,
                'Mime-Type' => $mime,
                'contents'  => fopen(realpath($path), 'rb'),
            ];


            try {
                $body = $client->request('POST', $this->url . 'guest/profile',[
                            'headers' => [
                                'Accept' => 'application/json',
                                'Content-Type' => 'application/json',
                                'authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                            ],
                            'query' => $data,
                            'multipart' => $thumbnail,
                        ])->getBody()->getContents();
            } catch (GuzzleException $e) {
                $body = $e->getResponse()->getBody()->getContents();
                $body = json_decode($body);
                $body = $body->error->message;

                if (isset($body->name) ||
                    isset($body->phone_number)||
                    isset($body->photo)) {

                    $tab  = 'profil';

                    return redirect()
                        ->action('AuthController@getUpdate')
                        ->with('error', $body)
                        ->with('old', $data)
                        ->with('tab', $tab);
                }
            }
        } else {
            try {
                $body = $client->request('POST', $this->url . 'guest/profile',[
                            'headers' => [
                                'Accept' => 'application/json',
                                'Content-Type' => 'application/json',
                                'authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                            ],
                            'query' => $data,
                        ])->getBody()->getContents();
            } catch (GuzzleException $e) {
                $body = $e->getResponse()->getBody()->getContents();
                $body = json_decode($body);
                $body = $body->error->message;

                if (isset($body->name) ||
                    isset($body->phone_number)||
                    isset($body->photo)) {

                    $tab  = 'edit';

                    return redirect()
                        ->action('AuthController@getUpdate')
                        ->with('error', $body)
                        ->with('old', $data)
                        ->with('tab', $tab);
                }
            }
        }

        $result = json_decode($body);

        return redirect()->route('profile', compact('result'));
    }

    public function changePassword(Request $request, Client $client)
    {
        // $this->validate($request,[
        //         'password_lama' => 'required',
        //         'password_baru' => 'required',
        //         'verifikasi_password' => 'required|same:password_baru',
        //     ]);

        try {
            $body = $client->request('POST', $this->url . 'guest/profile/change_password',[
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'authorization' => 'Bearer ' . Session::get('login')->meta->api_token,
                ],
                'json' => [
                    "old_password" => $request->password_lama,
                    "new_password" => $request->password_baru,
                    "confirm_new_password" => $request->verifikasi_password,
                ], 
            ])->getBody()->getContents();   
        } catch (GuzzleException $e) {
            $body = $e->getResponse()->getBody()->getContents();
            $body = json_decode($body);
            $body = $body->error->message;

            return redirect()
                        ->action('AuthController@getUpdate')
                        ->with('error', $body)
                        ->with('tab', 'password');
        }
        // dd($body);
        $result = json_decode($body);

        return redirect()->route('profile', compact('result'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function account(Client $client)
    {
        try {
            $body = $client->get( $this->url . 'guest/profile' , [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'authorization' => 'Bearer ' . Session::get('login')->meta->api_token, 
                    ],
                // 'Authorization' => 'bearer ' . $token, 
            ])->getBody()->getContents();
            $profil = json_decode($body)->data;

            try {
                $transaksi = $client->get($this->url . 'guest/subcription/transactions', [
                                        'headers' => [
                                            'Accept' => 'application/json',
                                            'Content-Type' => 'application/json',
                                            'authorization' => 'Bearer ' . Session::get('login')->meta->api_token, 
                                            ],
                                        // 'Authorization' => 'bearer ' . $token, 
                                    ])->getBody()->getContents();
                $transaksi = json_decode($transaksi)->data;
            } catch (Exception $e) {
                
            }
        } catch (Exception $e) {
            $profil = null;
        }
        return view('front.profile', compact('profil', 'transaksi'));
    }
}
