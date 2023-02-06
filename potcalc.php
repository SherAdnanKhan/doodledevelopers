<?php



$jackpot_target=$_POST['jackpot_target'];
$end_pot_value=$_POST['end_pot_value'];
$number_of_players=$_POST['number_of_players'];

// vars
$admin_fee_percent=30;
$remaining_pot_percent=70;
$admin_pot_value=0; // initalise.
$multi_pay_limit=((50/100)*$jackpot_target)+$jackpot_target; // jackpot target + 40% - used to decide if we hit multi-pay game or not
$remaining_pot=0;

echo "### MULTI-PAY GAME LIMIT IS: £$multi_pay_limit<br><br>";

// Create Winners Array Ready
$i=1;
$winners=array();
while($i <= $number_of_players) {
    //echo "Creating winner: $i<br>";
    $winners[$i] = 0;
    $i++;
}

// if the pot is less than or equal to the jackpot target at game end
if($end_pot_value <= $jackpot_target) {
    echo "# Pot is less than or equal to jackpot target<br>";
    echo "# !! THIS IS A SINGLE PAY GAME<br>";
    // admin fee of 30% is taken
    $admin_pot_value=($admin_fee_percent/100)*$end_pot_value;
    $remaining_pot=$end_pot_value-$admin_pot_value;
    // player 1 only receives the remaining 70% of the jackpot target
    $winners[1] = $remaining_pot;
    // check we don't have any half points - re-issue them to the admin_pot
    if(is_float($winners[1]) ==  TRUE) {
        // there is 1 winner so get the remainder and add it to the admin_pot using modulus
        $remainder = $winners[1] - floor($winners[1]);
        $admin_pot_value = $admin_pot_value+$remainder;
        // take the remainder off
        $winners[1] = floor($winners[1]);

    }

} else if($end_pot_value <= $multi_pay_limit) {
    // pot is more than the jackpot but less than multi pay 
    //
    // NOTE - We could try and pay players 2-3 something here.
    //
    echo "# Pot is more than jackpot but less than multi pay limit (jackpot+50% or £$multi_pay_limit)<br>";
    // admin fee of 30% is taken
    $admin_pot_value=($admin_fee_percent/100)*$end_pot_value;
    $remaining_pot=$end_pot_value-$admin_pot_value;
    echo "REMAINING POT after admin fee: $remaining_pot<br>";

    // is there enough to pay player 1 the full jackpot?
    if($remaining_pot >= $jackpot_target) {
            // Yes - Pay player 1 their jackpot
            echo "# After admin fee - there is enough left to pay player 1 the full jackpot<br>";
            $winners[1] = $jackpot_target;
            $remaining_pot=$remaining_pot-$jackpot_target;
    } else {
        // no - so just pay player the rest of the pot
        echo "# There is not enough left in the pot after the admin fee to pay player 1 the full jackpot so giving them all the remainder of the pot (£$remaining_pot)<br>";
        $winners[1] = $remaining_pot;
            // check we don't have any half points - re-issue them to the admin_pot
            if(is_float($winners[1]) ==  TRUE) {
                // there is 1 winner so get the remainder and add it to the admin_pot
                $remainder = $winners[1] - floor($winners[1]);
                $admin_pot_value = $admin_pot_value+$remainder;
                // take the remainder off
                $winners[1] = floor($winners[1]);

            }
        $remaining_pot=$remaining_pot-$remaining_pot;
    }

    // if there is anything left over, split it between players 2 and 3
    echo "REMAINING POT 2: $remaining_pot<br>";
    if($remaining_pot >= 2) {
        echo "# !! After paying player 1 the jackpot of: £$jackpot_target - there is £$remaining_pot left over<br>";
        echo "# !! THIS IS NOW A TRIPPLE-PAY GAME !!<br>";
        echo "# Splitting £$remaining_pot between players 1 and 2<br>";
        $winners[2] = $remaining_pot/2; 
        $winners[3] = $remaining_pot/2;
        $remaining_pot=0;

        // check we don't have any half points - re-issue them to the admin_pot
        if(is_float($winners[2]) ==  TRUE) {
            // round down player 2
            $remainder = $winners[1] - floor($winners[1]);
            $admin_pot_value = $admin_pot_value+$remainder;
            // round down player 3
            $remainder = $winners[2] - floor($winners[2]);
            $admin_pot_value = $admin_pot_value+$remainder;

            // 
            // take the remainder off
            $winners[1] = floor($winners[1]);
            $winners[2] = floor($winners[2]);

        }
    }
    
} else if($end_pot_value >= $multi_pay_limit) {
        // if the pot is equal to or greater than 40% of the jackpot target multi-pay kicks in
            echo "# Pot is 50% or more of jackpot target <br>";
            echo "# !! This is now a multi-pay game !!<br>";
            // admin fee of 30% is taken
            $admin_pot_value=($admin_fee_percent/100)*$end_pot_value;
            $remaining_pot=$end_pot_value-$admin_pot_value;

            //
            // Check for MEGA PAY GAME
            //
           // if 20% of the runner up pot is greater than player 1's payout we distribute the entire pot based on percentage
                    // QUESTION - should we just re-distribute the larger amount of wealth? i.e. up player 1?
                   // echo "20% of remaining pot is: ".((20/100)*$remaining_pot)."<br>";
            if(((20/100)*$remaining_pot) >= $jackpot_target) {
                    echo "# The pot value was so high that player 2's pay out would be more than player 1's jackpot<br>";
                    echo "# !! This is now a MEGA-PAY GAME<br>";
                    echo "# Throwing the jackpot out the window and allocating 25% of the pot to player1<br>";
                     // player 1 receives 25% of pot
                     $winners[1]=(25/100)*$remaining_pot;
                     $remaining_pot=$remaining_pot-$winners[1];

                      // check we don't have any half points - re-issue them to the admin_pot
                        if(is_float($winners[1]) ==  TRUE) {
                            // round down player 1
                            $remainder = $winners[1] - floor($winners[1]);
                            $admin_pot_value = $admin_pot_value+$remainder;

                            // take the remainder off
                            $winners[1] = floor($winners[1]);
                        }

                      // take 50% of the runner up pot and allocate to players 2-5
                      $top_5_pot=(50/100)*$remaining_pot;
                      $remaining_pot=$remaining_pot-$top_5_pot;
                          // player 2 = 20%
                          $winners[2]=(40/100)*$top_5_pot;
                          // player 3 = 15%
                          $winners[3]=(30/100)*$top_5_pot;
                          // player 4 = 10%
                          $winners[4]=(20/100)*$top_5_pot;
                          // player 5 = 5%
                          $winners[5]=(10/100)*$top_5_pot;

                                   // loop through players 2-5 and check they don't have a half point.
                                   $i=2;
                                   while($i <= 5) {
                                      
                                       // check we don't have any half points - re-issue them to the admin_pot
                                       if(is_float($winners[$i]) ==  TRUE) {
                                           // round down player $i
                                           $remainder = $winners[$i] - floor($winners[$i]);
                                           $admin_pot_value = $admin_pot_value+$remainder;
                                           //echo "Half point found for player $i - Adding $remainder to admin pot (now $admin_pot_value)<br>";
   
                                           
                                           // take the remainder off
                                           $winners[$i] = floor($winners[$i]);
   
                                           $i++;
                                       }
                                   }

                        // split the rest of the pot between every other player
                        // take the remaining pot and split it between the next 25 players.
                        if($number_of_players > 30) {
                            // if there is more than 30 players. cap payouts to 1st 30.
                            $i=6;
                            while($i <= 30) {
                                
                                $winners[$i]=$remaining_pot/30;
                                   // check we don't have any half points - re-issue them to the admin_pot
                                   if(is_float($winners[$i]) ==  TRUE) {
                                        // round down player $i
                                        $remainder = $winners[$i] - floor($winners[$i]);
                                        $admin_pot_value = $admin_pot_value+$remainder;
                                        
                                        // take the remainder off
                                        $winners[$i] = floor($winners[$i]);
                                    }
                                $i++;
                            }
                        } else {
                            // if there is less than 30 - split it between them all.
                             $i=6;
                            while($i <= $number_of_players) {
                                
                                $winners[$i]=$remaining_pot/$number_of_players;
                                 // check we don't have any half points - re-issue them to the admin_pot
                                 if(is_float($winners[$i]) ==  TRUE) {
                                    // round down player $i
                                    $remainder = $winners[$i] - floor($winners[$i]);
                                    $admin_pot_value = $admin_pot_value+$remainder;
                                    
                                    // take the remainder off
                                    $winners[$i] = floor($winners[$i]);
                                }
                                $i++;
                            }
                        }
                        

            } else {
                // This is a normal MULTI PAY GAME
                 // player 1 receives the jackpot target
                 echo "TEST: MULTIPAY GAME CLAUSE<BR>";
                $winners[1]=$jackpot_target;
                $remaining_pot=$remaining_pot-$jackpot_target;
                echo "REMAINING POT: $remaining_pot<br>";
                            // take 50% of the runner up pot and allocate to players 2-5
                            $top_5_pot=(50/100)*$remaining_pot;
                            echo "SPLITTING 50% of the remaining pot ($remaining_pot) between playes 2-5 ($top_5_pot)<br>";
                            $remaining_pot=$remaining_pot-$top_5_pot;
                                // player 2 = 20%
                                $winners[2]=(40/100)*$top_5_pot;
                                // player 3 = 15%
                                $winners[3]=(30/100)*$top_5_pot;
                                // player 4 = 10%
                                $winners[4]=(20/100)*$top_5_pot;
                                // player 5 = 5%
                                $winners[5]=(10/100)*$top_5_pot;
                            
                                // loop through players 2-5 and check they don't have a half point.
                                
                                $i=2;
                                while($i <= 5) {
                                   
                                    // check we don't have any half points - re-issue them to the admin_pot
                                    if(is_float($winners[$i]) ==  TRUE) {
                                        // round down player $i
                                        $remainder = $winners[$i] - floor($winners[$i]);
                                        $admin_pot_value = $admin_pot_value+$remainder;
                                        //echo "Half point found for player $i - Adding $remainder to admin pot (now $admin_pot_value)<br>";

                                        
                                        // take the remainder off
                                        $winners[$i] = floor($winners[$i]);

                                        $i++;
                                    }
                                }
                                

                            // take the remaining 50% and split it between the next 25 players.
                            echo "REMAINING POT IS NOW: $remaining_pot<br>";
                            $i=6;
                            while($i <= 30) {
                                // TODO: Insert rule for checking for decimals and rounding down
                                $winners[$i]=$remaining_pot/25;
                                //echo "JAMIE1 - ISSUING $winners[$i] to next 25<br>";
                                // check for half points
                                //echo "JAMIE: $winners[$i]";
                                if(is_float($winners[$i]) ==  TRUE) {
                                  
                                    // round down player $i
                                    $remainder = $winners[$i] - floor($winners[$i]);
                                    $admin_pot_value = $admin_pot_value+$remainder;
                                   // echo "Half point found for player $i - Adding $remainder to admin pot (now $admin_pot_value)<br>";
                                    
                                    // take the remainder off
                                    $winners[$i] = floor($winners[$i]);
                                }
                                $i++;
                            }
            }

            
           
                        // QUESTION! WHAT IF THERE ARE ONLY 5 players??

}

echo "*******************************<br>";
echo "Jackpot Target: £$jackpot_target <br>";
echo "Pot Value: £$end_pot_value      <br>";
echo "Admin fee: £$admin_pot_value   <br>";
echo "*******************************<br>";

echo "##### WINNERS #####<br>";

foreach($winners as $player => $prize) {
    echo "Player $player - $prize<br>";
}
