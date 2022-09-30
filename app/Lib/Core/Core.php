<?php

namespace  App\Lib\Core;

class Core
{
    public static function getUploadedPath($dirName = false)
    {
        if ($dirName != "") {
            $dirName = "/" . $dirName;
        }
        $uploadedDocPath = public_path('storage' . $dirName);
        return $uploadedDocPath;
    }

    public static function getUploadedURL($dirName = false)
    {
        if ($dirName != "") {
            $dirName = "/" . $dirName;
        }
        $uploadedDocURL = url('storage' . $dirName);
        $uploadedDocURL = $uploadedDocURL . "/";
        return $uploadedDocURL;
    }

    public static function getImgDir()
    {
        $url = url('img');
        $url = $url . "/";
        return $url;
    }

    public function generateRandomUniquePin($requestedPinArr = [])
    {
        if ($requestedPinArr && count($requestedPinArr) > 0) {
            do {
                $loginPin = rand(100000, 999999);
            } while (in_array($loginPin, $requestedPinArr));
        } else {
            $loginPin = rand(100000, 999999);
        }
        return $loginPin;
    }

    public static function getYtubeVideoId($url)
    {
        $videoIdArr = array();
        if (stristr($url, "youtu.be/")) {/*Share link.*/
            $videoIdArr = explode("youtu.be/", $url);
        } else if (stristr($url, "/watch?v=")) {/*Normal/Default link.*/
            $videoIdArr = explode("/watch?v=", $url);
        }
        /*Get the array data.*/
        $video_id = "";
        if (!empty($videoIdArr)) {
            $video_id = $videoIdArr[1];
        }
        return $video_id;
    }

    /*Type options are : default / sddefault / mqdefault / hqdefault / maxresedefault*/
    public static function getYtubeImage($url, $type = false)
    {
        $videoArr = array();
        $thumb_link = '';
        $videoTypeArr = array('0' => $type, '1' => 'maxresedefault', '2' => 'hqdefault', '3' => 'mqdefault', '4' => 'sddefault', '5' => 'default');
        $video_id = self::getYtubeVideoId($url);
        if ($video_id != "") {
            $videoArr['video_id'] = $video_id;
            if ($type == "") {
                $type = "default";
            }
            foreach ($videoTypeArr as $key => $videoType) {
                $mediaUrl =  'https://img.youtube.com/vi/' . $video_id . '/' . $videoType . '.jpg';
                $max = get_headers($mediaUrl);
                if ($videoType && substr($max[0], 9, 3) !== '404') {
                    $thumb_link = $mediaUrl;
                    break;
                }
            }
            $videoArr['thumb_link'] = $thumb_link;
        }
        return $videoArr;
    }

    public static function getYtubeVdoLnk($video_id)
    {
        $videoLink = 'https://www.youtube.com/watch?v=' . $video_id;
        return $videoLink;
    }

    public static function getYtubeIframeLnk($url)
    {
        $video_id = self::getYtubeVideoId($url);
        if ($video_id != "") {
            $videoLink = 'https://www.youtube.com/embed/' . $video_id . '?modestbranding=0&amp;rel=0&amp;controls=1&amp;fs=1&amp;autohide=1&amp;loop=1&amp;modestbranding=1';
        }
        return $videoLink;
    }

    public static function ytubePlayer($url, $width = 0, $height = 0)
    {
        $videoLink = self::getYtubeIframeLnk($url);
        if ($videoLink != "") {
            $widthAtr = $width > 0 ? ' width="' . $width . '"' : '';
            $heightAtr = $height > 0 ? ' height="' . $height . '"' : '';
            echo '<iframe' . $widthAtr . '' . $heightAtr . ' src="' . $videoLink . '" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="ytube"></iframe>';
        }
    }

    public static function htmlVideoPlayer($url, $poster = false)
    {
        $posterAtr = $poster != false ? ' poster="' . $poster . '"' : '';
        if ($url != "") {
            echo '<video width="100%"' . $posterAtr . ' autoplay="" loop="" muted="" controls="">
                <source src="' . $url . '" type="video/mp4">
            </video>';
        }
    }

    public static function request_uri_without_query($url)
    {
        $query = '';
        $url_arr = parse_url($url);
        if (array_key_exists('query', $url_arr)) {
            $query = $url_arr['query'];
        }
        $url = str_replace(array($query, '?'), '', $url);
        return $url;
    }


    public static function removeSpecialChars($string)
    {
        $string = str_replace(' ', '-', trim($string)); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

    public static function roundUpToAny($n, $x = 5)
    {
        return (ceil($n) % $x === 0) ? ceil($n) : round(($n + $x / 2) / $x) * $x;
    }

    public static function generatePrefixPadString($maxGenNum, $prefix, $length)
    {
        if ($maxGenNum) {
            $intVal = (int) str_replace($prefix, '', $maxGenNum);
            return $prefix . str_pad($intVal + 1, $length, '0', STR_PAD_LEFT);
        } else
            return $prefix . str_pad(1, $length, '0', STR_PAD_LEFT);
    }

    public static function getFaIconByMimeType($mime_type)
    {
        $icon_classes = array(
            // Media
            'image/jpeg' => 'displayimage',
            'image/png' => 'displayimage',
            'image/gif' => 'displayimage',
            'image/tiff' => 'displayimage',
            'image/webp' => 'displayimage',
            'image/bmp' => 'displayimage',
            'image/vnd.microsoft.icon' => 'displayimage',
            'image/svg' => 'displayimage',
            'audio' => 'fa-file-audio-o',
            'video' => 'fa-file-video-o',
            // Documents
            'application/pdf' => 'fa-file-pdf-o',
            'application/msword' => 'fa-file-word-o',
            'application/vnd.ms-word' => 'fa-file-word-o',
            'application/vnd.oasis.opendocument.text' => 'fa-file-word-o',
            'application/vnd.openxmlformats-officedocument.wordprocessingml' => 'fa-file-word-o',
            'application/vnd.ms-excel' => 'fa-file-excel-o',
            'application/vnd.openxmlformats-officedocument.spreadsheetml' => 'fa-file-excel-o',
            'application/vnd.oasis.opendocument.spreadsheet' => 'fa-file-excel-o',
            'application/vnd.ms-powerpoint' => 'fa-file-powerpoint-o',
            'application/vnd.openxmlformats-officedocument.presentationml' => 'fa-file-powerpoint-o',
            'application/vnd.oasis.opendocument.presentation' => 'fa-file-powerpoint-o',
            'text/plain' => 'fa-file-text-o',
            'text/html' => 'fa-file-code-o',
            'application/json' => 'fa-file-code-o',
            // Archives
            'application/gzip' => 'fa-file-archive-o',
            'application/zip' => 'fa-file-archive-o',
        );
        foreach ($icon_classes as $text => $icon) {
            if (strpos($mime_type, $text) === 0) {
                return $icon;
            }
        }
        return $mime_type;
    }

    /**
     * @return mixed[]
     */
    public static function csvToArray(string $filename, string $delimiter = ','): array
    {
        $data = [];
        if (file_exists($filename) && is_readable($filename)) {
            $header = null;

            if (($handle = fopen($filename, 'r')) !== false) {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                    if (!$header) {
                        $header = $row;
                    } else {
                        $data[] = array_combine($header, $row);
                    }
                }
                fclose($handle);
            }
        }

        return $data;
    }
}
