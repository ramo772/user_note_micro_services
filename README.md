# Note Managment and Auth User Microservices

# Getting started

## Installation

Clone the repository

    git clone https://github.com/ramo772/user_note_micro_services

Switch to the auth-user repo folder

    cd auth-user

Build the Docker images

    docker-compose build

Run the application:

    docker-compose up

NAvigate to the src folder

    cd src

Install all the dependencies

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Update the RabbitMQ configuration

    RABBITMQ_HOST=
    RABBITMQ_PORT=
    RABBITMQ_USER=
    RABBITMQ_PASSWORD=
    RABBITMQ_VHOST=

Run the database migrations at the application shell in the docker(**auth-user-micro-service**)

    php artisan migrate

Repeat the above steps at the note-management-micro-service

# Overview

This application uses two microservices. The first, called auth-user, manages user registration and login. Upon these events, it dispatches a job and communicates them through RabbitMQ. The second microservice handles note management, listening for events from auth-user through RabbitMQ. It performs CRUD operations related to note management. This design promotes modularity and scalability, allowing each microservice to handle its tasks independently while communicating seamlessly through RabbitMQ.
