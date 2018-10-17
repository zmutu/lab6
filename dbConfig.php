<?php
$lokal=0; // hodeian 0, lokalean gauedenean 1

if ($lokal) {
   $zerbitzaria="localhost";
   $erabiltzailea="root";
   $gakoa="5artu";				// GitHub-en eremu hau EZABATU
   $db="quiz";                // hodeiko db izena: hodeiko aurrizkia + zuek adierazitako db izena atzizki moduan
} else {
   $zerbitzaria="localhost";
   $erabiltzailea="idXXXXXXX_zmutu";			// lokalean erabiltzailea root izan ohi da
   $gakoa="pasahitza";									// eta ez da pasahitzarik jartzen//ba ni bazterrak nahasten ibili ondoren pasahitza behar dut
   $db="idXXXXXXX_quiz";
}
%>
