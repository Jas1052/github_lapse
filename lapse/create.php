<?php
// Version 1.0
set_time_limit(9000);

use FileCommitAnimator\GithubRepoExtractor;
use FileCommitAnimator\ScreenshotCreator;
use GifCreator\AnimGif;

require 'vendor/autoload.php';

function readline($prompt = null){
    if($prompt){
        echo $prompt;
    }
    $fp = fopen("php://stdin","r");
    $line = rtrim(fgets($fp, 1024));
    return $line;
}

$credentials = base64_encode("JasBOT" . ":" . "jasbotneverforgets");

echo "--File Details--\n";
$name = "ember-links"; //readline("Repository Owner Username: ");
$repo = "list"; //readline("Repository Name: ");
$filePath = "README.md";//readline("File Path: ");
$fileName = "readme";
echo "\n";

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

foreach ($commits as $commit) {
    $htmlFile = fopen("commits\\frame" . $counter . ".html", "w") or exit("Unable to write file: commits\\frame-" . $counter . ".html");
    $content = "<!DOCTYPE html><html><body style='width:100%;height:100%;background-color:white;'>" .
                "<div style='font-family:Segoe UI;color:blue;font-size:50px;position:absolute;top:0;left:15px;'>" .
                $counter . "</div><div style='display:flex;align-items:center;justify-content:center;'><pre>";

    try {
        $content .= $extractor->getFileAtCommit($filePath, $commit);
    } catch (Exception $e) { }

    $content .= "</pre></div></body></html>";
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