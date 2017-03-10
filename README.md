# contact_form
A contac form plugin for WonderCMS

To use this form, download and extract the zip file, put the folder 'contact_form' in the plugins folder of your WonderCMS website. You now can use the form in you're website. I used it in the footer of my website.
In this plugin, three new editable area's are created. Infoooter1EditableArea, Infoooter2EditableArea, and Infoooter3EditableArea. You can use them to create a three column footer on you're website	
  
The next code goes in the you're theme php file

<?php
	global $contact_form_email;
	$contact_form_email = "test@test.com";

	$EmbedMap = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1001.1449376151443!2d4.2963146973138455!3d52.099569514478546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5b74d1c0dd2c7%3A0xccfe81afc891bc40!2sMadurodam!5e0!3m2!1snl!2snl!4v1489137876516" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>' 
	?>


	<footer class="container-fluid">
		<div class="container marginTop20">
			<div class="col-xs-12 col-sm-4">
				<div id="contactform" class="grayFont" style="height: 265px;">
         		  	<?php contact_form(); ?>
				</div>
				<div>
					<?=Infoooter1EditableArea()?>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4">
				<div  class="embedmap" style="height: 235px;">
					<?php echo $EmbedMap; ?>
				</div>
    				<div>
					<?=Infoooter2EditableArea()?>
 		 		</div>
			</div>
			<div class="col-xs-12 col-sm-4">
				<div>
					<?=Infoooter3EditableArea()?>
				</div>
			</div>
		</div>
		<div class="text-center">
			<?=wCMS::footer()?><br><br>
		</div>
	</footer>

In you're stylesheet (style.css) of you're theme you should change margin-bottom to a value that can hold you're footer. In my case 400px.
The .embedmap I use to embed a google map or an openstreet map.

body {
	color: #fff;
	background: #eee;
	margin-bottom: 400px;
	font-family: Lucida Sans Unicode, Verdana;
}

.embedmap iframe {border: 1px solid #bac5d6 !important; width: 100%!important; height: 200px!important;}


