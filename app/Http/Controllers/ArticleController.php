<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;


class ArticleController extends Controller
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
            $body = $client->request('GET', $this->url . "auth/article?page=1",[
                    'headers' => [
                        'accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'paginator' => 5,
                        ],
                ])->getBody()->getContents();
            } catch (GuzzleException $e) {
                $body= $e->getResponse();
            }
           

            $article = json_decode($body);

            foreach ($article->data as $key => $value) {
                try {
                    $bodyx = $client->request('GET', $value->categories, [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        // 'Authorization' => 'bearer ' . $token, 
                    ])->getBody()->getContents();
                } catch (GuzzleException $e) {
                    $bodyx= $e->getResponse(); 
                }
// dd($bodyx);
                $article->categories[] = json_decode($bodyx);
            }

            $slide =  $this->getSlideContent($client, $request);
        } else {
            try {
                $body = $client->request('GET', $this->url . "auth/article?page=" . $page[1],[
                    'headers' => [
                        'accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'paginator' => 5,
                        ],
                    ])->getBody()->getContents();
            } catch (GuzzleException $e) {
                $body= $e->getResponse();
            }
           
// dd(json_decode($body));
            $article = json_decode($body);

            foreach ($article->data as $key => $value) {
                try {
                    $bodyx = $client->request('GET', $value->categories, [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        // 'Authorization' => 'bearer ' . $token, 
                    ])->getBody()->getContents();
                } catch (GuzzleException $e) {
                    $bodyx= $e->getResponse(); 
                }

                $article->categories[] = json_decode($bodyx);
            }
            $slide =  $this->getSlideContent($client, $request);
        }
       // dd($slide);
        return view('front.article', compact('article', 'slide'));
    }


    public function getSlideContent(Client $client, Request $request)
    {
        try {
            $body = $client->request('GET', $this->url . "auth/article",[
                'headers' => [
                    'accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    ],
                ])->getBody()->getContents();

            $article = json_decode($body);

            foreach ($article->data as $key => $value) {
                try {
                    $bodyx = $client->request('GET', $value->categories, [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        // 'Authorization' => 'bearer ' . $token, 
                    ])->getBody()->getContents();
                } catch (GuzzleException $e) {
                    $bodyx= $e->getResponse(); 
                }

                $article->categories[] = json_decode($bodyx);
            }
            array_splice($article->data, 4);

            return $article->data;

        } catch (GuzzleException $e) {
            $body= $e->getResponse();

            return null;
        } 
    }


    public function getByCategory(Client $client, Request $request, $slug)
    {
        // $page = explode('page=', $request->fullUrl());

        // if (!isset($page[1])) {
            try {
            $body = $client->request('GET', $this->url . "category/article?category=" . $slug,[
                    'headers' => [
                        'accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        // 'paginator' => 5,
                        ],
                ])->getBody()->getContents();
            } catch (GuzzleException $e) {
                $body= $e->getResponse();
            }
           

            $article = json_decode($body);

            foreach ($article->data as $key => $value) {
                try {
                    $bodyx = $client->request('GET', $value->categories, [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        // 'Authorization' => 'bearer ' . $token, 
                    ])->getBody()->getContents();
                } catch (GuzzleException $e) {
                    $bodyx= $e->getResponse(); 
                }

                $article->categories[] = json_decode($bodyx);
            }

// 
// paginator
        // } else {
        //     try {
        //         $body = $client->request('GET', $this->url . "auth/article?page=" . $page[1],[
        //             'headers' => [
        //                 'accept' => 'application/json',
        //                 'Content-Type' => 'application/json',
        //                 'paginator' => 5,
        //                 ],
        //             ])->getBody()->getContents();
        //     } catch (GuzzleException $e) {
        //         $body= $e->getResponse();
        //     }
           

        //     $article = json_decode($body);

        //     foreach ($article->data as $key => $value) {
        //         try {
        //             $bodyx = $client->request('GET', $value->categories, [
        //                 'Accept' => 'application/json',
        //                 'Content-Type' => 'application/json',
        //                 // 'Authorization' => 'bearer ' . $token, 
        //             ])->getBody()->getContents();
        //         } catch (GuzzleException $e) {
        //             $bodyx= $e->getResponse(); 
        //         }

        //         $article->categories[] = json_decode($bodyx);
        //     }
        //     $slide =  $this->getSlideContent($client, $request);
        // }
      

        return view('front.articlebycategory', compact('article'));
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
        try {
            $body = $client->request('GET', $this->url . "auth/article/" . $slug, [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->getBody()->getContents();

        } catch (Exception $e) {
            $body = $e->getResponse();
        }

        $article = json_decode($body);


            try {
                $bodyx = $client->request('GET', $article->data->categories, [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    // 'Authorization' => 'bearer ' . $token, 
                ])->getBody()->getContents();

            } catch (GuzzleException $e) {
                $bodyx= $e->getResponse(); 
            }

        $article->categories = json_decode($bodyx);
        
            // $article->categories[] = json_decode($bodyx);
        // }

        
 
        // $data['apa'] = 'coba';
        return view('front.articledetail', compact('article'));
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
