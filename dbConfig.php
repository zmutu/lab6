<?php
$lokal=0; // hodeian 0, lokalean gauedenean 1

if ($lokal) {
   $zerbitzaria="localhost";
   $erabiltzailea="idXXXXXXX_zmutu";
   $gakoa="pasahitza";				// GitHub-en eremu hau EZABATU
   $db="idXXXXXXX_quiz";						// hodeiko db izena: hodeiko aurrizkia + zuek adierazitako db izena atzizki moduan
} else {
   $zerbitzaria="localhost";
   $erabiltzailea="root";						// lokalean erabiltzailea root izan ohi da
   $gakoa="5artu";									// eta ez da pasahitzarik jartzen//ba ni bazterrak nahasten ibili ondoren pasahitza behar dut
   $db="quiz";
}
%>
