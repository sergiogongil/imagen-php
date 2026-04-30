<?php
/**
 * Imagen-PHP (Modernized Version)
 * Original Copyright (c) 2019 SergioGG - MIT License
 */

session_start();
if (session_status() === PHP_SESSION_ACTIVE && empty($_SESSION['id_sesion'])) {
    $_SESSION['id_sesion'] = session_name();
}

class ImageHandler {
    private string $ruta = "data";
    private string $imgDefault = "data/default.jpg";
    private string $estampa = "data/estampa.png";
    private string $bgcaptcha = "data/bgcaptcha.gif";
    
    private int $ancho = 600;
    private int $altmax = 400;
    private array $colorText = [255, 255, 255];
    private array $background = [255, 255, 255];
    
    private string $nombre = "";
    private string $texto = "";
    private int|false $filtro = false;
    private int|false $efecto = false;

    public function __construct() {
        // Validación estricta y sanitización de parámetros GET
        $this->ancho = filter_input(INPUT_GET, 'x', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 1280]]) ?: 600;
        $this->altmax = filter_input(INPUT_GET, 'y', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 1024]]) ?: 400;
        
        $this->filtro = filter_input(INPUT_GET, 'f', FILTER_VALIDATE_INT) ?: false;
        $this->efecto = filter_input(INPUT_GET, 'e', FILTER_VALIDATE_INT) ?: false;
        $this->texto = htmlspecialchars(strip_tags((string)(filter_input(INPUT_GET, 't') ?? '')));
        
        $rawNombre = filter_input(INPUT_GET, 'n') ?? '';
        $this->setNombre($rawNombre);
    }

    private function setNombre(string $rawNombre): void {
        if ($rawNombre === "icrear" || $rawNombre === "captcha") {
            $this->nombre = $rawNombre;
            return;
        }

        // Seguridad: Evitar Directory Traversal usando basename
        // Solo permitimos archivos que realmente existan dentro de la carpeta $ruta
        if ($rawNombre) {
            $safeName = basename($rawNombre);
            // Comprobamos si el path original incluía la ruta, para mantener compatibilidad
            $rutaCompleta = str_starts_with($rawNombre, $this->ruta . '/') ? $rawNombre : $this->ruta . '/' . $safeName;
            
            if (is_file($rutaCompleta)) {
                $this->nombre = $rutaCompleta;
                return;
            }
        }
        $this->nombre = $this->imgDefault;
    }

    private function randomText(): string {
        $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
        $text = '';
        // PHP 8+: Uso de corchetes en lugar de llaves para acceder a strings
        for ($i = 0; $i < 5; $i++) {
            $text .= $pattern[rand(0, strlen($pattern) - 1)];
        }
        return $text;
    }

    public function mostrar(): void {
        if ($this->nombre === "captcha") {
            $_SESSION['tmptxt'] = $this->randomText();
            $formato = "image/gif";
            
            if (file_exists($this->bgcaptcha)) {
                $thumb = imagecreatefromgif($this->bgcaptcha);
                $colText = imagecolorallocate($thumb, 0, 0, 0);
            } else {
                $thumb = imagecreatetruecolor(80, 30);
                $colText = imagecolorallocate($thumb, 255, 255, 255);
            }
            imagestring($thumb, 5, 16, 7, $_SESSION['tmptxt'], $colText);
            
        } else {
            if ($this->nombre === "icrear") {
                $thumb = imagecreatetruecolor($this->ancho, $this->altmax);
                $formato = "image/png";
                imagerectangle($thumb, 4, 4, $this->ancho - 4, $this->altmax - 4, imagecolorallocate($thumb, $this->background[0], $this->background[1], $this->background[2]));
            } else {
                if (!file_exists($this->nombre)) {
                    http_response_code(404);
                    exit;
                }
                
                $datos = getimagesize($this->nombre);
                $formato = $datos['mime'];
                
                $img = match ($formato) {
                    'image/png' => imagecreatefrompng($this->nombre),
                    'image/gif' => imagecreatefromgif($this->nombre),
                    'image/bmp' => imagecreatefrombmp($this->nombre),
                    default => imagecreatefromjpeg($this->nombre),
                };

                $ancho_orig = $datos[0];
                $alto_orig = $datos[1];
                $x_ratio = $this->ancho / $ancho_orig;
                $y_ratio = $this->altmax / $alto_orig;

                if (($ancho_orig <= $this->ancho) && ($alto_orig <= $this->altmax)) {
                    $ancho_final = $ancho_orig;
                    $alto_final = $alto_orig;
                } elseif (($x_ratio * $alto_orig) < $this->altmax) {
                    $alto_final = (int)ceil($x_ratio * $alto_orig);
                    $ancho_final = $this->ancho;
                } else {
                    $ancho_final = (int)ceil($y_ratio * $ancho_orig);
                    $alto_final = $this->altmax;
                }

                $thumb = imagecreatetruecolor($ancho_final, $alto_final);
                
                if ($formato === "image/png" || $formato === "image/gif") {
                    imagealphablending($thumb, false);
                    imagesavealpha($thumb, true);
                    $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
                    imagefill($thumb, 0, 0, $transparent);
                }

                imagecopyresampled($thumb, $img, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho_orig, $alto_orig);
                imagedestroy($img);
            }

            if ($this->texto !== "") {
                $textcolor = imagecolorallocate($thumb, $this->colorText[0], $this->colorText[1], $this->colorText[2]);
                imagestring($thumb, 5, 20, 20, $this->texto, $textcolor);
            }

            if (isset($_GET["m"]) && file_exists($this->estampa)) {
                $estampa = imagecreatefrompng($this->estampa);
                imagecopy($thumb, $estampa, imagesx($thumb) - imagesx($estampa) - 25, imagesy($thumb) - imagesy($estampa) - 25, 0, 0, imagesx($estampa), imagesy($estampa));
                imagedestroy($estampa);
            }
        }

        // Aplicar Filtros usando Match (PHP 8+)
        if ($this->filtro) {
            match ($this->filtro) {
                1 => imagefilter($thumb, IMG_FILTER_NEGATE),
                2 => imagefilter($thumb, IMG_FILTER_GRAYSCALE),
                3 => imagefilter($thumb, IMG_FILTER_BRIGHTNESS, 80),
                4 => imagefilter($thumb, IMG_FILTER_CONTRAST, 40),
                5 => imagefilter($thumb, IMG_FILTER_COLORIZE, 0, 255, 0, 127),
                6 => imagefilter($thumb, IMG_FILTER_EDGEDETECT),
                7 => imagefilter($thumb, IMG_FILTER_EMBOSS),
                8 => imagefilter($thumb, IMG_FILTER_GAUSSIAN_BLUR),
                9 => imagefilter($thumb, IMG_FILTER_SELECTIVE_BLUR),
                10 => imagefilter($thumb, IMG_FILTER_MEAN_REMOVAL),
                11 => imagefilter($thumb, IMG_FILTER_SMOOTH, 10),
                12 => imagefilter($thumb, IMG_FILTER_PIXELATE, 10, 1),
                default => null,
            };
        }

        // Aplicar Efectos usando Match (PHP 8+)
        if ($this->efecto) {
            match ($this->efecto) {
                1 => imageflip($thumb, IMG_FLIP_VERTICAL),
                2 => imageflip($thumb, IMG_FLIP_HORIZONTAL),
                default => null,
            };
        }

        header("Content-type: " . $formato);
        match ($formato) {
            'image/png' => imagepng($thumb),
            'image/gif' => imagegif($thumb),
            'image/bmp' => imagebmp($thumb),
            default => imagejpeg($thumb, null, 90),
        };

        imagedestroy($thumb);
    }
}

$imagen = new ImageHandler();
$imagen->mostrar();