mysqldump -u 'jobtaxi3731' -p'pass373$@1%9A' jobtaxi > jobtaxi.sql
cat jobtaxi.sql | ssh -i .ssh/id_dsa -p 3731 jobtaxi@173.1.156.242 "/bin/bash /home/jobtaxi/import.sh"
