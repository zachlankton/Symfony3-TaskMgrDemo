docker kill zachL_task_manager
docker rm zachL_task_manager
docker run -d --name zachL_task_manager -p "80:80" -v ${PWD}/app:/app -v ${PWD}/mysql:/var/lib/mysql mattrayner/lamp:latest