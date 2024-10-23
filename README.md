# Installation

Check out the directory in your MediaWiki extension path and add 

	wfLoadExtension( 'OSMCALWikiWidget' );

to your `LocalSettings.php`.

# Usage

The extension registers the `osmcal` tag. The simplest usage is

	<osmcal/>

on a wiki page, which will display all upcoming events, worldwide.

It has three optional parameters:

- `in`: Limits displayed events to a certain country, e.g. `<osmcal in="de" />` will display events in Germany.
- `limit`: Limits displayed events to a certain count, e.g. `<osmcal limit="3" />` will display the next 3 events.
- `lang`: Sends the given language code to the API, thus formatting the dates in the specified language, e.g. `<osmcal lang="fr" />` will display all upcoming worldwide events, with the dates in French.
- `nobanner`: Doesn't display the "Add to OpenStreetMap Calendar banner" at the bottom, e.g. `<osmcal nobanner />`.
- `around`: Specify the centerpoint of the area of which events should be displayed. A hardcoded radius of 50km is queried. The format of the parameter is "<lat>,<lon>".