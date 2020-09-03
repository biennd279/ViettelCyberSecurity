LOG_FILE="etc.log"
DIR="/etc/"


# Init if not runned
if [ ! -f $LOG_FILE ]
then 
    touch $LOG_FILE
    for _file in $list_file
    do
        echo $(md5sum $_file) >>$LOG_FILE
    done
    exit
fi

list_file=$(find $DIR -type f -perm -o=r  -not -name "$LOG_FILE")
list_file_changed=$(find $DIR -type f -perm -o=r  -cmin -30 -not -name "$LOG_FILE")

#List file create new
echo "======="
echo "List file create new:"
for _file in $list_file
do 
    if [ $(grep -c $_file $LOG_FILE) -eq 0 ]
    then
        echo $_file
        # if [ $(file $_file | grep "ASCII" -c) -ne 0 ] 
        # then 
        #     head -n 10 $_file
        #     echo "\n\n"
        # fi
    fi
done


 #List file change
 echo "======="
echo "List file change:"
for _file in $list_file_changed
do 
    if [ $(grep -c $_file $LOG_FILE) -ne 0 ]
    then 
        old_hash=$(grep $_file $LOG_FILE | cat)
        new_hash=$(md5sum $_file)
        if [ "$old_hash" != "$new_hash"  ]
        then 
            echo $_file
        fi
    fi
done 

#List file deleted
echo "======="
echo "File deleted:"
for _file in $(cat etc.log | awk '{print $2;}')
do
    if [ ! -f $_file ] 
    then
        echo $_file
    fi
done

#Update log
$(truncate -s 0 $LOG_FILE)
for _file in $list_file
do
    echo $(md5sum $_file) >>$LOG_FILE
done
