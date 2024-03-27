FROM node:14

WORKDIR /app/ev-charger-node

COPY package.json .
COPY package-lock.json .
RUN npm install

COPY . .

CMD ["tail", "-f", "/dev/null"]