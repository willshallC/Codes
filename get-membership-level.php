<?php

/*=======================================================
=            Get Current User Membership Lvl            =
=======================================================*/

function getMembership() {

  if(is_user_logged_in() && function_exists('pmpro_hasMembershipLevel') && pmpro_hasMembershipLevel()) {

    global $current_user;
    $current_user->membership_level = pmpro_getMembershipLevelForUser($current_user->ID);
    return $current_user->membership_level;


  } else {
    return false;
  }

}

?>