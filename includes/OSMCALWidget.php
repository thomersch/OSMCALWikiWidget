<?php

class OSMCALWidget {
	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( 'osmcal', [ self::class, 'renderCalendar' ] );
	}

	public static function renderCalendar( $input, array $args, Parser $parser, PPFrame $frame ) {
		$lang = "";
		if (array_key_exists('lang', $args)) {
			$lang = $args['lang'];
		} else {
			$lang = $parser->getContentLanguage()->getCode();
		}

		$req_params = "";
		if (array_key_exists('in', $args)) {
			$req_params = "?in=".$args['in'];
		}

		$banner = true;
		if (array_key_exists('nobanner', $args)) {
			$banner = false;
		}
    
		// parameter for limiting how many events get shown
		$limit = null;
		if (array_key_exists('limit', $args)) {
			$limit = intval($args['limit']); // Conversion into integer
		}

		// Parameter around=<lat>,<lon>
		if (array_key_exists('around', $args)) {
			$req_params = "?around=".$args['around'];
		}

		$req_opts = [
			"http" => [
				"method" => "GET",
				"header" => "Accept-Language: ".$lang."\r\nClient-App: Wiki Widget"
			]
		];


		$context = stream_context_create($req_opts);
		$api_endpoint = "https://osmcal.org/api/v2/events/";
		$json = file_get_contents($api_endpoint.$req_params, false, $context);

		$obj = json_decode($json);

		$out = '<table class="osmcal-event-table">';
		$counter = 0; // Counter for calendar-entries
		foreach ($obj as $key => $evt) {
			// Check if the calendar-entries-limit is reached
			if ($limit !== null && $counter >= $limit) {
				break;
			}
			$out .= self::renderEvent($evt);
			$counter++; // Increase counter for calendar-entries
		}
		$out .= '</table>';

		if ($banner) {
			global $wgExtensionAssetsPath;

			$out .= '<div class="osmcal-banner"><a href="https://osmcal.org/event/add/"><img src="'. $wgExtensionAssetsPath .'/OSMCALWikiWidget/resources/osmcal-icon.png" alt="OSMCAL Logo" width="24" height="24"> '. wfMessage('osmcal_add_event_link')->inLanguage($lang) .'</div></a>';
		}
		return $out;
	}

	public static function renderEvent( $evt ) : string {
		$out = "<tr>";
		$out .= "<td align='right'>" . $evt->date->human_short . "</td>";
		$out .= "<td><a href='". $evt->url ."'>";
		if (property_exists($evt, 'cancelled') && $evt->cancelled) {
			$out .= "<del>";
		}
		$out .= $evt->name;
		if (property_exists($evt, 'cancelled') && $evt->cancelled) {
			$out .= "</del>";
		}

		$out .= "</a></td>";
		if (property_exists($evt, 'location')) {
			$out .= "<td><small>". $evt->location->short ."</small></td>";
		}
		return $out . "</tr>";
	}
}
