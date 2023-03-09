<?php
require_once "secrets.php";

if (@$_POST["promptSubmit"]) {

  $url = 'https://api.openai.com/v1/chat/completions';
  $data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [["role" => "user", "content" => @$_POST["prompt"]]],
    "max_tokens" => 500,
    "temperature" => 1
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

  // $response = Array ( 
  //   "choices" => Array ( 
  //      Array (
  //       "message" => Array ( 
  //         "role" => "assistant",
  //         "content" => '<h1>Introducing Shooter Game: The Ultimate First Person Sci-Fi Shooter</h1> Get ready to immerse yourself in a world of unrelenting action, futuristic weaponry, and customizable characters with Shooter Game, the latest release from My Game Studio published by Camnlan Games. This first person shooter is set to hit Steam in Q1 of 2024, and you won\'t want to miss out on this epic gaming experience. As the name suggests, Shooter Game is a first person shooter that is sure to deliver an adrenaline-fueled experience for all those who love action-packed games. Players will find themselves in a sci-fi world where they must battle through hordes of enemies using a large variety of weapons and gadgets. One of the highlights of Shooter Game is the ability for players to customize their characters to a high degree. From unique backgrounds to varying abilities, players are given the power to make their character their own. Additionally, there is a large number of weapons and accessories to choose from, making each gameplay session unique. Unlockable skins for characters are also included, providing players with a way to stand out in the battlefield. What\'s better than taking down your enemies with style? My Game Studio has put a lot of effort into making sure Shooter Game is not just another shooter game, but an experience that is unique and enjoyable. The studio has put their heart and soul into the game, ensuring that all the details are fine-tuned to perfection. Camnlan Games has also stepped up to make sure that the game reaches as many people as possible. As a publisher, they understand the importance of making the game available to a wider audience, and they have done just that. If you\'re a fan of first person shooters, sci-fi, and action games, Shooter Game is a title that deserves a spot on your Steam wishlist. Add it now and get ready to embark on an epic journey through an immersive and exciting world packed with intense battles, explosive action, and endless customization.'
  //       ) 
  //     ) 
  //   ) 
  // );

  $text = '';

  if ($response === false) {
    echo 'cURL error: ' . curl_error($ch);
  } else {
    $response = json_decode($response, true);
    if (!$response["choices"]) $text = "Something Went Wrong 😱";
    $text = $response["choices"][0]["message"]["content"];
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
        <input type="submit" class="btn btn-primary" name="promptSubmit">
      </div>
    </form>

    <span class="d-flex flex-column justify-content-center align-items-center" style="height: 100%;"><?php echo @$text ?></span>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>

<?php
/*
Prompt: (Work in progress) Write an article for a new game release called "Shooter Game". Below are specifics on the game that should be included:
Tags: First Person Shooter, Action, Sci-Fi
Game play: First person shooter
Game Features: Customizable characters, Large number of weapons and accessories, unlock able skins for character
Game Studio: My Game Studio
Publisher: Camnlan Games
Release Date: Q1 2024
The call to action for the article is "Add to your Steam wishlist". The title of the article should be wrapped in <h1> tags.

"Can you break down the key gameplay features of <GAME>?"
  */
?>