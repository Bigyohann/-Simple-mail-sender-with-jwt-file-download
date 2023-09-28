# Simple mail sender and file serving with JWT auth 

## Installation 
Copy the .env to a .env.local and edit it to fit your needs

`make up` to start the server

## Usage
Call `/mail` in POST to send mail

Generated mail got a link with a generated JWT passed as a query paramater, route check if jwt is valid and serve file
