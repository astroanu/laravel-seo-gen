# laravel-seo-gen
SEO friendly meta tags generator for Laravel

### Usage
In the base controller:
````
abstract class Controller extends BaseController {

	protected $metaData;

	public function __construct()
	{
		$this->metaData = new \Astroanu\SEOGen\Data();		
	}

}
````

in the controller set the tag attributes and pass them to the view:

````
$this->metaData->title = 'Welcome';
$this->metaData->description = 'Some demo text here for you to see';
$this->metaData->robots = 'noindex,nofollow';
$this->metaData->image = 'http://www.sample.com/image.jpg';

return view('welcome', ['metaData' => $this->metaData]);
````

in the view render everything:

````
<?php \Astroanu\SEOGen\Renderer::render($metaData); ?>
````