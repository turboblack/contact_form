<?php
defined('INC_ROOT') || die('Direct access is not allowed.');

wCMS::addListener('css', 'contactfCSS');

function contactfCSS($args) {
	array_push($args[0], '<link rel="stylesheet" href="'.wCMS::url("plugins/contact_form/css/style.css").'" type="text/css">');
	return $args;
}

function contact_form() {
	
					#################################################
					#-----------------------------------------------#
					#  Written By : Thijs Ferket               		#
					#  Website    : www.ferket.net             		#
					#-----------------------------------------------#
					#################################################
					#  Edited and adapted by Herman Adema			#
					#################################################
			 		
					global $contact_form_email;
					$emailadr = $contact_form_email;
					#preg_match("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $GLOBALS['Infoooter1EditableArea'], $matches);#
			 		#$emailadr = print_r($matches[0], true);#

					ini_set('display_errors', 1);
					error_reporting(E_ALL);


					// Config Gedeelte
					$cfg['url'] = "#contactform";		// Url to goto after you have submitted the form
					$cfg['email'] = $emailadr;         // Webmaster E-mail
					$cfg['text'] = TRUE;               // If an error occurs, make text red   ( TRUE is on, FALSE is off )
					$cfg['input'] = TRUE;              // If an error occurs, make border red ( TRUE is on, FALSE is off )
					$cfg['HTML'] = TRUE;               // Een HTML email ( TRUE is on, FALSE is off )
					$cfg['CAPTCHA'] = TRUE;            // CAPTCHA ( TRUE is on, FALSE is off )


					// Don't change anything below here
					// E-mail Checker / Validator
					function checkmail($email)
					{
					    if(preg_match("/(^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,4}$)/i", $email))
					    {
					        return TRUE;
					    }
					    return FALSE;
					}

					$formulier = TRUE;

					    if(isset($_POST['wis']) && ($_SERVER['REQUEST_METHOD'] == "POST"))
					    {
					        foreach($_POST as $key => $value)
					        {
					            unset($value);
					        }
					    }
        
					    if(isset($_POST['verzenden']) && ($_SERVER['REQUEST_METHOD'] == "POST"))
					    {
					        $aFout = array();
        
					        $naam = trim($_POST['naam']);
					        $email = trim($_POST['email']);
					        $onderwerp = trim($_POST['onderwerp']);
					        $bericht = trim($_POST['bericht']);
        
					        if($cfg['CAPTCHA'])
					        {
					            $code = $_POST['code'];
					        }
                
					        if(empty($naam) || (strlen($naam) < 3) || preg_match("/([<>])/i", $naam) )
					        {
					            $aFout[] = "Er is geen naam ingevuld.";
					            unset($naam);
					            $fout['text']['naam'] = TRUE;
					            $fout['input']['naam'] = TRUE;
					        }
					        if(empty($email))
					        {
					            $aFout[] = "Er is geen e-mail adres ingevuld.";
					            unset($email);
					            $fout['text']['email'] = TRUE;
					            $fout['input']['email'] = TRUE;
					        }
					        elseif(checkmail($email) == 0)
					        // Wanneer je PHP 5.2 > gebruikt
					        //elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
					        {
					            $aFout[] = "Er is geen correct e-mail adres ingevuld.";
					            unset($email);
					            $fout['text']['email'] = TRUE;
					            $fout['input']['email'] = TRUE;
					        }
					        if(empty($onderwerp))
					        {
					            $aFout[] = "Er is geen onderwerp ingevuld.";
					            unset($onderwerp);
					            $fout['text']['onderwerp'] = TRUE;
					            $fout['input']['onderwerp'] = TRUE;
					        }
					        if(empty($bericht))
					        {
					            $aFout[] = "Er is geen bericht ingevuld.";
					            unset($bericht);
					            $fout['text']['bericht'] = TRUE;
					            $fout['input']['bericht'] = TRUE;
					        }
					        if($cfg['CAPTCHA'])
					        {
					            if(strtoupper($code) != $_SESSION['captcha_code'])
					            {
					                $aFout[] = "Er is geen correcte code ingevuld.";
					                $fout['text']['code'] = TRUE;
					                $fout['input']['code'] = TRUE;
					            }
					        }
					        if(!$cfg['text'])
					        {
					            unset($fout['text']);
					        }
					        if(!$cfg['input'])
					        {
					            unset($fout['input']);
					        }
					        if(empty( $aFout ))
					        {
					            $formulier = FALSE;
            
					            
					            if($cfg['HTML'])
					            {
					                // Headers
					                $headers = "From: ".$cfg['email']."\r\n"; 
					                $headers .= "Reply-To: \"".$naam."\" <".$email.">\n";
					                $headers .= "Return-Path: Mail-Error <".$cfg['email'].">\n";
					                $headers .= "MIME-Version: 1.0\n";
					                $headers .= "Content-Transfer-Encoding: 8bit\n";
					                $headers .= "Content-type: text/html; charset=iso-8859-1\n";
                
                
					                $bericht = '
					                <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
					                <html>
					                <head>
					                </head>
					            
					                <body>
 					               <br />
					                <b>Naam:</b> '.$naam.'<br />
					                <b>Email:</b> '.$email.'<br />
					                <br />
					                <b>Bericht:</b><br />
					                '.$bericht.'
					                <br />
					                <br />
					                <br />
					                --------------------------------------------------------------------------<br />
					                <b>Datum:</b> '.date("d-m-Y @ H:i:s").'<br />
					                <b>IP:</b> '.$_SERVER['REMOTE_ADDR'].'<br />
					                </body>
					                </html>';
					            }
					            else 
					            {
					                $bericht_wrap = wordwrap ($bericht, 40, "\n", 1);
					                // Headers
					                $headers = "From: \"Contact Formulier\" <".$cfg['email'].">\n"; 
					                $headers .= "MIME-Version: 1.0\n";
					                $headers .= "Content-type: text/plain; charset='iso-8859-1'\n"; 
            
					                // Bericht
					                $message = "Naam: ".$naam."        \n";
					                $message .= "E-mail: ".$email."     \n";
					                $message .= "Bericht:\n".$bericht_wrap."     \n ";
					                $message .= "               \n ";
					                $message .= "Datum: ".date("d-m-Y H:i:s")." \n";
					                $message .= "------------------------------------------------------- \n ";
					                $message .= "IP: ".$_SERVER['REMOTE_ADDR']."                    \n ";
					                $message .= "Host: ".gethostbyaddr($_SERVER['REMOTE_ADDR'])."                \n ";
					            
					            }
        
					            if(mail($cfg['email'], "[Contactformulier] ".$onderwerp, $bericht, $headers)) 
					            {
					                $headers = "From: ".$cfg['email']."\r\n"; 
					                $headers .= "Reply-To: \"".$cfg['email']."\" <".$cfg['email'].">\n";
					                $headers .= "Return-Path: Mail-Error <".$email.">\n";
					                $headers .= "MIME-Version: 1.0\n";
					                $headers .= "Content-Transfer-Encoding: 8bit\n";
					                $headers .= "Content-type: text/html; charset=iso-8859-1\n";
                    
					                mail($email, "[Contactformulier] ".$onderwerp, $bericht, $headers);
                
                
					                unset($naam, $email, $onderwerp, $bericht);
        
					                echo "
					                <p>
					                Uw bericht is succesvol verzonden, er wordt zo snel mogelijk gereageerd.<br />
					                </p>
					                ";    
					            }
					            else
					            {
					                echo "Er is een fout opgetreden bij het verzenden van de email";
					            }
					        }
							echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $cfg['url'] . '">';
					    }
					    if($formulier)
					    {
					    echo "<div id='containerform'>";   
					    if(isset($errors)) {
					        echo $errors;
					    }

					        echo "<form method='post' action='" . $_SERVER['PHP_SELF']. "'>";
					        echo "<p>";
					        echo "<input type='text' placeholder='Name' id='naam' name='naam' maxlength='30'";
                              if(isset($fout['input']['naam'])) { echo "class='fout'"; } echo "value='";
                              if (!empty($naam)) { echo "stripslashes($naam)";	} echo "' /><br />";
        
					        echo "<input type='text' placeholder='E-Mail' id='email' name='email' maxlength='255'";
                              if(isset($fout['input']['email'])) { echo "class='fout'"; } echo "value='";
                              if (!empty($email)) { echo "stripslashes($email)"; } echo "' /><br />";
        
					        echo "<input type='text' placeholder='Subject' id='onderwerp' name='onderwerp' maxlength='40'";
                              if(isset($fout['input']['onderwerp'])) { echo "class='fout'"; } echo "value='";
                              if (!empty($onderwerp)) { echo "stripslashes($onderwerp)"; } echo "' /><br />";
        
					        echo "<textarea placeholder='Message' id='bericht' name='bericht'";
                              if(isset($fout['input']['bericht'])) { echo "class='fout'"; } echo " cols='31' rows='10'>";
                              if (!empty($bericht)) { echo "stripslashes($bericht)"; } echo "</textarea><br />";

					        if($cfg['CAPTCHA'])
					        {
					        echo "<img src=\"" . wCMS::url('plugins/contact_form/captcha/captcha.php') . "\" alt='' /><br />";
        
					        echo "<input type='text' placeholder='Code' id='code' name='code' maxlength='4' size='4'";
                              if(isset($fout['input']['code'])) { echo "class='captcha fout'"; } echo " /><br />";
					        }
        
					        echo "<input type='submit' id='verzenden' name='verzenden' value='Submit' />";
					        echo "<input type='submit' id='wis' name='wis' value='Reset' />";
					        echo "</p>";
						  echo "</form>";
					    echo "</div>";
			        
					    }
}

function Infoooter1EditableArea() {
    // Check if the anotherEditableArea area is already exists, if not, create it.
    if (wCMS::getConfig('Infoooter1EditableArea') === false) {
        wCMS::setConfig('Infoooter1EditableArea', '<h4>Another subside!</h4><p>This is an example of another editable subside area.</p>');
    }

    // Fetch the value of anotherEditableArea from the database.
    $value = wCMS::getConfig('Infoooter1EditableArea');
    // If value is empty, let's put something in it by default. (IMPORTANT)
    if (empty($value)) {
        $value = 'Empty content.';
    }
    // It's necessary to pass the editable method to the fetched value/content
    // to make the area editable ONLY if admin is logged in.
    if (wCMS::$loggedIn) {
        // If logged in, it must be editable
        return wCMS::editable('Infoooter1EditableArea', $value);
    }
    // If not logged in, don't make it editable!
    return $value;
}


function Infoooter2EditableArea() {
    // Check if the anotherEditableArea area is already exists, if not, create it.
    if (wCMS::getConfig('Infoooter2EditableArea') === false) {
        wCMS::setConfig('Infoooter2EditableArea', '<h4>Another subside!</h4><p>This is an example of another editable subside area.</p>');
    }

    // Fetch the value of anotherEditableArea from the database.
    $value = wCMS::getConfig('Infoooter2EditableArea');
    // If value is empty, let's put something in it by default. (IMPORTANT)
    if (empty($value)) {
        $value = 'Empty content.';
    }
    // It's necessary to pass the editable method to the fetched value/content
    // to make the area editable ONLY if admin is logged in.
    if (wCMS::$loggedIn) {
        // If logged in, it must be editable
        return wCMS::editable('Infoooter2EditableArea', $value);
    }
    // If not logged in, don't make it editable!
    return $value;
}

function Infoooter3EditableArea() {
    // Check if the anotherEditableArea area is already exists, if not, create it.
    if (wCMS::getConfig('Infoooter3EditableArea') === false) {
        wCMS::setConfig('Infoooter3EditableArea', '<h4>Another subside!</h4><p>This is an example of another editable subside area.</p>');
    }

    // Fetch the value of anotherEditableArea from the database.
    $value = wCMS::getConfig('Infoooter3EditableArea');
    // If value is empty, let's put something in it by default. (IMPORTANT)
    if (empty($value)) {
        $value = 'Empty content.';
    }
    // It's necessary to pass the editable method to the fetched value/content
    // to make the area editable ONLY if admin is logged in.
    if (wCMS::$loggedIn) {
        // If logged in, it must be editable
        return wCMS::editable('Infoooter3EditableArea', $value);
    }
    // If not logged in, don't make it editable!
    return $value;
}
