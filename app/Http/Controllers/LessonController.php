<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class LessonController extends Controller
{

    private $url = "http://127.0.0.1:8080/api/";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client, Request $request)
    {
        
        $page = explode('page=', $request->fullUrl());

        if (!isset($page[1])) {
            try {
                $body   = $client->request('GET', $this->url . "auth/lesson?page=1", [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                            'paginator' => 8,
                        ],
                    ])->getBody()->getContents();
            } catch (Exception $e) {
                $body   = $e->getResponse();
            }

            $lesson = json_decode($body);

            foreach ($lesson->data as $key => $value) {
                try {
                    $bodyx = $client->request('GET', $value->categories, [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        // 'Authorization' => 'bearer ' . $token, 
                    ])->getBody()->getContents();
                    
                    $category = json_decode($bodyx);
                } catch (GuzzleException $e) {
                    $category = $e->getResponse(); 
                }
                $lesson->data[$key]->categories = $category->data;
            }

        } else {
            try {
                $body   = $client->request('GET', $this->url . "auth/lesson?page=" . $page[1], [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                            'paginator' => 8,
                        ],
                    ])->getBody()->getContents();
            } catch (Exception $e) {
                $body   = $e->getResponse();
            }

            $lesson = json_decode($body);

            foreach ($lesson->data as $key => $value) {
                try {
                    $bodyx = $client->request('GET', $value->categories, [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        // 'Authorization' => 'bearer ' . $token, 
                    ])->getBody()->getContents();
                    
                    $category = json_decode($bodyx);
                } catch (GuzzleException $e) {
                    $category = $e->getResponse(); 
                }
                $lesson->data[$key]->categories = $category->data;
            }
        }
        $slide = $this->getSlideContent($request, $client);

        return view('front.lesson', compact('lesson', 'slide'));
    }

    
    public function getSlideContent(Request $request, Client $client)
    {
         try {
                $body   = $client->request('GET', $this->url . "auth/lesson", [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                        ]
                    ])->getBody()->getContents();

                $lesson = json_decode($body);

                foreach ($lesson->data as $key => $value) {
                    try {
                        $bodyx = $client->request('GET', $value->categories, [
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                            // 'Authorization' => 'bearer ' . $token, 
                        ])->getBody()->getContents();
                        
                        $category = json_decode($bodyx);
                    } catch (GuzzleException $e) {
                        $category = $e->getResponse(); 
                    }
                    $lesson->data[$key]->categories = $category->data;
                }
            } catch (Exception $e) {
                $body   = $e->getResponse();
            }

            array_splice($lesson->data, 3);
            return $lesson->data;
            
    }



    public function getByCategory(Client $client, Request $request, $slug)
    {
        
        $page = explode('page=', $request->fullUrl());

        // if (!isset($page[1])) {
            try {
                $body   = $client->request('GET', $this->url . "category/lesson?category=" . $slug, [
                        'headers' => [
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                            // 'paginator' => 8,
                        ],
                    ])->getBody()->getContents();
            } catch (Exception $e) {
                $body   = $e->getResponse();
            }

            $lesson = json_decode($body);

            foreach ($lesson->data as $key => $value) {
                try {
                    $bodyx = $client->request('GET', $value->categories, [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        // 'Authorization' => 'bearer ' . $token, 
                    ])->getBody()->getContents();
                    
                    $category = json_decode($bodyx);
                } catch (GuzzleException $e) {
                    $category = $e->getResponse(); 
                }
                $lesson->data[$key]->categories = $category->data;
            }

// for pagination

        // } else {
        //     try {
        //         $body   = $client->request('GET', $this->url . "auth/lesson?page=" . $page[1], [
        //                 'headers' => [
        //                     'Content-Type' => 'application/json',
        //                     'Accept' => 'application/json',
        //                     'paginator' => 8,
        //                 ],
        //             ])->getBody()->getContents();
        //     } catch (Exception $e) {
        //         $body   = $e->getResponse();
        //     }

        //     $lesson = json_decode($body);

        //     foreach ($lesson->data as $key => $value) {
        //         try {
        //             $bodyx = $client->request('GET', $value->categories, [
        //                 'Accept' => 'application/json',
        //                 'Content-Type' => 'application/json',
        //                 // 'Authorization' => 'bearer ' . $token, 
        //             ])->getBody()->getContents();
                    
        //             $category = json_decode($bodyx);
        //         } catch (GuzzleException $e) {
        //             $category = $e->getResponse(); 
        //         }
        //         $lesson->data[$key]->categories = $category->data;
        //     }
        // }


        return view('front.lessonbycategory', compact('lesson'));
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
    public function show(Client $client, $slug)
    {
        //
        try {
            $body = $client->request('GET', $this->url ."auth/lesson/" . $slug,[
                ])->getBody()->getContents();
        } catch (Exception $e) {
            $body = $e->getResponse();
        }

        $lesson = json_decode($body);

        try {
            $bodyx = $client->request('GET', $lesson->data->categories, [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                // 'Authorization' => 'bearer ' . $token, 
            ])->getBody()->getContents();
        } catch (GuzzleException $e) {
            $bodyx= $e->getResponse(); 
        }

        try {
            $bodyp = $client->request('GET', $this->url . "auth/lesson/". $slug . "/part",[
                ])->getBody()->getContents();
        } catch (Exception $e) {
            $bodyp = $e->getResponse();
            $bodyp = $bodyp->getBody()->getContents();
        }

            $lesson->category = json_decode($bodyx);
            $part = json_decode($bodyp);            
            // var_dump($part);
            // die();

        return view('front.lessondetail', compact('lesson', 'part'));
    }

    public function showVideo(Client $client, $parent, $slug)
    {
        try {
            $body = $client->request('GET', $this->url ."auth/lesson/" . $parent,[
                ])->getBody()->getContents();
        } catch (Exception $e) {
            $body = $e->getResponse();
        }

        $lesson = json_decode($body);

        try {
            $bodyx = $client->request('GET', $lesson->data->categories, [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                // 'Authorization' => 'bearer ' . $token, 
            ])->getBody()->getContents();
        } catch (GuzzleException $e) {
            $bodyx= $e->getResponse(); 
        }

        try {
            $bodyp = $client->request('GET', $this->url . "auth/lesson/". $parent . "/part",[
                ])->getBody()->getContents();
        } catch (Exception $e) {
            $bodyp = $e->getResponse();
            $bodyp = $bodyp->getBody()->getContents();
        }

        $lesson->category = json_decode($bodyx);
        $part = json_decode($bodyp);

        try {
            $bodyv = $client->request('GET', $this->url . "auth/lesson/".$parent."/". $slug,[
                ])->getBody()->getContents();
        } catch (Exception $e) {
            $bodyv = $e->getResponse();
        }
        $video = json_decode($bodyv);

        return view('front.lessonvideo', compact('lesson', 'part', 'video'));
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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


}
