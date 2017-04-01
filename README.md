# A contact form plugin for WonderCMS

## 1. To use this form, download and extract the zip file, put the folder 'contact_form' in the plugins folder of your WonderCMS website. 
  
## 2. Put the code below in your theme.php, where you want to show the contact form.


```
	<?php
		global $contact_form_email;
		$contact_form_email = "your.email@gmail.com";
	?>

	<div class="container marginTop20">
		<div class="col-xs-12 col-md-6 col-md-offset-3">
			<div id="contactform" class="grayFont" style="height: 265px;">
         		  	<?php contact_form(); ?>
			</div>
		</div>
	</div>
```



## Need to show the contact form only on a specfic page?
 - change 'the name of the page' in the code below and put in your theme.php

```
<?php if (wCMS::$_currentPage == 'the name of the page'): ?>
	<?php
		global $contact_form_email;
		$contact_form_email = "your.email@example.com";
	?>

	<div class="container marginTop20">
		<div class="col-xs-12 col-md-6 col-md-offset-3">
			<div id="contactform" class="grayFont" style="height: 265px;">
         		  	<?php contact_form(); ?>
			</div>
		</div>
	</div>
<?php endif ?>
```
