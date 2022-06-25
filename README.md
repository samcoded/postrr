# Postrr

Postrr is a REST API server for a micro-blogging platform

Logged users can make and delete post, follow other users, like and comment on other post.

### Live demo

[postrr-coded.herokuapp.com/api (Hosted on Heroku)](https://postrr-coded.herokuapp.com/api)

### Tools

Built with Laravel 8, Postgres SQL and Laravel Santum for Authentication Tokens used for protected routes

### API Documentation

[Full API Documentation (Hosted on Postman)](https://documenter.getpostman.com/view/14158032/UzBsGPf5)
With Examples

### Routes

```
# Public

POST   /api/login
@body: email, password

POST   /api/register
@body: name, email, username, password, password_confirmation, bio


# Protected

-USER ROUTES
POST   /api/logout - logout

GET   /api/user - get current user

GET   /api/user/all - get all users

GET   /api/user/{user_id} - get user by id

-FOLLOW ROUTES
POST   /api/follow/{user_id} - toggle follow a user

GET   /api/user/{user_id}/followers - users followers

GET   /api/user/{user_id}/following - users following

-POSTS ROUTES
GET   /api/posts - get all posts

POST   /api/posts  - create a post
@body: body

GET   /api/posts/{post_id} - get post by id

PUT   /api/posts/{post_id}  - update post
@body: body

DELETE   /api/posts/{post_id} - delete a post

GET   /api/posts/search/{searchTerm} - search posts by searchTerm

GET   /api/user/{user_id}/posts - users posts

GET   /api/user/{user_id}/followings/posts - user's following posts

POST   /api/posts/{post_id}/like -toggle likes

GET   /api/posts/{post_id}/likes -get post likes

-COMMENTS ROUTES
POST   /api/posts/{post_id}/comments - create comment
@body: body

GET   /api/posts/{post_id}/comments - get comments

GET   /api/comments/{comment_id} - get comment

PUT   /api/comments/{comment_id} - update comment
@body: body

DELETE   /api/comments/{comment_id} - delete comment

```

### Migrations

To create all the nessesary tables and columns, run the following

```
php artisan migrate
```

### Usage

Change the _.env.example_ to _.env_ and add your database info

### Running Then App

Upload the files to your document root

```
php artisan serve

```

### Author

Samuel Anozie
