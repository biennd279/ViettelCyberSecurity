#!/bin/sh


hostname=$(uname --nodename)
distribution=$(cat /etc/*-release | grep -oP "DISTRIB_ID=\K\w+")
CPU_name=$(sudo lshw -C CPU | grep -oP "product:\K.*")
CPU_width=$(sudo lshw -C CPU | grep -oP "width:\K.*")
total_mem=$(grep -oP "MemTotal:\s+\K.+" /proc/meminfo)
available_space=$(df -h / | sed '1d' | awk '{print $4;}')
list_ip=$(hostname --ip-address)
list_user=$(getent passwd | cut -d: -f1 | sort | tr '\n' ' ')
list_process_as_root=$(ps --user=root | sed '1d' | awk '{print $4;}' | sort | tr '\n' ' ')
list_port=$(lsof -i | grep -Po "$(hostname):\K\d+" | sort | tr '\n' ' ')
list_folder_edit_other=$(find / -type d -perm -o+w 2> /dev/null)
list_package=$(dpkg-query -f '${Package}:${Version} ' -W)


echo "[Thong tin he thong]\n"

echo "Hostname : $hostname"
echo "Distribution: $distribution"
echo "CPU infomation: $CPU_name $CPU_width"
echo "Total memory: $total_mem"
echo "Total space: $available_space"
echo "List IP of System: $list_ip"
echo "List user: $list_user"
echo "List process runing as root: $list_process_as_root"
echo "list port opening: $list_port"
echo "All folder can edit by other: $list_folder_edit_other"
echo "List package: $list_package"