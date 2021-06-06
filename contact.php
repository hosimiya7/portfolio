<?php 

function getPostedValue($text):string
  {
    return array_key_exists($text,$_POST) ? $_POST[$text] : '';
  }

$name = getPostedValue('name');
$email = getPostedValue('email');
$content = getPostedValue('content');


function getDBHandler()
{
  include_once(dirname(__FILE__).'/config.php');
  $dbhost = $config['dbhost'];
  $dbname = $config['dbname'];
  $dbuser = $config['dbuser'];
  $dbpass = $config['dbpass'];

  $dsn = "mysql:dbname=$dbname;host=$dbhost";
  $user = $dbuser;
  $password = $dbpass;
  try{
    $dbh = new PDO($dsn, $user, $password);
    return $dbh;
  } catch(PDOException $e){
    echo "接続失敗:".$e->getMessage()."\n";
    exit();
  }
}

function create(string $name, string $email, string $content):void
{
  $dbh = getDBHandler();

  $sql = 'INSERT INTO contacts(name, email, content) VALUES(:name, :email, :content)';
  $prepare = $dbh->prepare($sql);
  // どの箱に何を入れるか
  $prepare->bindValue(':name', $name, PDO::PARAM_STR);
  $prepare->bindValue(':email', $email, PDO::PARAM_STR);
  $prepare->bindValue(':content', $content, PDO::PARAM_STR);
  try {
  $prepare->execute();
  } catch (PDOException $th) {
    throw $th;
  }
}

create($name, $email, $content);


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="portfolio-common.css">
  <link rel="stylesheet" href="portfolio-sp.css" media="screen and (max-width:480px)">
  <link rel="stylesheet" href="portfolio-tb.css" media="screen and (min-width:480px) and (max-width:960px)">
  <link rel="stylesheet" href="portfolio-pc.css" media="screen and (min-width:960px)">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
  <title>contact</title>
</head>
<body>
<div class="response">
  <div class="response-top">
    <h1>ありがとうございました。</h1>
  </div>
  <div class="respons-main">
    <div class="response-name">
      <p>
      お名前：<?php echo htmlspecialchars($name); ?>
      </p>
    </div>
    <div class="response-email">
      <p>
      連絡先：<?php echo htmlspecialchars($email); ?>
      </p>
    </div>
    <div class="response-content">
      <p>
      内容：<?php echo htmlspecialchars($content); ?>
      </p>
    </div>
    <div class="response-comment">
    <p>
      以上の内容で承りました。
    </p>
   </div>
  </div>
  <div class="response-btn">
    <a href="portfolio.html"><i class="fas fa-arrow-left fa-2x"></i></a>
  </div>
</div>

</body>
</html>

