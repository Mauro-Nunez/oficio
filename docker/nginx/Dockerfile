FROM alpine:3.18

RUN apk add --no-cache nginx

COPY nginx.prod.conf /etc/nginx/http.d/default.conf

RUN mkdir -p /run/nginx

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]