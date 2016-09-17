<?php

# THIS IS FOR THE FAREAST MAP

$yeargroup = [];
$yeargroup[-90] = [0,260];
$yeargroup[260] = [-90,400];
$yeargroup[400] = [260,560];
$yeargroup[560] = [400,750];
$yeargroup[750] = [560,944];
$yeargroup[944] = [750,0];

$nav = '';
$filename = '';
if(isset($_GET['dates']) && $_GET['dates'] != '') {
	$datelist = $_GET['dates'];
	
	$datearray = explode(',',$datelist);
	$sourcePath = '../svg_raw/';
	$targetPath = '../svg/';
	
	$base = fopen($targetPath.'base.svg', "r");
	if (!$base) { $message = 'Could not open file.  Check the spelling of the URI.'; }
	$basetext = fread($base,  filesize($targetPath.'base.svg'));
	fclose($base);

	echo 'datearray length: '.count($datearray).'<br/>';
	
	for ($i=0;$i<count($datearray);$i++) {
		$era = 'CE';
		if ($datearray[$i] < 0) $era = 'BCE';
		$filename = $era.'_'.abs($datearray[$i]);
		echo 'filename: '.$filename.'<br/>';
	
		#chmod($filename, 0777);
	
		$fp = fopen($sourcePath.$filename.'.svg', "r");
		if (!$fp) { $message = 'Could not open file.  Check the spelling of the URI.'; }
	
		$message = "\n".'<text font-weight="700" font-family="\'Myriad Pro\', Arial, sans-serif" fill="#231f20" font-size="200px" color="black" text-anchor="end" transform="translate(850 154)">'.abs($datearray[$i]).'<tspan font-size="72px" x="';
		if ($era == 'BCE') $message .= '150';
		else $message .= '100';
		$message .= '" y="0">'.$era.'</tspan></text>';
		//$message .= '<a xlink:href="../index#'.strtolower($era).abs($datearray[$i]).'">
		$message .= '<a xlink:href="index#thumbnails"><path fill="#4D4D4F" d="M715.2,242.4l-0.2,61.1c0,5.3,4.3,8.4,12.8,9.5v5l-53.4,0.1v-4.9c4.2,0,7.4-0.8,9.7-2.3
		c2.3-1.5,3.4-3.7,3.4-6.5v-41.7c0-5.3-4.3-8.5-13-9.5l0.1-6.2L715.2,242.4z M701.4,204.7c4,0,7.4,1.4,10.1,4.1
		c2.7,2.7,4.1,6.1,4.1,10.2c0,3.9-1.4,7.2-4.1,10c-2.7,2.7-6,4.1-9.8,4.1c-4.2,0-7.6-1.3-10.4-3.8s-4.1-5.8-4.1-9.7
		c0-4.4,1.3-7.9,4-10.7C693.8,206.1,697.2,204.7,701.4,204.7z"/></a>';
		$targetEra = 'CE';
		if ($yeargroup[$datearray[$i]][0] < 0) $targetEra = 'BCE';
		if ($yeargroup[$datearray[$i]][0] != 0) {
			$message .= '<a xlink:href="'.$targetEra.'_'.abs($yeargroup[$datearray[$i]][0]).'.svg"><path color="black" d="M622,206c-11.92,11.92-61.88,65-61.88,65s51.37,52.46,63.81,64.9V208"/></a>';
			}
		$targetEra = 'CE';
		if ($yeargroup[$datearray[$i]][1] < 0) $targetEra = 'BCE';
		if ($yeargroup[$datearray[$i]][1] != 0) {
			$message .= '<a xlink:href="'.$targetEra.'_'.abs($yeargroup[$datearray[$i]][1]).'.svg"><path color="black" d="M781.41,333.92c11.92-11.92,61.88-65,61.88-65s-51.37-51.46-63.81-63.9V331.94"/></a>'."\n";
			}


$message .= <<<eot
<style type="text/css">
	.big { fill: transparent; font-size: 72px; font-family:'Myriad Pro','Helvetica Neue', Helvetica,Arial,sans-serif; cursor: pointer; }
	a:hover > .big { fill:#8B5E3C;  }
	a:hover > .maprange { fill:yellow; }
	.selectors { cursor:pointer; font-family:'Myriad Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:40px; fill:#ccc; font-weight: normal; }
	.selectors:hover { fill:#000; border-radius: 10px; }
	.maprange { fill:#A97C50; stroke:white; }
	.options { fill:#aa896b; stroke:white; }
</style> 
eot;

// do timeline
// starts at 100BCE, so add 100 to each figure
$message .= "\n";
foreach ($yeargroup as $year => $val) {
	$message .= '<a xlink:href="';
	if ($year < 0) $message .= 'BCE_';
	else $message .= 'CE_';
	if ($val[0] == 0) $message .= abs($year).'.svg"><path class="maprange" d="M 2875,0 l 30,0 l 0,'.(($year-$val[0])+100).' l -30,0 z"/><text x="2650" y="100" class="big">&#xA0;&#xA0;'.$year.'</text></a>'."\n";
	else $message .= abs($year).'.svg"><path class="maprange" d="M 2875,'.($val[0]+100).' l 30,0 l 0,'.($year-$val[0]).' l -30,0 z"/><text x="2650" y="'.($year+100).'" class="big">&#xA0;&#xA0;'.$year.'</text></a>'."\n";
	}


	$message .= <<<eot
	<path class="options" d="M 2680,1950 l 215,0 l 0,330 l -215,0 z"/>
	<text transform="translate(2700 2000)" class="selectors" style="fill:#d8d31e;">Options:</text>
	<text transform="translate(2700 2060)" class="selectors" onclick="
	if(document.getElementById('bitmap').style.display!='none'){
	document.getElementById('bitmap').style.display='none';
	document.getElementById('coastlines').style.opacity='1';
	localStorage.schematic = 'yes'; } 
	else {
	document.getElementById('bitmap').style.display='block';
	document.getElementById('coastlines').style.opacity='0.3';
	localStorage.schematic = 'no'; } 
	">Relief map</text>
	<text transform="translate(2700 2120)" class="selectors" onclick="
	var modern_borders = document.getElementById('modern_borders'); 
	if(modern_borders.style.display=='block'){modern_borders.style.display='none';
	localStorage.modernBorders = 'no';} 
	else {modern_borders.style.display='block';
	localStorage.modernBorders = 'yes';}
	">Borders</text>
	<text transform="translate(2700 2180)" class="selectors" onclick="
	var rivercourses = document.getElementById('rivercourses'); 
	var rivernames = document.getElementById('rivernames'); 
	if (rivercourses.style.display=='block'){
		rivercourses.style.display='none';
		rivernames.style.display='none';
		localStorage.rivers = 'no';
		} 
	else {
		rivercourses.style.display='block';
		rivernames.style.display='block';
		localStorage.rivers = 'yes';
		}
	">Rivers</text>
	<text transform="translate(2700 2240)" class="selectors" onclick="
	if(document.getElementById('text').style.display=='none'){
	document.getElementById('modern_text').style.display='none';
	document.getElementById('text').style.display='block';
	localStorage.modernNames = 'no';} 
	else {
	document.getElementById('modern_text').style.display='block';
	document.getElementById('text').style.display='none';
	localStorage.modernNames = 'yes';} 
	if(document.getElementById('cities').style.display=='none'){
	document.getElementById('modern_cities').style.display='none';
	document.getElementById('cities').style.display='block';
	localStorage.modernCities = 'no';} 
	else {
	document.getElementById('modern_cities').style.display='block';
	document.getElementById('cities').style.display='none';
	localStorage.modernCities = 'yes';} 
	">Names</text>
	<script>
	if (localStorage.schematic == 'yes') { 
		document.getElementById('bitmap').style.display='none';
		document.getElementById('coastlines').style.opacity='1';
		}
	if (localStorage.modernBorders == 'yes') { 
		document.getElementById('modern_borders').style.display='block'
		}
	if (localStorage.rivers == 'yes') { 
		document.getElementById('rivercourses').style.display='block'
		document.getElementById('rivernames').style.display='block'
		}
	if (localStorage.modernNames == 'yes') { 
		document.getElementById('modern_text').style.display='block';
		document.getElementById('text').style.display='none';
		document.getElementById('modern_cities').style.display='block';
		document.getElementById('cities').style.display='none';
		}
	</script>
eot;
		$svgtext = fread($fp,  filesize($sourcePath.$filename.'.svg'));
		fclose($fp);
		
		echo 'svgtext length '.strlen($svgtext)."<br/>";
        
        // add the base text
		$svgtext = preg_replace('/\<g id="bitmap"\>[\s]+\<image style="overflow:visible;" width="1968" height="1567" xlink\:href="\.\.\/relief_map\.jpg"[\s]+transform="matrix\(1\.4757 0 0 1\.4757 1\.8006 0\)">[\s]+\<\/image\>[\s]+\<\/g\>/',$basetext,$svgtext);
		echo 'svgtext with base '.strlen($svgtext)."<br/>";
		
		$svgtext = preg_replace('/<text font-weight="700" font-family="\'Myriad Pro\', Arial,(.|\n)+<\/svg>/','</svg>',$svgtext);
		echo 'svgtext length '.strlen($svgtext)."<br/>";
		$newsvgtext = str_replace("'MyriadPro-Regular'","'Myriad Pro',Helvetica,Arial,sans-serif",$svgtext);
		$newsvgtext = str_replace("'MyriadPro-Semibold'","'Myriad Pro',Helvetica,Arial,sans-serif",$newsvgtext);
		$newsvgtext = str_replace("'MyriadPro-Bold'","'Myriad Pro',Helvetica,Arial,sans-serif",$newsvgtext);
		$newsvgtext = str_replace("font-family:'MyriadPro-It';","font-family:'Myriad Pro',Helvetica,Arial,sans-serif; font-style: italic;",$newsvgtext);
		$newsvgtext = str_replace("'ArialMT'","'Myriad Pro',Helvetica,Arial,sans-serif",$newsvgtext);
		
		$newsvgtext = str_replace('</svg>',$message,$newsvgtext)."\n".'</svg>';
		
		echo 'updated svgtext length '.strlen($newsvgtext)."<br/>";
		
		if (is_writable($targetPath.$filename.'.svg')) { echo "is writeable<br/>"; }
		else { echo "NOT WRITEABLE<br/>";  exit; }

		//chmod($filename.'.svg',0777);
		//$fp = fopen($filename.'.svg', "wb");
		//if (!$fp) { $message = 'Could not open file.  Check the spelling of the URI.'; }
		//$numbytes = fwrite($fp, $newsvgtext);
		//if (fwrite($fp, $newsvgtext) === FALSE) {
		//	echo "Cannot write to file ($filename.'.svg')";
		//	exit;
		//	}


		$numbytes = file_put_contents($targetPath.$filename.'.svg', $newsvgtext);
  		echo "Wrote ($numbytes) bytes to file ($targetPath$filename.svg)<br/>";

		//fclose($fp);
        
        
        
        //************** CREATE THE HTML FILE *************
        
		$htmlfp = fopen('../html_raw/'.$filename.'.html', "r");
		if (!$htmlfp) { $message = 'Could not open file.  Check the spelling of the URI.'; }

		$htmltext = fread($htmlfp,  filesize('../html_raw/'.$filename.'.html'));
		fclose($htmlfp);
	
		echo 'htmltext length '.strlen($htmltext)."<br/>";
        
        // add the SVG text
		$htmltext = preg_replace('/<svg><\/svg>/',$newsvgtext,$htmltext);
		$htmltext = preg_replace('/\.\.\/relief_map/','relief_map',$htmltext);
		echo 'htmltext with base '.strlen($htmltext)."<br/>";
		
		$htmltext = preg_replace('/\.svg/','.html',$htmltext);
		echo 'updated htmltext length '.strlen($htmltext)."<br/>";
		
		if (is_writable('../'.$filename.'.html')) { echo "is writeable<br/>"; }
		else { echo "NOT WRITEABLE<br/>";  exit; }


		$numbytes = file_put_contents('../'.$filename.'.html', $htmltext);
  		echo "Wrote ($numbytes) bytes to file ($filename.html)";
		}
	}


?>