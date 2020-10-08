# Installation

Check out the directory in your MediaWiki extension path and add 

	wfLoadExtension( 'OSMCALWikiWidget' );

to your `LocalSettings.php`.

# Usage

The extension registers the `osmcal` tag. The simplest usage is

	<osmcal/>

on a wiki page, which will display all upcoming events, worldwide.

It has three optional parameters:

- `in`: Limits displayed events to a certain country, e.g. `<osmcal in="Germany" />` will display events in Germany.
- `lang`: Sends the given language code to the API, thus formatting the dates in the specified language, e.g. `<osmcal lang="fr" />` will display all upcoming worldwide events, with the dates in French.
- `nobanner`: Doesn't display the "Add to OpenStreetMap Calendar banner" at the bottom, e.g. `<osmcal nobanner />`.
