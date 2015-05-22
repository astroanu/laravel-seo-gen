# laravel-seo-gen
SEO friendly meta tags generator for Laravel

### Usage
add the provider to config\app.php:
````
'Astroanu\SEOGen\SEOGenProvider'
````

run php artisan vendor:publish to copy the config file.

````
	'meta' => [
	
		'default_title' => 'My App', // default title for application
		'concat_default_title' => true, // wheatehr to concat the default title with the provided title. if this is true and if a title if provided in the controller the result would be "provided title : My App"
		'concat_with' => ' : ' // the string to concat the titles

	],

	'social' => [

		'og' => [
			'render' => true, // wheather to render facebook og tags or not
			'additional_og_tags' => [] // additinal tags to consider when rendering og tags
		],
		
		'twitter' => [
			'render' => true // wheather to render twitter meta tags or not
		]

	]	
````

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

### Example
````
// config

return 	array(

	'meta' => [
	
		'default_title' => 'My App',
		'concat_default_title' => true,
		'concat_with' => ' : '

	],

	'social' => [

		'og' => [
			'render' => true,
			'additional_og_tags' => ['fb__app_id', 'test_tag']
		],
		
		'twitter' => [
			'render' => true
		]

	]
	
);

// controller

$this->metaData->title = 'Welcome';
$this->metaData->description = 'Some demo text here for you to see';
$this->metaData->robots = 'noindex,nofollow';
$this->metaData->image = 'http://www.sample.com/image.jpg';
$this->metaData->fb__app_id = '456456456456'; // double underscore will be treated as a namespace
$this->metaData->test_tag = 'test text'; // this will still render as a meta tag

return view('welcome', ['metaData' => $this->metaData]);
````
will yeild:

````
<title>Welcome : My App</title>
<meta name="description" content="Some demo text here for you to see" />
<meta name="robots" content="noindex,nofollow" />
<meta name="image" content="http://www.sample.com/image.jpg" />
<meta property="og:title" content="Welcome" />
<meta property="og:description" content="Some demo text here for you to see" />
<meta property="og:image" content="http://www.sample.com/image.jpg" />
<meta property="fb:app_id" content="456456456456" />
<meta property="test_tag" content="test text" />
<meta property="twitter:title" content="Welcome" />
<meta property="twitter:description" content="Some demo text here for you to see" />
<meta property="twitter:image" content="http://www.sample.com/image.jpg" />
````
