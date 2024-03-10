**EV Charging Stations Web App**

This web application serves as a platform to display a list of electric vehicle charging stations and visualized on a Google Map. Users can easily view the locations of various charging stations and their details.

The app can be run by using Docker.

The API is written in Laravel and has several endpoints, but a more thorough explanation of the API using Swagger can be found upon dockerizing [here](http://localhost:8000/api/documentation).

The front-end has been written in React where the user can see a list of charging stations along with their map location on Google Maps.

A nodejs script has also been implemented and can be manually run from within the "ev-charger-node" folder by running the following command upon dockerizing: `docker exec -it ev-charger-management-nodejs-1 node nodeapp.js`.

The web app is connected to a MySQL database which can be recreated in 2 ways, either by using the `ev_charger.sql` file in the main project folder or by using the Laravel migrations available in the `database/migrations` folder. The first option will also populate the database with some mock data.

Bloopers: I've been wondering why the Google Map was showing a pinpoint in Kyrgyzstan among the US ones, only to find out it wasn't a bug, just a longitude value without the minus before the value. Awesome stuff.
