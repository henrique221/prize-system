#!/usr/bin/expect -f

set date [exec date +%d-%m-%Y]
spawn -noecho ssh root@anthlab.com "./ssh.sh"
expect "root@anthlab.com's password: "
exp_send "rique221\r"
interact

spawn mkdir ../dumps

spawn scp root@anthlab.com:~/dump-preston-$date.sql ../dumps/.
expect "root@anthlab.com's password: "
send "rique221\r"
interact

exec mysql -uroot -p preston  < ../dumps/dump-preston-$date.sql
