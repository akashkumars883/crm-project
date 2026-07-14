<?php
file_put_contents('.env', "\nRAZORPAY_KEY=rzp_test_replace_me\nRAZORPAY_SECRET=replace_me\n", FILE_APPEND);
echo "Added RAZORPAY vars to .env";
