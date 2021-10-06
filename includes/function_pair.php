<?php

function pair($number)
  {
    $numberf=str_replace(".",",",$number);
  if (fmod($number,2)==0)
    {
      echo "Le nombre $numberf est pair.";
    }
  elseif (fmod($number,2)==1 OR fmod($number,2)==-1)
    {
      echo "Le nombre $numberf est impair.";
    }
  else
    {
      echo "Le nombre $numberf n'est ni pair ni impair.";
    }
    echo "<br/>";
  }
?>
