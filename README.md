# DeezerNotificationCenter
A Deezer test to build a Notification Center

The Makefile provides all commands needed to make sure the project can run.

## Requirements

- A MySQL instance.

## Setup

- Go in the .env file and setup your MySQL instance to be able to generate the database.
- Go to the route folder, and just run 
```
make package.install
make db.up
make fixture.load
make run.dev
```

And that's it
