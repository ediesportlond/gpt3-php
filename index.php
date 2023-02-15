<?php
require_once "secrets.php";
//https://api.openai.com/v1/completions
/*
POST
Headers
Content-Type: application/json
Authorization: Bearer TOKEN
Request body
{
  "model": "text-ada-001",
  "prompt": "Say this is a test",
  "max_tokens": 7,
  "temperature": 0
}
Response Body
{
    "id": "cmpl-6kC2GJ87vF0dVAUXcae4oQC92lMI5",
    "object": "text_completion",
    "created": 1676467372,
    "model": "text-ada-001",
    "choices": [
        {
            "text": "\n\nWhat is your name?",
            "index": 0,
            "logprobs": null,
            "finish_reason": "length"
        }
    ],
    "usage": {
        "prompt_tokens": 5,
        "completion_tokens": 7,
        "total_tokens": 12
    }
}

*/

if(@$_POST["promptSubmit"]){

$url = 'https://api.openai.com/v1/completions';
$data = [
    "model"=> "text-ada-001",
  "prompt"=> @$_POST["prompt"],
  "max_tokens"=> 7,
  "temperature"=> 0
];

$headers = array(
  'Authorization: Bearer ' . OPENAI_TOKEN,
  'Content-Type: application/json'
);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

$text = '';

if ($response === false) {
    echo 'cURL error: ' . curl_error($ch);
} else {
    $response = json_decode($response, true);
    $text = $response["choices"][0]["text"];
}

curl_close($ch);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sample GPT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
  <div class="container pt-4" style="height:100vh; width: 100vw;">
    <form action="/" method="post">
      <div class="input-group">
      <input type="text" name="prompt" placeholder="Enter your prompt" class="form-control form-control-lg">
      <input type="submit" class="btn btn-primary" name ="promptSubmit">
      </div>
    </form>

    <p class="d-flex justify-content-center align-items-center" style="height: 100%;"><?php echo @$text ?></p>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>