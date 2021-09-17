echo "STARTING DOCKER LAMP STACK..."
./start.sh
sleep 5

echo "INSTALLING SYMFONY 3.4 WEBSITE SKELETON"
docker exec -i zachL_task_manager composer create-project symfony/website-skeleton:"^3.4" app

echo "CHMODDING 777 so we have access to editing these files"
docker exec -i -w /app zachL_task_manager chmod -R 777 .

echo "COPYING APPLICATION FILES"
cp -rT ./app_files ./app
echo "DONE."

echo "CREATING DB"
docker exec -i -w /app zachL_task_manager ./bin/console doctrine:database:create
docker exec -i -w /app zachL_task_manager ./bin/console doctrine:migrations:migrate
echo "DONE!"

echo "Point your browser to http://localhost to see the Task Manager Demo!"