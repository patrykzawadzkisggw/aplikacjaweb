FROM node:16@sha256:f77a1aef2da8d83e45ec990f45df50f1a286c5fe8bbfb8c6e4246c6389705c0b AS scss-builder


RUN npm install -g sass

WORKDIR /build

COPY . .

RUN sass css/style.scss css/style.css
RUN rm /build/css/*.scss \
    && rm /build/css/style.css.map \
    && rm -rf /build/css/components \
    && rm /build/init.sql

FROM php:apache@sha256:9bc5606262464d270e8f22bcfe93058547d26589a02c991bbe50de99edde8878

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=scss-builder /build /var/www/html/