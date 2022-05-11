cd /var/www/html/console 
grep -wrl 'id_user' ./ | xargs sed -i 's/id_user/id_user/g' 
grep -wrl 'id_user' ./ | xargs sed -i 's/id_user/id_user/g' 
grep -wrl 'id_comando' ./ | xargs sed -i 's/id_comando/id_comando/g' 
grep -wrl 'id_comando' ./ | xargs sed -i 's/id_comando/id_comando/g' 
grep -wrl 'id_user' ./ | xargs sed -i 's/id_user/id_user/g' 
grep -wrl 'id_user' ./ | xargs sed -i 's/id_user/id_user/g' 
grep -wrl 'id_comando' ./ | xargs sed -i 's/id_comando/id_comando/g' 
grep -wrl 'id_comando' ./ | xargs sed -i 's/id_comando/id_comando/g' 

mysql -u adminBD -pF4I6^\$BDC-aEonn9 u733136234_console < /var/www/html/console/API_BD/log_comando.sql