<?php
$lokal=0; // hodeian 0, lokalean gauedenean 1

if ($lokal) {
   $zerbitzaria="localhost";
   $erabiltzailea="id7270487_zmutu";
   $gakoa="60ra3u5kalH3rr1a";				// GitHub-en eremu hau EZABATU
   $db="id7270487_quiz";						// hodeiko db izena: hodeiko aurrizkia + zuek adierazitako db izena atzizki moduan
} else {
   $zerbitzaria="localhost";
   $erabiltzailea="root";						// lokalean erabiltzailea root izan ohi da
   $gakoa="5artu";									// eta ez da pasahitzarik jartzen
   $db="quiz";
}
%>