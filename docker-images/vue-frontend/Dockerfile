# build-stage
FROM node:lts-alpine as build-stage
ARG VITE_API_BASE_URL
ENV VITE_API_BASE_URL $VITE_API_BASE_URL

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY ./src ./src
COPY ./vite.config.ts ./vite.config.ts
COPY ./tsconfig.json ./tsconfig.json
COPY ./tsconfig.node.json ./tsconfig.node.json
COPY ./index.html ./index.html
COPY ./public ./public

RUN npm run build

# production-stage
FROM nginx:stable-alpine as production-stage
COPY --from=build-stage /app/dist /usr/share/nginx/html