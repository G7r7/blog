<?php

function session () {

          session_start();

                  If (isset($_SESSION['pseudo'])
                        AND isset($_SESSION['id'])
                        AND $_SESSION['pseudo']!=NULL
                        AND $_SESSION['id']!=NULL) {

                                  echo 'Bonjour ' . $_SESSION['pseudo'] . ' !<br />';
                      }

                    }

?>
