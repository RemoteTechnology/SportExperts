FROM node:16
WORKDIR /var/www/src
USER node
EXPOSE 5173
# https://github.com/vitejs/vite/discussions/3396
CMD ["sh", "-c", "npm install && npm run dev -- --host"]
ENTRYPOINT [ "npm",  "--ignore-platform-reqs"]