# Installation
Run `make build` in order to install all application dependencies (you must have Docker installed). Please note the installation process **will not populate the tables**, it only creates the database schema.

For more commands, type `make help`

# Basic usage

Once project is downloaded, we will execute:
- `make start`, to start the container.
- `make stop`, to stop the container.
- `make shell`, to use the interactive shell.

# How to use this app
This app allows creating and searching Authors or Books via REST-API.

Go to the `{PROJECT_FOLDER}/docs/endpoints/items.http` file, and you'll find some prepared requests.
- If you are using `phpStorm`, the IDE will show a `Run all requests` option when opening the said file.
- If you prefer going with another HTTP client (like Postman or a web-browser), the file contains all the necessary information to help you to create your own requests.

## What about testing?
Simply execute `make test` to run all unit and integration tests. Please note this command needs the app to be turned on.

# About the project structure...
Since the technical test is very detailed, I created an API REST with all the required endpoints (including a `POST` request to create Authors! Not asked but it helped me A LOT when coding).

I used Symfony as framework but in a decoupled way: you'll find all the framework data in its own folder (`apps/BookCatalogApi/`), and I chose `Messenger` as a bus in order to connect the Symfony controllers and the `src` folder.

As for the `src` folder, I decided to create two different contexts:
- `Shared`: here I placed all the repetitive classes that are used in the other contexts (e.g., primitive Value Objects, Collections...)
- `BookCatalog`: here you'll find all the code relative to the exercise separated by the three layers (Application, Domain, Infrastructure).
  
# Behind the scenes
I liked how the exercise is presented: it goes straight to the point and gives you total freedom to write the code you think it could fit better.

However, while coding I had some ideas that (unfortunately) I could not implement, mostly due to the lack of time. Let's present my TODO-LIST:
- `Fixtures`: My idea was to populate the database in the installation process :(  (at least the migrations are executed!)
- `Doctrine`: I am using the old-and-reliable DBAL approach in the Infrastructure layer instead of Doctrine. I started using Doctrine, but a bunch of problems appeared and I decided to switch to DBAL in order to avoid delaying the delivery date.
- `A better README`
  
Now, let's talk about the PROUD-LIST (things that I enjoyed coding in this app):
- `Domain exceptions mapped to HTTP Exceptions`: When a Domain exception is thrown, the Controller is capable to identify it and associate to a specific HTTP error-code (for example, `BookNotFoundException` matches with a `404 NOT FOUND`)
- `Gzip compression`: All the data is compressed on-the-fly by the webserver and decompressed by the client when received. The work is managed entirely by `Nginx` so the code remains 100%  agnostic. It's very handy and I think it can improve the server response even with slow connections.
