<?php
$options = getopt("r:i:s:", ["recursive", "output-image:", "output-style"]);

$recursive = isset($options['r']) || isset($options['recursive']);
$outputImage = isset($options['i']) ? $options['i'] : 'sprite.png';
$outputStyle = isset($options['s']) ? $options['s'] : 'style.css';

$images = [];
scanImages("assets_folder");

if (empty($images)) {
    echo "No images found.\n";
    exit;
}

list($width, $height) = calculateSpriteSize($images);

$sprite = createSprite($images, $width, $height, $outputImage);

generateCSS($width, $height, $outputStyle);

echo "Done\n";

function scanImages($directory)
{
    global $images;
    $files = glob("$directory/*");

    foreach ($files as $file) {
        if (is_dir($file)) {
            scanImages($file);
        } elseif (substr($file, -4) == ".png") {
            array_push($images, $file);
        }
    }
}

function calculateSpriteSize($images)
{
    $maxWidth = 0;
    $maxHeight = 0;

    foreach ($images as $image) {
        $img = imagecreatefrompng($image);

        if ($img) {
            $maxWidth += imagesx($img);
            $maxHeight = max($maxHeight, imagesy($img));
            imagedestroy($img);
        }
    }

    return [$maxWidth, $maxHeight];
}

function createSprite($images, $width, $height, $outputImage)
{
    $x = 0;
    $sprite = imagecreatetruecolor($width, $height);

    foreach ($images as $image) {
        $img = imagecreatefrompng($image);

        if (!$img) {
            echo "Error loading image: $image\n";
            continue;
        }

        imagecopy($sprite, $img, $x, 0, 0, 0, imagesx($img), imagesy($img));
        $x += imagesx($img);
        imagedestroy($img);
    }

    imagepng($sprite, $outputImage);
    imagedestroy($sprite);
}

function generateCSS($width, $height, $outputStyle)
{
    $cssText = "
    .img {
        display: flex;
        width: ${width}px;
        height: ${height}px;
    }";

    $name = $outputStyle;
    if (file_put_contents($name, $cssText) === false) {
        // echo "<meta http-equiv='refresh' content='0; url=http://localhost/error.html'>";
    }
}
?>
