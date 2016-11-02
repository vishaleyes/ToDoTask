<?php
		include ("config.php");
		define('BASEPATH',"/var/www/html/");

		$supported_languages = array(
			_COMMUNICATION_LANGUAGE_ENGLISH,
			_COMMUNICATION_LANGUAGE_ESPANOL,
			_COMMUNICATION_LANGUAGE_FRENCH,
			_COMMUNICATION_LANGUAGE_PORTUGUESE);
		$supported_languages_names[_COMMUNICATION_LANGUAGE_ENGLISH] = "eng";
		$supported_languages_names[_COMMUNICATION_LANGUAGE_ESPANOL] = "spn";
		$supported_languages_names[_COMMUNICATION_LANGUAGE_FRENCH] = "fr";
		$supported_languages_names[_COMMUNICATION_LANGUAGE_PORTUGUESE] = "prtg";
		echo "<table border=1>";
		foreach ($supported_languages as $lang) {
			$languagePath=BASEPATH."languages/eng/global.php";
			$msgs = include($languagePath);
			echo "<tr>";
			echo "<td>";
			echo count($msgs);
			echo "</td>";
			echo "<td>";
			echo $supported_languages_names[$lang];
			echo "</td>";

			$languagePath=BASEPATH."languages/" . $supported_languages_names[$lang] . "/global.php";
			echo "<td>";
			echo $languagePath;
			echo "</td>";
			$languages[$lang] = include($languagePath);

			echo "<td>";
			echo count($languages[$lang]);
			echo "</td>";

			$common_keys = array_intersect_key( 
						$languages[_COMMUNICATION_LANGUAGE_ENGLISH],
						$languages[$lang]);
			echo "<td>";
			echo "COMMON = ".count($common_keys);
			echo "</td>";

			$common_keys = array_intersect_key( 
						$languages[$lang],
						$languages[_COMMUNICATION_LANGUAGE_ENGLISH]);
			echo "<td>";
			echo "COMMON OTHERWISE = ".count($common_keys);
			echo "</td>";

			$diff_keys = array_diff_key( 
						$languages[_COMMUNICATION_LANGUAGE_ENGLISH],
						$languages[$lang]);
			echo "<td>";
			echo "DIFF = ".count($diff_keys);
			echo "</td>";

			echo "<td>";
			var_dump($diff_keys);
			echo "</td>";

			$diff_keys = array_diff_key( 
						$languages[$lang],
						$languages[_COMMUNICATION_LANGUAGE_ENGLISH]);

			echo "<td>";
			echo "DIFF = ".count($diff_keys);
			echo "</td>";

			echo "<td>";
			var_dump($diff_keys);
			echo "</td>";
	}		
    echo "</tr>";
    echo "</table>";
    echo "<br />";
    echo "<br />";
    echo "<br />";
    echo "<table border=1 style=\"table-layout:fixed;\";>";
    echo "<thead>";
    	echo "<th width=250px>";
    	echo "ID";
    	echo "</th>";
    	echo "<th width=250px>";
    	echo "English";
    	echo "</th>";
    	echo "<th width=250px>";
    	echo "Espanol";
    	echo "</th>";
    	echo "<th width=250px>";
    	echo "French";
    	echo "</th>";
    	echo "<th width=250px>";
    	echo "Portuguese";
    	echo "</th>";
    echo "</thead>";
	foreach ($languages[_COMMUNICATION_LANGUAGE_ENGLISH] as $key => $value) {
    	echo "<tr>";
    	echo "<td style=\"max-width:250px;word-wrap: break-word;\">";
		echo $key;
    	echo "</td>";
    	echo "<td style=\"max-width:250px;word-wrap: break-word;\">";
		echo $languages[_COMMUNICATION_LANGUAGE_ENGLISH][$key];
    	echo "</td>";
    	echo "<td style=\"max-width:250px;word-wrap: break-word;\">";
		echo htmlentities($languages[_COMMUNICATION_LANGUAGE_ESPANOL][$key]);
    	echo "</td>";
    	echo "<td style=\"max-width:250px;word-wrap: break-word;\">";
		echo htmlentities($languages[_COMMUNICATION_LANGUAGE_FRENCH][$key]);
    	echo "</td>";
    	echo "<td style=\"max-width:250px;word-wrap: break-word;\">";
		echo htmlentities($languages[_COMMUNICATION_LANGUAGE_PORTUGUESE][$key]);
    	echo "</td>";
    	echo "</tr>";
	}
    echo "</tr>";
    echo "</table>";

?>
