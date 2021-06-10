#!/bin/bash

migration() {
	docker exec -i -t -w /var/www  app_php php artisan migrate
}

start_containers() {
	docker-compose up -d
}

build_app() {
	docker-compose build
}

db_health_check() {
	while ! docker exec app_db mysql --user=lumen --password=secret -e "SELECT 1" >/dev/null 2>&1; do
	    sleep 1
	done
	# delay to give some time for db sync
	sleep 5
}

setup_lumen() {
	if [ ! -e ".env" ]; then
		cp .env.example .env
	fi
	composer install
}

if [ "$1" == "sleep3" ]
then
	echo "done sleep"
fi


if [ "$1" == "setup" ]
then
	echo ""
	echo -e "\033[93m======== BUILDING IMAGES ========\033[0m"
	build_app

	echo ""
	echo -e "\033[93m======== SETUP LUMEN ========\033[0m"
	cd lumen
	setup_lumen
	cd ..

	echo ""
	echo -e "\033[93m======== STARTING CONTAINERS ========\033[0m"
	start_containers

	echo ""
	echo -e "\033[93m======== RUNNING MIGRATIONS ========\033[0m"
	db_health_check
	migration

	echo ""
	echo -e "\033[93m======== LISTING CONTAINERS ========\033[0m"
	docker ps
fi

if [ "$1" == "build" ]
then
	build_app
fi

if [ "$1" == "up" ]
then
	start_containers
	docker ps
fi

if [ "$1" == "down" ]
then
	docker-compose down
fi

if [ "$1" == "test" ]
then
	docker exec -i -t -w /var/www  app_php  vendor/bin/phpunit
fi


if [ "$1" == "import-customers" ]
then
	docker exec -i -t -w /var/www  app_php php artisan import:customer
fi
