<?php namespace Astroanu\SEOGen;

use Illuminate\Support\Facades\Config;

class Renderer {

	public static function render($data)
	{
		if ($data instanceOf Data) {
			$this->renderMetaTags($data);

			if (Config::get('astroanu.seogen.social.og') === true) {
				$this->renderOgTags($data);
			}
		}
	}

	private function renderOgTags($data)
	{
		
	}

	private function renderMetaTags($data)
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
