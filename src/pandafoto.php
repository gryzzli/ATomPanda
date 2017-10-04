<?php


class PandaFoto
{
  function resize2($imgname, $imgname2=NULL, $max2=1024)
   	{
                if($imgname2 == NULL) { $imgname2 = $imgname; }

		if(file_exists($imgname))
		{


			$size = getimagesize($imgname);
			if($max2 != "")
			{
				if($size[0] > $size[1]) { if($max2 < $size[0]) { $width  = $max2; } }
				else                    { if($max2 < $size[1]) { $height = $max2; } }
			}

			if($width == "" && $height == "") { $width  = $size[0]; $height = $size[1]; }
			elseif($width == "") { $width  = round(($height/$size[1])*$size[0], 0);     }

			else                 { $height = round(($width/$size[0]) *$size[1], 0);     }

PandaFS::mkdir(dirname($imgname2));

$thumb=new Imagick($imgname);



//Scale the image
$thumb->thumbnailImage($width,$height);

//Write the new image to a file
$thumb->writeImage($imgname2);
			



//echo "convert -resize ".$width."x".$height." $imgname $imgname2 <br/>";
			// system("convert -resize ".$width."x".$height." $imgname $imgname2");
		}
	}


	var $max       = 1024;
	var $thumbinal = 130;

	function resize($imgname, $imgname2=NULL)
   	{
                if($imgname2 == NULL) { $imgname2 = $imgname; }

		if(file_exists($imgname))
		{
			$size = getimagesize($imgname);
			if($this->max != "")
			{
				if($size[0] > $size[1]) { if($this->max < $size[0]) { $width  = $this->max; } }
				else                    { if($this->max < $size[1]) { $height = $this->max; } }
			}

			if($width == "" && $height == "") { $width  = $size[0]; $height = $size[1]; }
			elseif($width == "") { $width  = round(($height/$size[1])*$size[0], 0);     }
			else                 { $height = round(($width/$size[0]) *$size[1], 0);     }

#$thumb = imagecreatetruecolor($width, $height);
#$source = imagecreatefromjpeg($imgname);

// Resize
#imagecopyresized($thumb, $source, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
#imagejpeg($thumb,$imgname2);

			system("convert -resize ".$width."x".$height." $imgname $imgname2");
		}
	}

	function Thumbinal($imgname, $imgname2)
	{
		if(file_exists($imgname))
		{
			$size = getimagesize($imgname);
			if($this->thumbinal != "")
			{
				if($size[0] > $size[1]) { if($this->thumbinal < $size[0]) { $width  = $this->thumbinal; } }
				else                    { if($this->thumbinal < $size[1]) { $height = $this->thumbinal; } }
			}
			if($width == "" && $height == "") { $width  = $size[0]; $height = $size[1]; }
			elseif($width == "") { $width  = round(($height/$size[1])*$size[0], 0);     }
			else                 { $height = round(($width/$size[0])*$size[1], 0);      }
			
			#$thumb = imagecreatetruecolor($width, $height);
			#$source = imagecreatefromjpeg($imgname);
			
			// Resize
			#imagecopyresized($thumb, $source, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
			#imagejpeg($thumb,$imgname2);
			
			#system("convert -resize ".$width."x".$height." $imgname $imgname2");
                        
			system("convert $imgname -thumbnail ".$width."x".$height."  $imgname2");
		}
	}


	function Description($plik, $podpis, $fontSize=15)
	{
		// system("convert $plik  -fill white  -box '#00000080'  -gravity South -draw \"text 0,5 ' $podpis' \" $plik");

	      $image = new Imagick($plik);

$draw = new ImagickDraw();
/* Black text */
$draw->setFillColor('white');


/* Font properties */
$draw->setFont('Bookman-DemiItalic');
$draw->setFontSize( $fontSize );

$draw->setStrokeColor('#000');
$draw->setStrokeWidth(1);
$draw->setStrokeAntialias(true);
$draw->setTextAntialias(true);

$draw->setFillOpacity(0.7);
$d = $image->getImageGeometry(); 

/* Create text */
$draw->setGravity (Imagick::GRAVITY_SOUTH);
$image->annotateImage($draw, 0, 0, 0, $podpis);


$image->writeImage($plik);


	}
}
