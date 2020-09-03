#!/bin/sh

mess=$(last --since=-5min | grep -P 'pts\/\d+' | awk '{print "User " $1 " logged in at " $4, $5, $6, $7 "\n"}')


if [ "$mess" != "" ]
then 
    echo $mess | mail -s "New login" root@localhost
fi