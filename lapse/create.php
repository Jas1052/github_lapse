<?php
// Version 1.0
set_time_limit(9000);

use FileCommitAnimator\GithubRepoExtractor;
use FileCommitAnimator\ScreenshotCreator;
use GifCreator\AnimGif;

require 'vendor/autoload.php';
require_once dirname(__FILE__).'/../php-diff/lib/Diff.php';


function readline($prompt = null){
    if($prompt){
        echo $prompt;
    }
    $fp = fopen("php://stdin","r");
    $line = rtrim(fgets($fp, 1024));
    return $line;
}

$credentials = base64_encode("JasBOT" . ":" . "jasbotneverforgets");

/*
echo "--File Details--\n";
$name = "google"; //readline("Repository Owner Username: ");
$repo = "acai"; //readline("Repository Name: ");
$filePath = "README.md";//readline("File Path: ");
$fileName = "readme";
echo "\n";
*/

$name = $_POST['github_user']; //readline("Repository Owner Username: ");
$repo = $_POST['repo']; //readline("Repository Name: ");
$filePath = $_POST['path'];//readline("File Path: ");
$fileName = $_POST['filename'];


/*
echo "--File Details--\n";
$name = "Jas1052"; //readline("Repository Owner Username: ");
$repo = "jliu"; //readline("Repository Name: ");
$filePath = "index.html";//readline("File Path: ");
$fileName = "index";
echo "\n";
*/

echo "--Gif Configuration--\n";
$width = 750; //readline("Width (px): ");
$height = 1500; //readline("Height (px): ");
$frameRate = 5; //intval($frameRate);

echo "\n";

$extractor = new GithubRepoExtractor($name, $repo, $credentials);
$ssCreator = new ScreenshotCreator(dirname(__FILE__) . '/bin/phantomjs.exe');
ini_set('memory_limit','-1'); //allocates more memory
echo "Retrieving commits... ";
try {
    $commits = $extractor->getCommits();
} catch (Exception $e) {
    exit("\nError: " .  $e->getMessage() . " \n");
}
echo "done. \n";
  
if (!file_exists('commits\\')) {
    mkdir('commits');
} else {
    array_map('unlink', glob("commits\*") ?: []);
}

$frames = array();
$durations = array();
$counter = 1;
$numOfCommits = count($commits);
$lastCommit = "";


foreach ($commits as $commit) {
    $content = "<!DOCTYPE html><html><head><link rel='shortcut icon' href='../../www/img/favicon.ico' type='image/x-icon'/></head><body style='width:100%;height:100%;background-color:white;'>" .
                "<div style='font-family:Segoe UI;color:blue;font-size:50px;position:absolute;top:0;left:15px;'>" .
                $counter . "</div><div style='align-items:center;justify-content:center;'><pre><link rel='stylesheet' href='php-diff/examples/styles.css' type='text/css' charset='utf-8'/>";

    try {
        //Starts process of differences - Broken
        /*
        $newCommit = $extractor->getFileAtCommit($filePath, $commit);
        $a = explode("\n", $lastCommit);
        $b = explode("\n", $newCommit);
        $options = array(
          //'ignoreWhitespace' => true,
          //'ignoreCase' => true,
        );
        // Initialize the diff class
        $diff = new Diff($a, $b, $options);
        require_once dirname(__FILE__).'/../php-diff/lib/Diff/Renderer/Html/Inline.php';
        $renderer = new Diff_Renderer_Html_Inline;
        $content .= $diff->render($renderer);
        */
//        $lastCommit = $newCommit; 
        $content .= $extractor->getFileAtCommit($filePath, $commit);

    } catch (Exception $e) { }

    $content .= 
    "</pre></div></body></html><script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>" . 
    "<script>
    document.onkeydown = checkKey;
    function checkKey(e) {
        e = e || window.event;
      if (e.keyCode == '37') {
          var fileName = location.href.split('/').slice(-1); 
          fileName = fileName.toString();
          var dotIndex = fileName.indexOf('.');
          fileCount = fileName.substring(5, dotIndex);
          var count = parseInt(fileCount);
          count--;
          if(count>0){
            document.location.href = 'frame' + count + '.html';
         }
        }
        else if (e.keyCode == '39') {
           // right arrow
           var fileName = location.href.split('/').slice(-1); 
           fileName = fileName.toString();
           var dotIndex = fileName.indexOf('.');
           fileCount = fileName.substring(5, dotIndex);
           var count = parseInt(fileCount);
           count++;
          $.get('frame'+count+'.html')
            .done(function() { 
              document.location.href = 'frame' + count + '.html';
            }).fail(function() { 
                  // not exists code
            })
          }
      }

    </script>";
    $htmlFile = fopen("commits\\frame" . $counter . ".html", "w") or exit("Unable to write file: commits\\frame-" . $counter . ".html");
    fwrite($htmlFile, $content);

    $htmlPath = "file:///" .  str_replace('\\', '/', dirname(__FILE__)) . "/commits/frame" . $counter . ".html";
    $imgPath = "./commits/frame". $counter . ".png";

    $frames[$counter-1] = $imgPath;
    $durations[$counter-1] = 100/$frameRate;

    $ssCreator->createScreenshot($htmlPath, $width, $height, $imgPath);

    echo "\rProgress: " .  $counter . "/" . $numOfCommits . " frames completed. ";

    fclose($htmlFile);
    $counter += 1;
}

echo "\n";
echo "Creating gif... ";
$anim = new GifCreator\AnimGif();
$anim->create($frames, $durations);

if (!file_exists('gifs\\')) {
    mkdir('gifs');
}

$anim->save("./gifs/" . $fileName . "_" . date("h-i-s") . ".gif");
echo "./gifs/" . $fileName . "_" . date("h-i-s") . ".gif" . " created. \n";

header('Location: ../www/index.html');
exit;