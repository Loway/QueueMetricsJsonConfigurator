Get a complete dump of your QueueMetrics configuration
======================================================

Step 1: Enable your robot account
---------------------------------

QueueMetrics comes with a "robot" user (password is "robot"), that's disabled by default.   
Log in QueueMetrics and enable it or create a new user with ROBOT user class.

Step 2: Configurate the script
------------------------------

Edit ./config/config.php filling it in with your QueueMetrics' details and robot user's credentials.

Step 3: Create your configuration copy!
---------------------------------------

Run the following command:

./queuemetrics-config-read.php > qmconfig

An optional one - Step 4: Copy it into your new machine
-----------------------------------------------------

After have changed the configuration in order to point to your new machine; delete all its configurations (the robot account in use won't be deleted):

./queuemetrics-config-delete.php --force > backup-file

(all the deleted lines will be saved in __backup-file__, just to be on the safe side).

Then write in it your old configuration:

./queuemetrics-config-add.php < qmconfig
