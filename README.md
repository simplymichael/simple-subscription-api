# Simple Subscription
A simple RESTful API subscription platform which allows users to subscribe to a website.
Whenever a new post is published on a particular website,
all it's subscribers receive an email with the post title and description in it.


## How to run
### Pre-requisites

### 1. Configure MySQL database
- Ensure you have a MySQL database up and running.
- Create a MySQL database using the command `CREATE DATABASE <database_name>`.
- Copy `.env.example` to `.env`.
- Update the database environment variable definitions as follows:
  ```bash
  DB_CONNECTION=mysql
  DB_HOST=<mysql_host>
  DB_PORT=<mysql_port>
  DB_DATABASE=<database_name>
  DB_USERNAME=<mysql_username>
  DB_PASSWORD=<mysql_user_password>
  ```

### 2. Configure Email
- Update the email sending environment variable defintiions as follows:
  ```bash
  MAIL_MAILER=<mail_mailer_value>
  MAIL_HOST=<mail_host>
  MAIL_PORT=<mail_port>
  MAIL_USERNAME=<mail_username>
  MAIL_PASSWORD=<mail_password>
  MAIL_ENCRYPTION=null
  MAIL_FROM_ADDRESS=<from_address>
  MAIL_FROM_NAME="${APP_NAME}"
  ```

### 3. Seed the database with websites
- Run `php artisan db:seed --class=WebsiteSeeder` to seed the database with website.


## Available API Routes
--------------------------------------------------------------------------
ROUTE                            | METHOD | Description
--------------------------------------------------------------------------
`/api/websites`                  | GET    | Get the list of available websites.
`/api/websites/{id}/posts`,      | GET    | Get the posts for a given website.
`/api/websites/{id}/posts/new`   | POST   | Create a new post for the given website.
`/websites/{id}/subscribers/new` | POST   | Subscribe a new user to specified website.


## Creating a new post
To create a new post, you have to have to know the website that the post belongs to.
So, do the following:
- Send a GET request to: `/api/websites` to get the list of available websites.
- Copy the ID of the website for which you want to create a post.
- Send a POST request to `/api/websites/1/posts/new` with the following data:
    - `title` [string] (required): The title of the post
    - `description` [string] (required): A brief descriptiion of the post.
    - `body` [string] (required): The body of the post.

## Subscribing a new user to a post
To subscribe a new user to a website,
- Send a GET request to: `/api/websites` to get the list of available websites.
- Copy the ID of the website for which you want to subscribe a user.
- Send a POST request to `/websites/{id}/subscribers/new` with the following body data:
  - subscriber_email [string] (required): The email of the user to subscribe
  - subscriber_name [string] (optional): The name of the user to subscribe.


## Sending out (or queueing) notifications of published posts
- Run the custom command `php artisan app:process-notifications` to queue notifications of published posts.

## Processing the queue
- Run `php artisan queue:work` to process the queued notifications.
