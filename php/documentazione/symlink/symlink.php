<?php

$argv = $_SERVER['argv'];

if (count($argv) < 2) {
    echo "Usage: php symlink.php - Please provide the original and target path.";
    exit(1);
}

$originalPath = $argv[1];
$targetPath = $argv[2];

//if (! file_exists($targetPath)) {
//    echo "TargetPath path does not exist.";
//    exit(1);
//}

//if (file_exists($originalPath)) {
//    echo "Original exists! It SHOULD NOT exists.";
//	exit(1);
//}

// Make a backup of the original path

$command = sprintf('cmd /c mklink /D "%s" "%s"', $originalPath, $targetPath);
exec($command, $output, $returnCode);

if ($returnCode !== 0) {
	exit(1);
}
