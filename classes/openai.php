<?php

class OpenAI
{
    private string $apiKey;
    private string $model = "gpt-5-mini";
    private string $url = "https://api.openai.com/v1/responses";

    public function __construct()
    {
        $this->apiKey = OPENAI_KEY;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function ask(string $systemPrompt, string $userPrompt): array
    {
        $payload = [

            "model" => $this->model,

            "input" => [

                [
                    "role" => "system",
                    "content" => [
                        [
                            "type" => "input_text",
                            "text" => $systemPrompt
                        ]
                    ]
                ],

                [
                    "role" => "user",
                    "content" => [
                        [
                            "type" => "input_text",
                            "text" => $userPrompt
                        ]
                    ]
                ]

            ]

        ];

        $curl = curl_init();

        curl_setopt_array($curl,[

            CURLOPT_URL=>$this->url,

            CURLOPT_RETURNTRANSFER=>true,

            CURLOPT_POST=>true,

            CURLOPT_POSTFIELDS=>json_encode($payload),

            CURLOPT_HTTPHEADER=>[

                "Content-Type: application/json",

                "Authorization: Bearer ".$this->apiKey

            ]

        ]);

        $response = curl_exec($curl);

        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);

        if(curl_errno($curl)){

            return [

                "success"=>false,

                "error"=>curl_error($curl)

            ];

        }

        curl_close($curl);

        $json = json_decode($response,true);

        if($httpCode != 200){

            return [

                "success"=>false,

                "error"=>$json

            ];

        }

        $texto = "";

        if(isset($json["output"])){

            foreach($json["output"] as $item){

                if(($item["type"] ?? "") === "message"){

                    foreach($item["content"] ?? [] as $content){

                        if(($content["type"] ?? "") === "output_text"){

                            $texto .= $content["text"];

                        }

                    }

                }

            }

        }

        return [

            "success"=>true,

            "text"=>$texto,

            "raw"=>$json

        ];

    }

}