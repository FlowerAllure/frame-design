#!/usr/bin/expect -f
# clean container
set contain_count [exec docker ps -aq | wc -l]
if {$contain_count > 0} {
    puts "There are $contain_count Docker volumes that need to be cleaned up."
    set contain_list [exec docker ps -aq | xargs docker rm -f]
    puts $contain_list
    puts "Cleaning up Docker contains finished."
} else {
    puts "Docker contains are already clean, nothing to do."
}
# clean volume
set volume_count [exec docker volume ls -q | wc -l]
if {$volume_count > 0} {
    puts "There are $volume_count Docker volumes that need to be cleaned up."
    set volume_list [exec docker volume ls -q | xargs docker volume rm]
    puts $volume_list
    puts "Cleaning up Docker volumes finished."
} else {
    puts "Docker volumes are already clean, nothing to do."
}
# clean all free
spawn docker system prune
expect {
    "y/N" {send "y\r";exp_continue;}
}