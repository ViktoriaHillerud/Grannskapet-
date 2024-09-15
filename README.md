# Grannskapet-
*Grannskapet* is a neighborhood community application built using PHP and MySQL. The app allows users to join neighborhood groups, communicate through messages, report incidents, and participate in local events. Each user can belong to multiple neighborhood groups, send and receive messages, report incidents, and join events that are associated with those groups.

### Key Features:
- User Registration and Login: Users can create accounts, log in securely, and access their neighborhood groups.
- Neighborhood Groups: Users can join multiple neighborhood groups and see the messages, events, and incidents reported in those groups.
- Messaging System: Users can send and view messages within their neighborhood groups.
- Incident Reporting: Users can report incidents (e.g., safety concerns) in their neighborhood groups.
- Event Participation: Users can view and join local events organized within their groups.

The application uses a many-to-many relational structure for managing users' relationships with neighborhood groups, events, and messages, ensuring that users can interact effectively within their communities.

## Techniques
- PHP, with PDO
- MySQL(MariaDb)
- Docker

## Setup and instructions

This is a local environment used with Docker (using Docker Desktop: [Get it here] https://www.docker.com/products/docker-desktop/), with settings in the Dockerfile and docker-compose.yml. Docker desktop, Composer and the PHP instance is needed.

Run de container in Docker using docker-compose up Navigate to localhost:8080 to login to adminer. The database and tables should be set up correctly now. Register or login and enjoy!