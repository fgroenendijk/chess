# base image
FROM php:8.0.5-cli-buster

# set working directory
WORKDIR /app

# add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# install and cache app dependencies
#RUN apt-get update
#RUN apt-get install libncurses-dev
#RUN pecl install ncurses

# add app
COPY . /app

# start app
#CMD php /app/queens.php
CMD while true; do sleep 3; done
