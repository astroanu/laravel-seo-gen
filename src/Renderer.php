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
				echo '<meta name="twitter:'. $key .'" content="'. $value .'" />';
			}
		}				

		foreach (Config::get('astroanu.seogen.social.twitter.additional_twitter_tags', []) as $value) {
			if (isset($data->getData()[$value])) {
				$parts = explode('__', $value);

				if (count($parts) >= 2) {
					echo '<meta name="twitter:'. str_replace('__', ':', $value) .'" content="'. $data->getData()[$value] .'" />';
				} else{
					echo '<meta name="twitter:'. $value .'" content="'. $data->getData()[$value] .'" />';					
				}
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
			if (in_array($key, ['title', 'type', 'image', 'url', 'description'])) {
				echo '<meta property="og:'. $key .'" content="'. $value .'" />';
			}
		}			

		foreach (Config::get('astroanu.seogen.social.og.additional_og_tags', []) as $value) {
			if (isset($data->getData()[$value])) {
				$parts = explode('__', $value);

				if (count($parts) >= 2) {
					echo '<meta property="'. str_replace('__', ':', $value) .'" content="'. $data->getData()[$value] .'" />';
				} else{
					echo '<meta property="'. $value .'" content="'. $data->getData()[$value] .'" />';					
				}
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

					if (!in_array($key, Config::get('astroanu.seogen.social.og.additional_og_tags', []))) {
						echo '<meta name="' . $key . '" content="'. $value .'" />';						
					}
					break;
			}

		}
	}
}
