#!/bin/sh

last_ssh_pid=$(ps -u sshd | sed '1d' | awk '{print $1;}' | sort | tail -n 1)

if [ -n "$last_ssh_pid"  ] 
then 
    echo $last_ssh_pid
else 
    exit 1
fi 


sshd_strace=$(sudo strace -p $last_ssh_pid -e trace=write 2>&1)

success_login=$(echo "$sshd_strace" | grep -o "exited with 0")

if [ -n "$success_login" ]
then 
    echo "Login Success"
else
    exit 1
fi 


function=$(echo "$sshd_strace" | tail -n 6 | head -n 1)


echo "$function"