<?php namespace Astroanu\SEOGen;

use Illuminate\Support\Facades\Config;

class Renderer {

	public static function render($data)
	{
		if ($data instanceOf Data) {
			self::renderMetaTags($data);

			if (Config::get('astroanu.seogen.social.og.render') === true) {
				self::renderOgTags($data);
			}

			if (Config::get('astroanu.seogen.social.twitter.render') === true) {
				self::renderTwitterTags($data);
			}
		}
	}

	private static function renderTwitterTags($data)
	{
		$validTwitterTags = ['card', 'title', 'image', 'description'];

		foreach ($data->getData() as $key => $value) {
			if (in_array($key, $validTwitterTags)) {
				echo '<meta property="twitter:'. $key .'" content="'. $value .'" />';
			}
		}		
	}

	private static function renderOgTags($data)
	{
		$validOgTags = array_merge(
			['title', 'type', 'image', 'url', 'description'],
			Config::get('astroanu.seogen.social.og.additional_og_tags', [])
		);

		foreach ($data->getData() as $key => $value) {
			if (in_array($key, $validOgTags)) {
				echo '<meta property="og:'. $key .'" content="'. $value .'" />';
			}
		}		
	}

	private static function renderMetaTags($data)
	{
		foreach ($data->getData() as $key => $value) {

			switch ($key) {
				case 'title':
					if (Config::get('astroanu.seogen.meta.concat_default_title') === true) {

						echo '<title>' . $value . Config::get('astroanu.seogen.meta.concat_with') 
						     . Config::get('astroanu.seogen.meta.default_title') . '</title>';
					} else {

						echo '<title>' . $value . '</title>';
					}
					break;
				
				default:
					echo '<meta name="' . $key . '" content="'. $value .'" />';
					break;
			}

		}
	}
}
